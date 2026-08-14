<?php
/* -----------------------------------------------------------------------------------------
  $Id: admin/includes/modules/system/bx_eu_garan.php 1000 2026-04-04 13:00:00Z benax $

  modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2026 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );
  
class bx_eu_garan {
	public string $code;
	public string $version;
	public string $development_status;
	public string $title;
	public string $description;
	public int $sort_order;
	public string $enabled;
	private bool $_check;

	public function __construct() {
	  $this->code        = 'bx_eu_garan';
	  $this->version     = '1.7.2';
		$this->development_status = 'd'; // 'p' = production ready, 'd' = in development
	  $this->title       = MODULE_BX_EU_GARAN_TITLE;
	  $this->description = MODULE_BX_EU_GARAN_DESC;
	  $this->sort_order  = defined('MODULE_BX_EU_GARAN_SORT_ORDER') ? MODULE_BX_EU_GARAN_SORT_ORDER : 0;
	  $this->enabled     = ((defined('MODULE_BX_EU_GARAN_STATUS') && MODULE_BX_EU_GARAN_STATUS == 'True') ? true : false);
  }

	/**
     * Returns whether the module is installed.
     * @return bool
     * 
     * */
	public function check(): bool {
      if (!isset($this->_check)) {
        if (defined('MODULE_BX_EU_GARAN_STATUS')) {
          $this->_check = true;
        } else {
          $check_query = xtc_db_query("SELECT configuration_value 
                                         FROM " . TABLE_CONFIGURATION . " 
                                        WHERE configuration_key = 'MODULE_BX_EU_GARAN_STATUS'");
          $this->_check = xtc_db_num_rows($check_query);
        }
      }
      return $this->_check;
    }

	/**
	  * Configuration keys used by the module. Used when installing and removing the module.
	  *
	  * @return array
	  */
	public function keys(): array {
		$keys = array('MODULE_BX_EU_GARAN_VERSION',
					  			'MODULE_BX_EU_GARAN_STATUS',
					  			'MODULE_BX_EU_GARAN_CONFIG_ID',
				  				'MODULE_BX_EU_GARAN_WARRANTY_CONTENT_GROUP',
								 );
		return $keys;
    }

	/**
	  * Actions performed when the user clicks the install button.
	  *
	  * @return void
	  */
	public function install(): void {
	  xtc_db_query("ALTER TABLE ".TABLE_ADMIN_ACCESS." ADD ".$this->code." INTEGER(1) DEFAULT 0");
	  xtc_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET ".$this->code." = 1");

	  $freeId_query = xtc_db_query("SELECT MIN(configuration_group_id+1) AS id 
			                           					FROM ".TABLE_CONFIGURATION_GROUP." 
																				  WHERE (configuration_group_id+1) 
                                        		NOT IN (SELECT configuration_group_id FROM ".TABLE_CONFIGURATION_GROUP." 
																						         WHERE configuration_group_id IS NOT NULL);");
	  $freeId = xtc_db_fetch_array($freeId_query);


 	  $freeSort_query = xtc_db_query("SELECT MIN(sort_order+1) AS sort_order 
                                           FROM ".TABLE_CONFIGURATION_GROUP." 
                                          WHERE (sort_order+1) NOT IN (SELECT sort_order FROM ".TABLE_CONFIGURATION_GROUP." 
																					                              WHERE sort_order IS NOT NULL);");
	  $freeSort = xtc_db_fetch_array($freeSort_query);


	  xtc_db_query("INSERT INTO ".TABLE_CONFIGURATION_GROUP." ( configuration_group_id, 
																configuration_group_title, 
																configuration_group_description, 
																sort_order, 
																visible) 
													   VALUES ( ".$freeId["id"].", 
																'BX EU Garan Konfiguration', 
																'Modul einstellen und konfigurieren',
																".$freeSort["sort_order"].", 
																1)");

	  $query = "INSERT INTO ".TABLE_CONFIGURATION." ( 
														configuration_key, 
													  configuration_value, 
														configuration_group_id, 
														sort_order, 
														date_added, 
														use_function, 
														set_function )
									 VALUES ('MODULE_BX_EU_GARAN_STATUS', 'True', '".$freeId["id"]."', '1', NOW(), '', 'xtc_cfg_select_option(array(\'True\', \'False\'), '),
													('MODULE_BX_EU_GARAN_VERSION', '".$this->version."', '".$freeId["id"]."', '2', NOW(), '', 'bx_configuration_field_version('),
													('MODULE_BX_EU_GARAN_CONFIG_ID', '".$freeId["id"]."', '".$freeId["id"]."', '3', NOW(), '', 'bx_configuration_field_version('),
													('MODULE_BX_EU_GARAN_WARRANTY_CONTENT_GROUP', '0', '".$freeId["id"]."', '4', NOW(), 'xtc_cfg_display_content', 'xtc_cfg_select_content_module(')";
	  xtc_db_query($query);

		xtc_db_query("CREATE TABLE IF NOT EXISTS bx_products_warranty_guarantee (
								id INT AUTO_INCREMENT PRIMARY KEY,
								products_id INT NOT NULL UNIQUE,
								manufacturer_guarantee_available TINYINT(1) DEFAULT 0,
								guarantee_years INT DEFAULT 0,
								covers_full_product TINYINT(1) DEFAULT 1,
								requires_additional_cost TINYINT(1) DEFAULT 0,
								qr_url VARCHAR(500),
								created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
								updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
							) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

		xtc_db_query("CREATE TABLE IF NOT EXISTS bx_products_repairability (
								id INT AUTO_INCREMENT PRIMARY KEY,
								products_id INT NOT NULL UNIQUE,
								repair_score TINYINT UNSIGNED DEFAULT NULL,
								parts_available TINYINT(1) DEFAULT NULL,
								parts_cost_info VARCHAR(500) DEFAULT NULL,
								manual_url VARCHAR(500) DEFAULT NULL,
								repair_restrictions TEXT DEFAULT NULL,
								created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
								updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
							) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

		xtc_db_query("CREATE TABLE IF NOT EXISTS bx_eu_garan_mass_log (
								id INT AUTO_INCREMENT PRIMARY KEY,
								executed_at DATETIME NOT NULL,
								affected_products_count INT NOT NULL,
								filters_json TEXT NOT NULL,
								changes_json TEXT NOT NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

		xtc_db_query("CREATE TABLE IF NOT EXISTS bx_eu_garan_presets (
								id INT AUTO_INCREMENT PRIMARY KEY,
								preset_name VARCHAR(255) NOT NULL,
								preset_data_json TEXT NOT NULL,
								created_at DATETIME NOT NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

		$this->addProductsForeignKeyIfPossible('bx_products_warranty_guarantee', 'fk_bx_eu_garan_warranty_products');
		$this->addProductsForeignKeyIfPossible('bx_products_repairability', 'fk_bx_eu_garan_repair_products');
	}

		public function update() {}

		/**
		 * Add products_id foreign key if environment supports it and constraint does not already exist.
		 *
		 * @param string $tableName
		 * @param string $constraintName
		 *
		 * @return void
		 */
		private function addProductsForeignKeyIfPossible(string $tableName, string $constraintName): void {
			if ($this->foreignKeyExists($tableName, $constraintName) === true) {
				return;
			}

			if ($this->isInnoDbTable($tableName) === false || $this->isInnoDbTable(TABLE_PRODUCTS) === false) {
				return;
			}

			xtc_db_query("ALTER TABLE ".$tableName."
				ADD CONSTRAINT ".$constraintName."
				FOREIGN KEY (products_id) REFERENCES ".TABLE_PRODUCTS."(products_id) ON DELETE CASCADE");
		}

		/**
		 * Checks whether a foreign key already exists.
		 *
		 * @param string $tableName
		 * @param string $constraintName
		 *
		 * @return bool
		 */
		private function foreignKeyExists(string $tableName, string $constraintName): bool {
			$dbQuery = xtc_db_query("SELECT DATABASE() AS db_name");
			if ($dbQuery === false || xtc_db_num_rows($dbQuery) < 1) {
				return false;
			}

			$dbRow = xtc_db_fetch_array($dbQuery);
			if (empty($dbRow['db_name'])) {
				return false;
			}

			$constraintQuery = xtc_db_query("SELECT CONSTRAINT_NAME
				FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
				WHERE CONSTRAINT_SCHEMA = '".xtc_db_input($dbRow['db_name'])."'
					AND TABLE_NAME = '".xtc_db_input($tableName)."'
					AND CONSTRAINT_NAME = '".xtc_db_input($constraintName)."'
					AND CONSTRAINT_TYPE = 'FOREIGN KEY'");

			return ($constraintQuery !== false && xtc_db_num_rows($constraintQuery) > 0);
		}

		/**
		 * Checks if a table uses the InnoDB storage engine.
		 *
		 * @param string $tableName
		 *
		 * @return bool
		 */
		private function isInnoDbTable(string $tableName): bool {
			$statusQuery = xtc_db_query("SHOW TABLE STATUS LIKE '".xtc_db_input($tableName)."'");
			if ($statusQuery === false || xtc_db_num_rows($statusQuery) < 1) {
				return false;
			}

			$statusRow = xtc_db_fetch_array($statusQuery);
			return (isset($statusRow['Engine']) && strtoupper((string)$statusRow['Engine']) === 'INNODB');
		}
	  
	/**
	  * Actions performed when the user clicks the uninstall button.
	  *
	  * @return void
	  */
	  
	public function remove(): void {
		global $messageStack;

		if ($this->bx_module_installed(MODULE_CATEGORIES_INSTALLED, 'bx_eu_garan_categories.php')) {
    	$messageStack->add_session(MODULE_BX_EU_GARAN_CATEGORIES_DEINSTALL_FIRST, 'error');
			xtc_redirect(xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=bx_eu_garan'));
			exit();
		}
		
		if ($this->bx_module_installed(MODULE_ORDER_INSTALLED, 'bx_eu_garan_order.php')) {
    	$messageStack->add_session(MODULE_BX_EU_GARAN_ORDER_DEINSTALL_FIRST, 'error');
			xtc_redirect(xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=bx_eu_garan'));
			exit();
		}
		
		if ($this->bx_module_installed(MODULE_SHOPPING_CART_INSTALLED, 'bx_eu_garan_cart.php')) {
    	$messageStack->add_session(MODULE_BX_EU_GARAN_CART_DEINSTALL_FIRST, 'error');
			xtc_redirect(xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=bx_eu_garan'));
			exit();
		}

	  xtc_db_query("DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key in ('".implode("', '", $this->keys())."')");
	  xtc_db_query("DELETE FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title = 'BX EU Garan Konfiguration'");
	  xtc_db_query("ALTER TABLE ".TABLE_ADMIN_ACCESS." DROP ".$this->code);
		xtc_db_query("DROP TABLE IF EXISTS bx_products_warranty_guarantee");
		xtc_db_query("DROP TABLE IF EXISTS bx_products_repairability");
		xtc_db_query("DROP TABLE IF EXISTS bx_eu_garan_mass_log");
		xtc_db_query("DROP TABLE IF EXISTS bx_eu_garan_presets");
		
		xtc_redirect(xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system'));
		exit();
  }

	public function process(): void { }
	  
	/**
	  * Additional HTML to show during module configuration.
	  *
	  * @return array
	  */ 
	public function display(): array {
    return array('text' => '<div style="text-align: center;">'.xtc_button(BUTTON_SAVE).xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_MODULE_EXPORT, 'set='.$_GET['set'].'&module='.$this->code))."</div>");
  }
	  
	public function custom() {
	  global $messageStack;
	  $result = true;

	  // Dateien definieren
	  $dirs_and_files   = array();
		$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'images/icons/heading/bx_eu_garan.png';
		$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'includes/extra/css/bx_eu_garan.php';
		$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'includes/extra/filenames/bx_eu_garan.php';
		$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'includes/extra/functions/bx_eu_garan.php';
		$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'includes/extra/javascript/bx_eu_garan.php';
		$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'includes/extra/menu/bx_eu_garan.php';
		$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'includes/extra/modules/new_product/bx_eu_garan.php';
		$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'includes/modules/categories/bx_eu_garan_categories.php';
		$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'includes/modules/system/bx_eu_garan.php';

		$dirs_and_files[] = DIR_FS_CATALOG.'includes/classes/bx_dependency_resolver.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'includes/extra/header/header_head/bx_eu_garan.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'includes/extra/modules/order_details_cart_content/bx_eu_garan.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'includes/extra/modules/product_info_end/bx_eu_garan.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'includes/modules/order/bx_eu_garan_order.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'includes/modules/shopping_cart/bx_eu_garan_cart.php';

		$dirs_and_files[] = DIR_FS_CATALOG.'media/content/warranty_guarantee.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'images/warranty_guarantee/';

		$dirs_and_files[] = DIR_FS_CATALOG.'lang/english/extra/bx_eu_garan.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'lang/english/modules/categories/bx_eu_garan_categories.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'lang/english/modules/order/bx_eu_garan_order.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'lang/english/modules/shopping_cart/bx_eu_garan_cart.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'lang/english/modules/system/bx_eu_garan.php';

		$dirs_and_files[] = DIR_FS_CATALOG.'lang/german/extra/bx_eu_garan.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'lang/german/modules/categories/bx_eu_garan_categories.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'lang/german/modules/order/bx_eu_garan_order.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'lang/german/modules/shopping_cart/bx_eu_garan_cart.php';
		$dirs_and_files[] = DIR_FS_CATALOG.'lang/german/modules/system/bx_eu_garan.php';
/*
		$dirs_and_files[] = DIR_FS_CATALOG.'templates/tpl_modified_nova/module/checkout_confirmation.html';
		$dirs_and_files[] = DIR_FS_CATALOG.'templates/tpl_modified_nova/module/order_details.html';
		$dirs_and_files[] = DIR_FS_CATALOG.'templates/tpl_modified_nova/module/product_info/product_info_v1_tabs.html';

		$dirs_and_files[] = DIR_FS_CATALOG.'templates/tpl_modified_responsive/module/checkout_confirmation.html';
		$dirs_and_files[] = DIR_FS_CATALOG.'templates/tpl_modified_responsive/module/order_details.html';
		$dirs_and_files[] = DIR_FS_CATALOG.'templates/tpl_modified_responsive/module/product_info/product_info_tabs_v1.html';
*/
	  // Dateien löschen
	  foreach ($dirs_and_files as $dir_or_file) {
			if (!$this->secureDelete($dir_or_file)) {
				$messageStack->add_session(MODULE_BX_EU_GARAN_TEXT_COULD_NOT_BE_DELETED.' '.$dir_or_file, 'error');
				$result = false;
			}
	  }
		  
	  if ($result === true) {
		  $messageStack->add_session(MODULE_BX_EU_GARAN_TEXT_SUCCESSFULLY_REMOVED, 'success');
    } else {
		  $messageStack->add_session(MODULE_BX_EU_GARAN_TEXT_REMOVAL_INCOMPLETE, 'error');
    }
		  
	  // Datei selbst löschen
	  $this->secureDelete(DIR_FS_CATALOG.DIR_ADMIN.'includes/modules/system/bx_eu_garan.php');

    xtc_redirect(xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system'));
  }

  private function secureDelete(string $path): bool {
    // 1. Existiert der Pfad überhaupt?
    if (!file_exists($path)) {
      return true;
    }

    // --- SICHERHEITS-CHECK ---
    // Holt den echten, bereinigten Pfad (löst relative Teile auf)
    $realPath  = realpath($path);
    $rootPath = realpath(DIR_FS_CATALOG);

    // Sicherheitsregel A: Pfad darf nicht leer sein
    if (empty($realPath) || empty($rootPath)) {
      return false;
    }

    // Sicherheitsregel B: Wenn der Pfad EXAKT dein Admin-Hauptordner 
    // oder das Hauptverzeichnis (/) ist -> SOFORT ABBRECHEN!
    if ($realPath === $rootPath || $realPath === DIRECTORY_SEPARATOR) {
      return false;
    }

    // Sicherheitsregel C: Der Pfad muss unterhalb von $rootPath liegen.
    if (strpos($realPath, $rootPath . DIRECTORY_SEPARATOR) !== 0) {
      return false;
    }
    // -----------------------------------

    if (!is_writable($realPath)) {
      return false;
    }

    // Wenn es eine Datei oder ein Symlink ist -> nur diese löschen und beenden!
    if (!is_dir($realPath) || is_link($realPath)) {
      return unlink($realPath);
    }

    // Nur wenn es ein Ordner ist, wird tiefer gegangen
    // Eigene Rekursion statt RecursiveDirectoryIterator: so entscheiden wir
    // selbst, dass Symlinks auf Verzeichnisse NICHT verfolgt werden, und
    // prüfen bei jedem einzelnen Element erneut, ob wir noch innerhalb von
    // $rootPath sind (Schutz vor präparierten Symlinks im Verzeichnisbaum).
    if (!$this->deleteDirectoryContents($realPath, $rootPath)) {
      return false;
    }

    return rmdir($realPath);
  }

  /**
   * Recursively deletes the contents of a directory without following
   * symlinked subdirectories, verifying that every item stays within
   * $rootPath before it is touched.
   *
   * @param string $dir       Real, resolved path of the directory to empty.
   * @param string $rootPath Real, resolved path of the allowed root.
   *
   * @return bool
   */
  private function deleteDirectoryContents(string $dir, string $rootPath): bool {
    $entries = scandir($dir);
    if ($entries === false) {
      return false;
    }

    foreach ($entries as $entry) {
      if ($entry === '.' || $entry === '..') {
        continue;
      }

      $itemPath = $dir . DIRECTORY_SEPARATOR . $entry;

      // Symlinks NIEMALS verfolgen - nur den Link selbst entfernen, nie das Ziel.
      if (is_link($itemPath)) {
        if (!unlink($itemPath)) {
          return false;
        }
        continue;
      }

      // Defense in depth: bei jedem Element erneut sicherstellen, dass der
      // aufgelöste Pfad noch innerhalb von $rootPath liegt.
      $realItemPath = realpath($itemPath);
      if ($realItemPath === false || strpos($realItemPath, $rootPath . DIRECTORY_SEPARATOR) !== 0) {
        return false;
      }

      if (!is_writable($realItemPath)) {
        return false;
      }

      if (is_dir($realItemPath)) {
        if (!$this->deleteDirectoryContents($realItemPath, $rootPath)) {
          return false;
        }
        if (!rmdir($realItemPath)) {
          return false;
        }
      } else {
        if (!unlink($realItemPath)) {
          return false;
        }
      }
    }

    return true;
  }

	private function bx_module_installed(string $moduleList, string $moduleFile): bool {
		return in_array($moduleFile, explode(';', $moduleList), true);
	}
}
