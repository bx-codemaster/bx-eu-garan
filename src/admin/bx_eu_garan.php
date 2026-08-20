<?php
/** 
 * ██████╗  ███████╗ ███╗   ██╗  █████╗  ██╗  ██╗
 * ██╔══██╗ ██╔════╝ ████╗  ██║ ██╔══██╗ ╚██╗██╔╝
 * ██████╔╝ █████╗   ██╔██╗ ██║ ███████║  ╚███╔╝
 * ██╔══██╗ ██╔══╝   ██║╚██╗██║ ██╔══██║  ██╔██╗
 * ██████╔╝ ███████╗ ██║ ╚████║ ██║  ██║ ██╔╝ ██╗
 * ╚═════╝  ╚══════╝ ╚═╝  ╚═══╝ ╚═╝  ╚═╝ ╚═╝  ╚═╝
 * BX EU Garan - Admin Interface
 * 
 * @package    BX EU Garan
 * @subpackage Admin
 * @category   Product Management
 * @author     Axel Benkert
 * @website    https://www.bx-coding.de
 * @version    1.8.5
 * @date       2026-08-19
 * @copyright  2020-2026 Axel Benkert
 * @license    GNU General Public License
 * 
 * @changelog
 * Version 1.0.0 (2026-04-05):
 */

  require('includes/application_top.php');

  include_once(DIR_FS_INC.'xtc_get_manufacturers.inc.php');

  if (strpos(MODULE_CATEGORIES_INSTALLED, 'bx_eu_garan_categories.php') === false) {
    $messageStack->add(MODULE_BX_EU_GARAN_CATEGORIES_INSTALL_FIRST, 'error');
  }
  
  if (strpos(MODULE_ORDER_INSTALLED, 'bx_eu_garan_order.php') === false) {
    $messageStack->add(MODULE_BX_EU_GARAN_ORDER_INSTALL_FIRST, 'error');
  }
  
  if (strpos(MODULE_SHOPPING_CART_INSTALLED, 'bx_eu_garan_cart.php') === false) {
    $messageStack->add(MODULE_BX_EU_GARAN_CART_INSTALL_FIRST, 'error');
  }
  
  $action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : NULL);

  $languagesId  = isset($_SESSION['languages_id']) ? (int)$_SESSION['languages_id'] : 2;
  $previewCount = null;
  $feedback     = array();
  $warrantyContentGroupId = isset($_POST['warranty_content_group'])
    ? max(0, (int)$_POST['warranty_content_group'])
    : max(0, (int)bx_eu_garan_get_configuration_value('MODULE_BX_EU_GARAN_WARRANTY_CONTENT_GROUP', '0'));

  // 1. Priorität: Das Formular wurde abgeschickt (POST) -> Werte live parsen
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $manufacturerGuaranteeAvailableRaw = isset($_POST['configuration']['manufacturer_guarantee_available']) ? (string)$_POST['configuration']['manufacturer_guarantee_available'] : 'false';
    $requiresAdditionalCostRaw         = isset($_POST['configuration']['requires_additional_cost']) ? (string)$_POST['configuration']['requires_additional_cost'] : 'false';
    $coversFullProductRaw              = isset($_POST['configuration']['covers_full_product']) ? (string)$_POST['configuration']['covers_full_product'] : 'false';
    $parts_availableRaw                = isset($_POST['configuration']['parts_available']) ? (string)$_POST['configuration']['parts_available'] : 'false';

    $formData = array(
      'filter_category_id'           => isset($_POST['filter_category_id']) ? (int)$_POST['filter_category_id'] : 0,
      'filter_include_subcategories' => isset($_POST['filter_include_subcategories']) ? 1 : 0,
      'filter_manufacturers_id'      => isset($_POST['filter_manufacturers_id']) ? (string)$_POST['filter_manufacturers_id'] : '',
      'filter_status'                => isset($_POST['filter_status']) ? (string)$_POST['filter_status'] : '',
      
      'set_manufacturer_guarantee_available' => isset($_POST['set_manufacturer_guarantee_available']) ? 1 : 0,
      'manufacturer_guarantee_available'     => ($manufacturerGuaranteeAvailableRaw === 'true') ? 1 : 0,
      
      'set_guarantee_years'          => isset($_POST['set_guarantee_years']) ? 1 : 0,
      'guarantee_years'              => isset($_POST['guarantee_years']) ? max(0, (int)$_POST['guarantee_years']) : 2,

      'set_covers_full_product'      => isset($_POST['set_covers_full_product']) ? 1 : 0,
      'covers_full_product'          => ($coversFullProductRaw === 'true') ? 1 : 0,

      'set_requires_additional_cost' => isset($_POST['set_requires_additional_cost']) ? 1 : 0,
      'requires_additional_cost'     => ($requiresAdditionalCostRaw === 'true') ? 1 : 0,
      
      'set_qr_url'                   => isset($_POST['set_qr_url']) ? 1 : 0,
      'qr_url'                       => isset($_POST['qr_url']) ? trim((string)$_POST['qr_url']) : '',
      
      'set_repair_score'             => isset($_POST['set_repair_score']) ? 1 : 0,
      'repair_score'                 => isset($_POST['repair_score']) ? max(0, min(10, (int)$_POST['repair_score'])) : 0,
      
      'set_parts_available'          => isset($_POST['set_parts_available']) ? 1 : 0,
      'parts_available'              => ($parts_availableRaw === 'true') ? 1 : 0,

      'set_parts_cost_info'          => isset($_POST['set_parts_cost_info']) ? 1 : 0,
      'parts_cost_info'              => isset($_POST['parts_cost_info']) ? trim((string)$_POST['parts_cost_info']) : '',
      
      'set_repair_restrictions'      => isset($_POST['set_repair_restrictions']) ? 1 : 0,
      'repair_restrictions'          => isset($_POST['repair_restrictions']) ? trim((string)$_POST['repair_restrictions']) : '',

      'set_parts_availability_years' => isset($_POST['set_parts_availability_years']) ? 1 : 0,
      'parts_availability_years'     => isset($_POST['parts_availability_years']) ? trim((string)$_POST['parts_availability_years']) : '',
      
      'set_repair_service_url'       => isset($_POST['set_repair_service_url']) ? 1 : 0,
      'repair_service_url'           => isset($_POST['repair_service_url']) ? trim((string)$_POST['repair_service_url']) : '',

      'set_manual_url'               => isset($_POST['set_manual_url']) ? 1 : 0,
      'manual_url'                   => isset($_POST['manual_url']) ? trim((string)$_POST['manual_url']) : '',
    );      
    // Neue Werte direkt für den nächsten (Redirect-)Aufruf sichern
    $_SESSION['bx_eu_garan_last_filters'] = $formData;

  // 2. Priorität: Kein POST, aber alte Werte im Session-Speicher (z.B. nach einem xtc_redirect)
  } elseif (isset($_SESSION['bx_eu_garan_last_filters'])) {
    $formData = $_SESSION['bx_eu_garan_last_filters'];

  // 3. Priorität: Erster Aufruf der Seite (weder POST noch Session vorhanden) -> Leere Standardwerte
  } else {
    $formData = array(
      'filter_category_id'           => 0,
      'filter_include_subcategories' => 1,
      'filter_manufacturers_id'      => '',
      'filter_status'                => '',
      'manufacturer_guarantee_available' => 0,
      'set_manufacturer_guarantee_available' => 0, 
      'set_guarantee_years'          => 0, 'guarantee_years' => 2,
      'set_covers_full_product'      => 0, 'covers_full_product' => 0,
      'set_requires_additional_cost' => 0, 'requires_additional_cost' => 0,
      'set_qr_url'                   => 0, 'qr_url' => '',
      'set_repair_score'             => 0, 'repair_score' => 0,
      'set_parts_available'          => 0, 'parts_available' => 0,
      'set_parts_cost_info'          => 0, 'parts_cost_info' => '',
      'set_repair_restrictions'      => 0, 'repair_restrictions' => '',
      'set_parts_availability_years' => 0, 'parts_availability_years' => 0,
      'set_repair_service_url'       => 0, 'repair_service_url' => '',
      'set_manual_url'               => 0, 'manual_url' => ''
    );
    $_SESSION['bx_eu_garan_last_filters'] = $formData;
  }

  switch ($action) {
    case 'save_warranty_content':
      bx_eu_garan_set_configuration_value('MODULE_BX_EU_GARAN_WARRANTY_CONTENT_GROUP', (string)$warrantyContentGroupId);

      $messageStack->add_session(TEXT_BX_EU_GARAN_FEEDBACK_WARRANTY_CONTENT_SAVED, 'success');
      xtc_redirect(xtc_href_link(FILENAME_BX_EU_GARAN, '', 'SSL'));
      break;

    case 'preview':
    case 'apply_mass_update':
      // 1. GEMEINSAMER ANFANG: Betroffene Produkte ermitteln
      $productIds = bx_eu_garan_get_product_ids(
        $formData['filter_category_id'],
        $formData['filter_include_subcategories'] === 1,
        $formData['filter_manufacturers_id'],
        $formData['filter_status']
      );

      $previewCount = count($productIds);

      // Gemeinsamer Check: Wenn gar keine Produkte gefunden wurden, brechen wir für beide Aktionen ab
      if ($previewCount === 0) {
        $messageStack->add_session(TEXT_BX_EU_GARAN_FEEDBACK_NO_PRODUCTS_FOUND, 'error');
        xtc_redirect(xtc_href_link(FILENAME_BX_EU_GARAN, '', 'SSL'));
      }

      // ---------------------------------------------------------------------------------
      // FALL A: Reine Vorschau (Wurde 'preview' geklickt?)
      // ---------------------------------------------------------------------------------
      if ($action === 'preview') {
        $messageStack->add_session(sprintf(TEXT_BX_EU_GARAN_PREVIEW_RESULT, (int)$previewCount), 'success');
        xtc_redirect(xtc_href_link(FILENAME_BX_EU_GARAN, '', 'SSL'));
      }

      // ---------------------------------------------------------------------------------
      // FALL B: Massenupdate ausführen (Wurde 'apply_mass_update' geklickt?)
      // ---------------------------------------------------------------------------------
      if ($action === 'apply_mass_update') {
        $warrantyColumns = array();
        $warrantyValues  = array();
        $warrantyUpdates = array();
        $repairColumns   = array();
        $repairValues    = array();
        $repairUpdates   = array();

        if ($formData['set_manufacturer_guarantee_available'] === 1) {
          $warrantyColumns[] = 'manufacturer_guarantee_available';
          $warrantyValues[]  = "'".(int)$formData['manufacturer_guarantee_available']."'";
          $warrantyUpdates[] = "manufacturer_guarantee_available = VALUES(manufacturer_guarantee_available)";
        }
        if ($formData['set_guarantee_years'] === 1) {
          $warrantyColumns[] = 'guarantee_years';
          $warrantyValues[]  = "'".(int)$formData['guarantee_years']."'";
          $warrantyUpdates[] = "guarantee_years = VALUES(guarantee_years)";
        }
        if ($formData['set_covers_full_product'] === 1) {
          $warrantyColumns[] = 'covers_full_product';
          $warrantyValues[]  = "'".(int)$formData['covers_full_product']."'";
          $warrantyUpdates[] = "covers_full_product = VALUES(covers_full_product)";
        }
        if ($formData['set_requires_additional_cost'] === 1) {
          $warrantyColumns[] = 'requires_additional_cost';
          $warrantyValues[]  = "'".(int)$formData['requires_additional_cost']."'";
          $warrantyUpdates[] = "requires_additional_cost = VALUES(requires_additional_cost)";
        }
        if ($formData['set_qr_url'] === 1) {
          $warrantyColumns[] = 'qr_url';
          $warrantyValues[]  = bx_eu_garan_to_nullable_string($formData['qr_url']);
          $warrantyUpdates[] = "qr_url = VALUES(qr_url)";
        }
        if ($formData['set_repair_score'] === 1) {
          $repairColumns[] = 'repair_score';
          $repairValues[]  = "'".(int)$formData['repair_score']."'";
          $repairUpdates[] = "repair_score = VALUES(repair_score)";
        }
        if ($formData['set_parts_available'] === 1) {
          $repairColumns[] = 'parts_available';
          $repairValues[]  = "'".(int)$formData['parts_available']."'";
          $repairUpdates[] = "parts_available = VALUES(parts_available)";
        }
        if ($formData['set_parts_cost_info'] === 1) {
          $repairColumns[] = 'parts_cost_info';
          $repairValues[]  = bx_eu_garan_to_nullable_string($formData['parts_cost_info']);
          $repairUpdates[] = "parts_cost_info = VALUES(parts_cost_info)";
        }
        if ($formData['set_repair_restrictions'] === 1) {
          $repairColumns[] = 'repair_restrictions';
          $repairValues[]  = bx_eu_garan_to_nullable_string($formData['repair_restrictions']);
          $repairUpdates[] = "repair_restrictions = VALUES(repair_restrictions)";
        }
        if ($formData['set_parts_availability_years'] === 1) {
          $repairColumns[] = 'parts_availability_years';
          $repairValues[]  = "'".(int)$formData['parts_availability_years']."'";
          $repairUpdates[] = "parts_availability_years = VALUES(parts_availability_years)";
        }
        if ($formData['set_repair_service_url'] === 1) {
          $repairColumns[] = 'repair_service_url';
          $repairValues[]  = bx_eu_garan_to_nullable_string($formData['repair_service_url']);
          $repairUpdates[] = "repair_service_url = VALUES(repair_service_url)";
        }
        if ($formData['set_manual_url'] === 1) {
          $repairColumns[] = 'manual_url';
          $repairValues[]  = bx_eu_garan_to_nullable_string($formData['manual_url']);
          $repairUpdates[] = "manual_url = VALUES(manual_url)";
        }

        // Check: Wurde überhaupt mindestens eine Checkbox zum Ändern angehakt?
        if (empty($warrantyUpdates) && empty($repairUpdates)) {
          $messageStack->add_session(TEXT_BX_EU_GARAN_FEEDBACK_SELECT_AT_LEAST_ONE_FIELD, 'error');
          xtc_redirect(xtc_href_link(FILENAME_BX_EU_GARAN, '', 'SSL'));
        }

        // Hier startet die eigentliche Speicherung, da $previewCount garantiert > 0 ist
        $updatedProducts = 0;
        $warrantyCount   = 0;
        $repairCount     = 0;

        foreach ($productIds as $productId) {
          $productId = (int)$productId;

          // Werte müssen auch im INSERT-Teil stehen, sonst bleiben sie bei einer neuen Zeile auf den Spalten-Defaults
          if (!empty($warrantyUpdates)) {
            $warrantySql = "INSERT INTO bx_products_warranty_guarantee (products_id, ".implode(', ', $warrantyColumns).", created_at, updated_at)
                            VALUES ('".$productId."', ".implode(', ', $warrantyValues).", NOW(), NOW())
                            ON DUPLICATE KEY UPDATE ".implode(', ', $warrantyUpdates).", updated_at = NOW()";
            xtc_db_query($warrantySql);
            $warrantyCount++;
          }

          if (!empty($repairUpdates)) {
            $repairSql = "INSERT INTO bx_products_repairability (products_id, ".implode(', ', $repairColumns).", created_at, updated_at)
                          VALUES ('".$productId."', ".implode(', ', $repairValues).", NOW(), NOW())
                          ON DUPLICATE KEY UPDATE ".implode(', ', $repairUpdates).", updated_at = NOW()";
            xtc_db_query($repairSql);
            $repairCount++;
          }

          $updatedProducts++;
        }

        // --- PHASE 2: DATENBANK-LOG ---
        if ($updatedProducts > 0) {
            // Wir trennen die Filter von den gesetzten Werten für bessere Übersicht im Log
            $logFilters = [
                'filter_category_id'           => $formData['filter_category_id'],
                'filter_include_subcategories' => $formData['filter_include_subcategories'],
                'filter_manufacturers_id'      => $formData['filter_manufacturers_id'],
                'filter_status'                => $formData['filter_status']
            ];

            $logChanges = [];
            if ($formData['set_manufacturer_guarantee_available']) $logChanges['manufacturer_guarantee_available'] = $formData['manufacturer_guarantee_available'];
            if ($formData['set_guarantee_years'])                  $logChanges['guarantee_years']                  = $formData['guarantee_years'];
            if ($formData['set_covers_full_product'])              $logChanges['covers_full_product']              = $formData['covers_full_product'];
            if ($formData['set_requires_additional_cost'])         $logChanges['requires_additional_cost']         = $formData['requires_additional_cost'];
            if ($formData['set_qr_url'])                           $logChanges['qr_url']                           = $formData['qr_url'];
            if ($formData['set_repair_score'])                     $logChanges['repair_score']                     = $formData['repair_score'];
            if ($formData['set_parts_available'])                  $logChanges['parts_available']                  = $formData['parts_available'];
            if ($formData['set_parts_cost_info'])                  $logChanges['parts_cost_info']                  = $formData['parts_cost_info'];
            if ($formData['set_repair_restrictions'])              $logChanges['repair_restrictions']              = $formData['repair_restrictions'];
            if ($formData['set_parts_availability_years'])         $logChanges['parts_availability_years']         = $formData['parts_availability_years'];
            if ($formData['set_repair_service_url'])               $logChanges['repair_service_url']               = $formData['repair_service_url'];
            if ($formData['set_manual_url'])                       $logChanges['manual_url']                       = $formData['manual_url'];

            // Log-Eintrag in die Datenbank schreiben
            xtc_db_query("
                INSERT INTO bx_eu_garan_mass_log 
                (executed_at, affected_products_count, filters_json, changes_json) 
                VALUES (
                    NOW(),
                    " . (int)$updatedProducts . ",
                    '" . xtc_db_input(json_encode($logFilters, JSON_UNESCAPED_UNICODE)) . "',
                    '" . xtc_db_input(json_encode($logChanges, JSON_UNESCAPED_UNICODE)) . "'
                )
            ");
        }
        // --- ENDE PHASE 2 ---
        
        $messageStack->add_session(sprintf(TEXT_BX_EU_GARAN_FEEDBACK_SUCCESS, $updatedProducts, $warrantyCount, $repairCount), 'success');
      
      if (isset($_SESSION['bx_eu_garan_last_filters'])) {
        unset($_SESSION['bx_eu_garan_last_filters']);
      }
        xtc_redirect(xtc_href_link(FILENAME_BX_EU_GARAN, '', 'SSL'));
      }  
      break;

    // --- PHASE 3: PRESET ACTIONS ---
    case 'save_preset':
      $presetName = isset($_POST['preset_name']) ? trim((string)$_POST['preset_name']) : '';
      if (!empty($presetName)) {
        // Wir speichern das komplette aktuelle $formData-Array ab
        xtc_db_query("
            INSERT INTO `bx_eu_garan_presets` 
            (`preset_name`, `preset_data_json`, `created_at`) 
            VALUES (
                '" . xtc_db_input($presetName) . "',
                '" . xtc_db_input(json_encode($formData, JSON_UNESCAPED_UNICODE)) . "',
                NOW()
            )
        ");
        // Erfolgsmeldung setzen (Falls dein System eine MessageStack-Klasse nutzt)
        $messageStack->add_session('Preset erfolgreich gespeichert!', 'success');
      }
      xtc_redirect(xtc_href_link('bx_eu_garan.php'));
      break;
    case 'load_preset':
      $presetId = isset($_GET['preset_id']) ? (int)$_GET['preset_id'] : 0;
      if ($presetId > 0) {
        $preset_query = xtc_db_query("SELECT preset_data_json FROM bx_eu_garan_presets WHERE id = '" . $presetId . "' LIMIT 1");
        if ($preset_query && xtc_db_num_rows($preset_query) > 0) {
          $preset_arr = xtc_db_fetch_array($preset_query);
          $decodedData = json_decode($preset_arr['preset_data_json'], true);
          
          if (is_array($decodedData)) {
            // Überschreibe das Session-Array mit den geladenen Preset-Daten
            $_SESSION['bx_eu_garan_last_filters'] = $decodedData;
            $formData = $decodedData;
          }
        }
      }
      xtc_redirect(xtc_href_link('bx_eu_garan.php'));
      break;
    case 'delete_preset':
      $presetId = isset($_GET['preset_id']) ? (int)$_GET['preset_id'] : 0;
      if ($presetId > 0) {
        xtc_db_query("DELETE FROM bx_eu_garan_presets WHERE id = '" . $presetId . "'");
      }
      xtc_redirect(xtc_href_link('bx_eu_garan.php'));
      break;
    // --- ENDE PHASE 3 ACTIONS ---    
    default:
      $action = null;
  }

  $categorySelectData = array_merge(
    array(array('id' => 0, 'text' => TEXT_BX_EU_GARAN_FILTER_ALL_CATEGORIES)),
    xtc_get_category_tree()
  );

  $manufacturerSelectData = array_merge(
    array(
      array('id' => '', 'text' => TEXT_BX_EU_GARAN_FILTER_ALL_MANUFACTURERS),
      array('id' => 0, 'text' => TEXT_BX_EU_GARAN_FILTER_WITHOUT_MANUFACTURER)
    ),
    xtc_get_manufacturers()
  );

  $statusSelectData = array(
    array('id' => '', 'text' => TEXT_BX_EU_GARAN_FILTER_ALL_PRODUCTS),
    array('id' => '1', 'text' => TEXT_BX_EU_GARAN_FILTER_ONLY_ACTIVE),
    array('id' => '0', 'text' => TEXT_BX_EU_GARAN_FILTER_ONLY_INACTIVE),
  );

require (DIR_WS_INCLUDES.'head.php');

$messageStack->output();
?>
</head>
<body>
  <!-- header //-->
  <?php require(DIR_WS_INCLUDES.'header.php'); ?>
  <!-- header_eof //-->
  <!-- body //-->
  <table class="tableBody">
    <tr>
      <?php //left_navigation
      if (USE_ADMIN_TOP_MENU == 'false') {
        echo '<td class="columnLeft2">'.PHP_EOL;
        echo '<!-- left_navigation //-->'.PHP_EOL;       
        require_once(DIR_WS_INCLUDES.'column_left.php');
        echo '<!-- left_navigation eof //-->'.PHP_EOL; 
        echo '</td>'.PHP_EOL;      
      }
      ?>
      <!-- body_text //-->
      <td class="boxCenter">

        <div class="pageHeadingImage" style="min-width: 40px;"><?php echo xtc_image(DIR_WS_ICONS.'heading/bx_eu_garan.png', HEADING_BX_EU_GARAN_TITLE, '', '', 'style="max-height: 32px;"'); ?></div>
        <div class="flt-l">
          <div class="pageHeading pdg2"><?php echo HEADING_BX_EU_GARAN_TITLE; ?></div>
          <div class="main pdg2"><?php echo HEADING_BX_EU_GARAN_SUB_TITLE; ?></div>
        </div>

        <table class="tableCenter">
          <tr>
            <td class="boxCenterLeft">
              <div id="headboard">
                <div class="main">
                  <?php echo HEADING_BX_EU_GARAN_TITLE; ?>
                </div>
              </div>

              <?php
                echo xtc_draw_form('bx_eu_garan_form', 'bx_eu_garan.php');
              ?>
                <div class="clear div_box" style="max-width: 100%; border-radius: 4px;">
                  <table style="width: 100%;">
                    <tr>
                      <td style="vertical-align: top; width: 40%;">
                        <h3><?php echo TEXT_BX_EU_GARAN_SAVE_PRESET; ?></h3>
                        <input type="text" name="preset_name" placeholder="z.B. Samsung Waschmaschinen Garantie" style="width: 70%; padding: 4px;" />
                        <button type="submit" formaction="<?php echo xtc_href_link('bx_eu_garan.php', 'action=save_preset'); ?>" class="button" style="padding: 4px 10px;"><?php echo BUTTON_BX_EU_GARAN_SAVE_PRESET; ?></button>
                      </td>
                      
                      <td style="vertical-align: top; width: 60%; border-left: 1px solid #ddd; padding-left: 20px;">
                        <h3><?php echo TEXT_BX_EU_GARAN_LOAD_PRESETS; ?></h3>
                        <?php
                        $presets_query = xtc_db_query("SELECT id, preset_name, created_at FROM bx_eu_garan_presets ORDER BY preset_name ASC");
                        if ($presets_query && xtc_db_num_rows($presets_query) > 0) {
                            echo '<table style="width: 100%; border-collapse: collapse;">';
                            while ($p_row = xtc_db_fetch_array($presets_query)) {
                                $load_url = xtc_href_link('bx_eu_garan.php', 'action=load_preset&preset_id=' . $p_row['id']);
                                $del_url  = xtc_href_link('bx_eu_garan.php', 'action=delete_preset&preset_id=' . $p_row['id']);
                                echo '<tr style="border-bottom: 1px dashed #eee;">';
                                echo '<td class="main" style="padding: 5px 0;">' . htmlspecialchars($p_row['preset_name']) . ' <small style="color:#777;">(' . date('d.m.Y H:i', strtotime($p_row['created_at'])) . ')</small></td>';
                                echo '<td style="text-align: right; padding: 5px 0;">';
                                echo '<a href="' . $load_url . '" class="button" style="padding: 2px 6px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 3px; font-size: 11px; margin-right: 5px;">'.BUTTON_BX_EU_GARAN_LOAD_PRESET.'</a>';
                                echo '<a href="' . $del_url . '" class="button" style="padding: 2px 6px; background-color: #f44336; color: white; text-decoration: none; border-radius: 3px; font-size: 11px;" onclick="return confirm(\''.BUTTON_BX_EU_GARAN_DELETE_PRESET_CONFIRM.'\')">'.BUTTON_BX_EU_GARAN_DELETE_PRESET.'</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            echo '</table>';
                        } else {
                            echo '<span class="main" style="color: #777; font-style: italic;">'.TEXT_BX_EU_GARAN_NO_PRESETS.'</span>';
                        }
                        ?>
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="clear div_box" style="max-width: 100%; border-radius: 4px;">
                  <h3><?php echo HEADING_BX_EU_GARAN_MASS_EDIT_TITLE; ?></h3>
                  <p class="main" style="margin:0 0 12px 0;"><?php echo TEXT_BX_EU_GARAN_MASS_EDIT_DESCRIPTION; ?></p>
                  <p class="info_message" style="margin:0 0 12px 0;"><?php echo TEXT_BX_EU_GARAN_MASS_EDIT_LEGAL_NOTE; ?></p>
                  <table class="tableConfig">
                    <tr class="dataTableHeadingRow" style="border-left: 1px solid #aaaaaa;">
                      <td class="dataTableHeadingContent" colspan="2"><?php echo TEXT_BX_EU_GARAN_TABLE_HEADING_FILTER; ?></td>
                    </tr>
                    <tr>
                      <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_CATEGORY; ?></td>
                      <td class="col-single-right">
                        <?php echo xtc_draw_pull_down_menu('filter_category_id', $categorySelectData, (int)$formData['filter_category_id']); ?>
                        <label style="margin-left:10px;">
<?php echo xtc_draw_checkbox_field('filter_include_subcategories', '1', $formData['filter_include_subcategories'] === 1); ?> <?php echo TEXT_BX_EU_GARAN_FIELD_INCLUDE_SUBCATEGORIES; ?>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_MANUFACTURER; ?></td>
                      <td class="col-single-right">
                        <?php echo xtc_draw_pull_down_menu('filter_manufacturers_id', $manufacturerSelectData, (string)$formData['filter_manufacturers_id']); ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_PRODUCT_STATUS; ?></td>
                      <td class="col-single-right">
                        <?php echo xtc_draw_pull_down_menu('filter_status', $statusSelectData, (string)$formData['filter_status']); ?>
                      </td>
                    </tr>
                  </table>
                </div>

                <details class="bxac-card" style="margin-bottom: 1em;" open>
                  <summary class="bxac-summary">
                    <span class="bxac-arrow" style="font-size: 25px; line-height: 16px;">▸</span>
                    <span class="bxac-title">
                      <?php echo HEADING_BX_EU_GARAN_PRODUCT_WARRANTY; ?>
                    </span>
                  </summary>
                  <div class="bxac-body" style="padding: 0;">
                    <table class="tableBXConfig" style="margin-top: 0;">
                      <tr class="dataTableHeadingRow" style="border-left: 1px solid #aaaaaa;">
                        <td class="dataTableHeadingContent"><?php echo TEXT_BX_EU_GARAN_TABLE_HEADING_FIELD; ?></td>
                        <td class="dataTableHeadingContent txta-c"><?php echo TEXT_BX_EU_GARAN_TABLE_HEADING_SET; ?></td>
                        <td class="dataTableHeadingContent"><?php echo TEXT_BX_EU_GARAN_TABLE_HEADING_VALUE; ?></td>
                        <td class="dataTableHeadingContent"><?php echo TEXT_BX_EU_GARAN_TABLE_HEADING_NOTE; ?></td>
                      </tr>
                      <tr>
                        <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_GUARANTEE_ACTIVE; ?></td>
                        <td class="col-middle txta-c">
  <?php echo xtc_draw_checkbox_field('set_manufacturer_guarantee_available', '1', $formData['set_manufacturer_guarantee_available'] === 1); ?>
                        </td>
                        <td class="col-right">
  <?php echo xtc_cfg_select_option(array('true', 'false'), ($formData['manufacturer_guarantee_available'] === 1 ? 'true' : 'false'), 'manufacturer_guarantee_available'); ?>
                        </td>
                        <td class="col-right"><?php echo TEXT_BX_EU_GARAN_FIELD_GUARANTEE_ACTIVE_NOTE; ?></td>
                      </tr>
                      <tr>
                        <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_GUARANTEE_YEARS; ?></td>
                        <td class="col-middle txta-c">
  <?php echo xtc_draw_checkbox_field('set_guarantee_years', '1', $formData['set_guarantee_years'] === 1); ?>
                        </td>
                        <td class="col-right" style="width: 30%;"><input type="number" min="0" step="1" name="guarantee_years" value="<?php echo (int)$formData['guarantee_years']; ?>"></td>
                        <td class="col-right"><?php echo TEXT_BX_EU_GARAN_FIELD_GUARANTEE_YEARS_NOTE; ?></td>
                      </tr>
                      <tr>
                        <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_COVERS_FULL_PRODUCT; ?></td>
                        <td class="col-middle txta-c">
  <?php echo xtc_draw_checkbox_field('set_covers_full_product', '1', $formData['set_covers_full_product'] === 1); ?>
                        </td>
                        <td class="col-right">
  <?php echo xtc_cfg_select_option(array('true', 'false'), ($formData['covers_full_product'] === 1 ? 'true' : 'false'), 'covers_full_product'); ?>
                        </td>
                        <td class="col-right"><?php echo TEXT_BX_EU_GARAN_FIELD_COVERS_FULL_PRODUCT_NOTE; ?></td>
                      </tr>
                      <tr>
                        <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_REQUIRES_ADDITIONAL_COST; ?></td>
                        <td class="col-middle txta-c">
  <?php echo xtc_draw_checkbox_field('set_requires_additional_cost', '1', $formData['set_requires_additional_cost'] === 1); ?>
                        </td>
                        <td class="col-right">
  <?php echo xtc_cfg_select_option(array('true', 'false'), ($formData['requires_additional_cost'] === 1 ? 'true' : 'false'), 'requires_additional_cost'); ?>
                        </td>
                        <td class="col-right"><?php echo TEXT_BX_EU_GARAN_FIELD_REQUIRES_ADDITIONAL_COST_NOTE; ?></td>
                      </tr>
                      <tr>
                        <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_QR_URL; ?></td>
                        <td class="col-middle txta-c">
  <?php echo xtc_draw_checkbox_field('set_qr_url', '1', $formData['set_qr_url'] === 1); ?>
                        </td>
                        <td class="col-right"><input type="text" name="qr_url" value="<?php echo htmlspecialchars($formData['qr_url']); ?>"></td>
                        <td class="col-right"></td>
                      </tr>
                    </table>
                  </div>
                </details>

                <details class="bxac-card">
                  <summary class="bxac-summary">
                    <span class="bxac-arrow" style="font-size: 25px; line-height: 16px;">▸</span>
                    <span class="bxac-title">
                      <?php echo HEADING_BX_EU_GARAN_PRODUCT_REPAIRABILITY; ?>
                    </span>
                  </summary>
                  <div class="bxac-body" style="padding: 0;">
                    <table class="tableBXConfig" style="margin-top: 0;">
                      <tr class="dataTableHeadingRow" style="border-left: 1px solid #aaaaaa;">
                        <td class="dataTableHeadingContent" style="width: 25%;"><?php echo TEXT_BX_EU_GARAN_TABLE_HEADING_FIELD; ?></td>
                        <td class="dataTableHeadingContent txta-c" style="width: 5%;"><?php echo TEXT_BX_EU_GARAN_TABLE_HEADING_SET; ?></td>
                        <td class="dataTableHeadingContent" style="width: 50%;"><?php echo TEXT_BX_EU_GARAN_TABLE_HEADING_VALUE; ?></td>
                        <td class="dataTableHeadingContent" style="width: 20%;"><?php echo TEXT_BX_EU_GARAN_TABLE_HEADING_NOTE; ?></td>
                      </tr>
                      <tr>
                        <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_REPAIR_SCORE; ?></td>
                        <td class="col-middle txta-c">
  <?php echo xtc_draw_checkbox_field('set_repair_score', '1', $formData['set_repair_score'] === 1); ?>
                        </td>
                        <td class="col-right">
                          <input type="range" min="0" max="10" step="1" id="repair_score" name="repair_score" value="<?php echo (int)$formData['repair_score']; ?>" list="repair_scores" style="min-width: 250px;">
                          <datalist id="repair_scores">
                            <option value="0"></option>
                            <option value="1"></option>
                            <option value="2"></option>
                            <option value="3"></option>
                            <option value="4"></option>
                            <option value="5"></option>
                            <option value="6"></option>
                            <option value="7"></option>
                            <option value="8"></option>
                            <option value="9"></option>
                            <option value="10"></option>
                          </datalist>
                        </td>
                        <td class="col-right">
                          <?php echo TEXT_BX_EU_GARAN_FIELD_CURRENT_VALUE; ?> <span id="repair_score_value" style="font-weight: bold;"><?php echo (int)$formData['repair_score']; ?></span>
                          <script>
                            var slider = document.getElementById("repair_score");
                            var output = document.getElementById("repair_score_value");
                            output.innerHTML = slider.value; // Zeigt den Standardwert an

                            // Aktualisiert den Wert, wenn der Benutzer schiebt
                            slider.oninput = function() {
                            output.innerHTML = this.value;
                            }
                        </script>
                        </td>
                      </tr>
                      <tr>
                        <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_PARTS_AVAILABLE; ?></td>
                        <td class="col-middle txta-c">
  <?php echo xtc_draw_checkbox_field('set_parts_available', '1', $formData['set_parts_available'] === 1); ?>
                        </td>
                        <td class="col-right">
  <?php echo xtc_cfg_select_option(array('true', 'false'), ($formData['parts_available'] === 1 ? 'true' : 'false'), 'parts_available'); ?>
                        </td>
                        <td class="col-right"></td>
                      </tr>
                      <tr>
                        <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_PARTS_COST_INFO; ?></td>
                        <td class="col-middle txta-c">
  <?php echo xtc_draw_checkbox_field('set_parts_cost_info', '1', $formData['set_parts_cost_info'] === 1); ?>
                        </td>
                        <td class="col-right">
                          <input type="text" name="parts_cost_info" value="<?php echo htmlspecialchars($formData['parts_cost_info']); ?>">
                        </td>
                        <td class="col-right"></td>
                      </tr>
                      <tr>
                        <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_PARTS_AVAILABLE_YEARS; ?></td>
                        <td class="col-middle txta-c">
  <?php echo xtc_draw_checkbox_field('set_parts_availability_years', '1', $formData['set_parts_availability_years'] === 1); ?>
                        </td>
                        <td class="col-right">
                          <input type="range" min="0" max="30" step="1" id="parts_availability_years" name="parts_availability_years" value="<?php echo (int)$formData['parts_availability_years']; ?>" list="availability_years_scores" style="min-width: 250px;">
                          <datalist id="availability_years_scores">
                            <option value="0"></option>
                            <option value="1"></option>
                            <option value="2"></option>
                            <option value="3"></option>
                            <option value="4"></option>
                            <option value="5"></option>
                            <option value="6"></option>
                            <option value="7"></option>
                            <option value="8"></option>
                            <option value="9"></option>
                            <option value="10"></option>
                            <option value="11"></option>
                            <option value="12"></option>
                            <option value="13"></option>
                            <option value="14"></option>
                            <option value="15"></option>
                            <option value="16"></option>
                            <option value="17"></option>
                            <option value="18"></option>
                            <option value="19"></option>
                            <option value="20"></option>
                            <option value="21"></option>
                            <option value="22"></option>
                            <option value="23"></option>
                            <option value="24"></option>
                            <option value="25"></option>
                            <option value="26"></option>
                            <option value="27"></option>
                            <option value="28"></option>
                            <option value="29"></option>
                            <option value="30"></option>
                          </datalist>
                        </td>
                        <td class="col-right">
                          <?php echo TEXT_BX_EU_GARAN_FIELD_CURRENT_VALUE; ?> <span id="parts_availability_years_value" style="font-weight: bold;"><?php echo (int)$formData['parts_availability_years']; ?></span>
                          <script>
                            var years_slider = document.getElementById("parts_availability_years");
                            var years_output = document.getElementById("parts_availability_years_value");
                            years_output.innerHTML = years_slider.value; // Zeigt den Standardwert an

                            // Aktualisiert den Wert, wenn der Benutzer schiebt
                            years_slider.oninput = function() {
                            years_output.innerHTML = this.value;
                            }
                        </script>
                        </td>
                      </tr>
                      <tr>
                        <td class="col-left"><?php echo TEXT_BX_EU_GARAN_PRODUCT_REPAIR_SERVICE_URL; ?></td>
                        <td class="col-middle txta-c"><?php echo xtc_draw_checkbox_field('set_repair_service_url', '1', $formData['set_repair_service_url'] === 1); ?></td>
                        <td class="col-right"><input type="text" name="repair_service_url" value="<?php echo htmlspecialchars($formData['repair_service_url']); ?>"></td>
                        <td class="col-right"></td>
                      </tr>
                      <tr>
                        <td class="col-left"><?php echo TEXT_BX_EU_GARAN_PRODUCT_MANUAL_URL; ?></td>
                        <td class="col-middle txta-c"><?php echo xtc_draw_checkbox_field('set_manual_url', '1', $formData['set_manual_url'] === 1); ?></td>
                        <td class="col-right"><input type="text" name="manual_url" value="<?php echo htmlspecialchars($formData['manual_url']); ?>"></td>
                        <td class="col-right"></td>
                      </tr>
                      <tr>
                        <td class="col-left"><?php echo TEXT_BX_EU_GARAN_PRODUCT_REPAIR_RESTRICTIONS; ?></td>
                        <td class="col-middle txta-c"><?php echo xtc_draw_checkbox_field('set_repair_restrictions', '1', $formData['set_repair_restrictions'] === 1); ?></td>
                        <td class="col-right">
                          <?php echo xtc_draw_textarea_field('repair_restrictions', 'soft', 70, 4, $formData['repair_restrictions']); ?>
                        </td>
                        <td class="col-right"></td>
                      </tr>
                    </table>
                  </div>
                </details>

                <div class="clear" style="max-width: 100%;">
                  <button class="button" type="submit" name="action" value="preview"><?php echo BUTTON_BX_EU_GARAN_PREVIEW; ?></button>
                  <button class="button" type="submit" name="action" value="apply_mass_update" onclick="return confirm('<?php echo TEXT_BX_EU_GARAN_CONFIRM_MASS_UPDATE; ?>');"><?php echo BUTTON_BX_EU_GARAN_APPLY; ?></button>
                </div>
              </form>

            </td>
            <!-- boxCenterLeft //-->
            <td class="boxRight">
<?php
  $heading  = array();
  $contents = array();

  $heading[] = array('text' => '<strong>'.TEXT_BX_EU_GARAN_LEGAL_WARRANTY_BOX_TITLE.'</strong>');
  $warrantyContentFormHtml  = xtc_draw_form('bx_eu_garan_warranty_content_form', 'bx_eu_garan.php');
  $warrantyContentFormHtml .= '<div class="main" style="margin-bottom:8px;">'.TEXT_BX_EU_GARAN_LEGAL_WARRANTY_BOX_DESCRIPTION.'</div>';
  $warrantyContentFormHtml .= '<div style="margin-bottom:10px;">'.xtc_cfg_select_content('warranty_content_group', (string)$warrantyContentGroupId).'</div>';
  $warrantyContentFormHtml .= '<button class="button" type="submit" name="action" value="save_warranty_content">'.BUTTON_BX_EU_GARAN_SAVE_WARRANTY_CONTENT.'</button>';
  $warrantyContentFormHtml .= '</form>';
  $contents[] = array('text' => $warrantyContentFormHtml);

  if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
    $box = new box;
    echo $box->infoBox($heading, $contents);
  }

  $heading  = array();
  $contents = array();

  $heading[]  = array('text' => '<strong>'.TEXT_BX_EU_GARAN_INFOBOX_TITLE.'</strong>');
  $contents[] = array('text' => '<a class="button" href="'.TEXT_BX_EU_GARAN_URL_NEW_LABELS.'" target="_blank">'.TEXT_BX_EU_GARAN_LINK_NEW_LABELS.'</a>');
  $contents[] = array('text' => '<a class="button" href="'.TEXT_BX_EU_GARAN_URL_FAQ.'" target="_blank">'.TEXT_BX_EU_GARAN_LINK_FAQ.'</a>');
  $contents[] = array('text' => '<a class="button" href="'.TEXT_BX_EU_GARAN_URL_IHK.'" target="_blank">'.TEXT_BX_EU_GARAN_LINK_IHK.'</a>');
  $contents[] = array('text' => '<a class="button" href="'.TEXT_BX_EU_GARAN_URL_EUR_LEX.'" target="_blank">'.TEXT_BX_EU_GARAN_LINK_EUR_LEX.'</a>');


  if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
    $box = new box;
    echo $box->infoBox($heading, $contents);
  }


  $heading  = array();
  $contents = array();

  if (count($messageStack->errors['error']) > 0) {
    echo '<audio id="bx-eu-garan-error-sound" autoplay src="../media/sounds/kave_msri-police-intro-sfx-323774.mp3"></audio>';

    $heading[]  = array('text' => '<strong id="bx-eu-garan-error_heading" style="display:none;">'.TEXT_BX_EU_GARAN_AUTOPLAY_WARNING_TITLE.'</strong>');
    $contents[] = array('text' => '<span id="bx-eu-garan-autoplay-warning" class="error_message" style="display:none;">'.TEXT_BX_EU_GARAN_AUTOPLAY_WARNING.'</span>');  
  }

  if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
    $box = new box;
    echo $box->infoBox($heading, $contents);
  }

  if (count($messageStack->errors['error']) > 0) {
    echo '<script>
      (function() {
        var audio   = document.getElementById("bx-eu-garan-error-sound");
        var warning = document.getElementById("bx-eu-garan-autoplay-warning");
        var error_heading = document.getElementById("bx-eu-garan-error_heading");

        if (!audio || !warning || !error_heading) {
          return;
        }

        var playPromise = audio.play();
        if (playPromise !== undefined) {
          playPromise.catch(function() {
            warning.style.display = "inline-block";
            error_heading.style.display = "inline-block";
          });
        }
      }());
    </script>';
  }
?>
            </td>
            <!-- boxRight //-->
          </tr>
        </table>
      </td>
      <!-- body_text_eof //-->
    </tr>
  </table>
<!-- https://eur-lex.europa.eu/legal-content/DE/TXT/?uri=CELEX:32024L0825 // Empowering Consumers Directive (EU) 2024/825 //-->
<!-- https://eur-lex.europa.eu/legal-content/DE/TXT/?uri=CELEX:32025R1960 // Durchführungsverordnung (EU) 2025/1960 //-->
<!-- Harmonisierte Mitteilung zur Gewaehrleistung immer, harmonisierte Kennzeichnung zur Garantie nur bei freiwilliger Herstellergarantie //-->

  <!-- body_eof //-->
  <!-- footer //-->
  <?php require(DIR_WS_INCLUDES.'footer.php'); ?>
  <!-- footer_eof //-->

</body>
</html>
<?php require(DIR_WS_INCLUDES.'application_bottom.php'); ?>