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
	  $this->version     = '1.0.0';
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
									 VALUES ('MODULE_BX_EU_GARAN_STATUS', 'True', '6', '1', NOW(), '', 'xtc_cfg_select_option(array(\'True\', \'False\'), '),
													('MODULE_BX_EU_GARAN_VERSION', '".$this->version."', '6', '2', NOW(), '', 'bx_configuration_field_version('),
													('MODULE_BX_EU_GARAN_CONFIG_ID', '".$freeId["id"]."', '6', '3', NOW(), '', 'bx_configuration_field_version('),
													('MODULE_BX_EU_GARAN_WARRANTY_CONTENT_GROUP', '0', '6', '4', NOW(), 'xtc_cfg_display_content', 'xtc_cfg_select_content_module(')";
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
	  xtc_db_query("DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key in ('".implode("', '", $this->keys())."')");
	  xtc_db_query("DELETE FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title = 'BX EU Garan Konfiguration'");
	  xtc_db_query("ALTER TABLE ".TABLE_ADMIN_ACCESS." DROP ".$this->code);
		xtc_db_query("DROP TABLE IF EXISTS bx_products_warranty_guarantee");
		xtc_db_query("DROP TABLE IF EXISTS bx_products_repairability");
		xtc_db_query("DROP TABLE IF EXISTS bx_eu_garan_mass_log");
		xtc_db_query("DROP TABLE IF EXISTS bx_eu_garan_presets");
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
		  
	  // Systemmodule deinstallieren
	  $this->remove();
		  
	  // Dateien definieren
	  $dirs_and_files   = array();
	  $dirs_and_files[] = DIR_FS_ADMIN.'bx_eu_garan.php';
		
	  $dirs_and_files[] = DIR_FS_ADMIN.DIR_WS_INCLUDES.'extra/css/bx_eu_garan.php';
	  $dirs_and_files[] = DIR_FS_ADMIN.DIR_WS_INCLUDES.'extra/filenames/bx_eu_garan.php';
	  $dirs_and_files[] = DIR_FS_ADMIN.DIR_WS_INCLUDES.'extra/javascript/bx_eu_garan.php';
	  $dirs_and_files[] = DIR_FS_ADMIN.DIR_WS_INCLUDES.'extra/menu/bx_eu_garan.php';
	  
	  $dirs_and_files[] = DIR_FS_CATALOG.'lang/german/modules/system/bx_eu_garan.php';
	  $dirs_and_files[] = DIR_FS_CATALOG.'lang/english/modules/system/bx_eu_garan.php';
	  $dirs_and_files[] = DIR_FS_CATALOG.'lang/german/admin/bx_eu_garan.php';
	  $dirs_and_files[] = DIR_FS_CATALOG.'lang/english/admin/bx_eu_garan.php';
		  
	  // Dateien löschen
	  foreach ($dirs_and_files as $dir_or_file) {
			if (!$this->rrmdir($dir_or_file)) {
				$messageStack->add_session($dir_or_file.MODULE_BX_EU_GARAN_TEXT_COULD_NOT_BE_DELETED, 'error');
				$result = false;
			}
	  }
		  
	  if ($result === true) {
		  $messageStack->add_session(MODULE_BX_EU_GARAN_TEXT_SUCCESSFULLY_REMOVED, 'success');
      } else {
		  $messageStack->add_session(MODULE_BX_EU_GARAN_TEXT_REMOVAL_INCOMPLETE, 'error');
      }
		  
	  // Datei selbst löschen
	  unlink(DIR_FS_CATALOG.DIR_ADMIN.'includes/modules/system/bx_eu_garan.php');
  }
	  
	private function rrmdir(string $dir): bool {
	  if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir") {
						$this->rrmdir($dir."/".$object);
					} else {
						unlink($dir."/".$object);
					}
				}
			}
			reset($objects);
			rmdir($dir);
			return true;
    } elseif (is_file($dir)) {
	    unlink($dir);
			return true;
    } else {
	    return false;
  }
	}
}
