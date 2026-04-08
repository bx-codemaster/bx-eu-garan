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
 * @version    1.0.0
 * @date       2026-04-05
 * @copyright  2020-2025 Axel Benkert
 * @license    GNU General Public License
 * 
 * @changelog
 * Version 1.0.0 (2026-04-05):
 */

  require('includes/application_top.php');

  include_once(DIR_FS_INC.'xtc_get_manufacturers.inc.php');
  
  $action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : NULL);

  $languagesId  = isset($_SESSION['languages_id']) ? (int)$_SESSION['languages_id'] : 2;
  $previewCount = null;
  $feedback     = array();
  $manufacturerGuaranteeAvailableRaw = isset($_POST['configuration']['manufacturer_guarantee_available']) ? (string)$_POST['configuration']['manufacturer_guarantee_available'] : 'false';
  $requiresAdditionalCostRaw         = isset($_POST['configuration']['requires_additional_cost']) ? (string)$_POST['configuration']['requires_additional_cost'] : 'false';
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
    'set_requires_additional_cost' => isset($_POST['set_requires_additional_cost']) ? 1 : 0,
    'requires_additional_cost'     => ($requiresAdditionalCostRaw === 'true') ? 1 : 0,
    'set_qr_url'                   => isset($_POST['set_qr_url']) ? 1 : 0,
    'qr_url'                       => isset($_POST['qr_url']) ? trim((string)$_POST['qr_url']) : '',
    'set_repair_score'             => isset($_POST['set_repair_score']) ? 1 : 0,
    'repair_score'                 => isset($_POST['repair_score']) ? max(0, min(10, (int)$_POST['repair_score'])) : 0,
    'set_parts_available'          => isset($_POST['set_parts_available']) ? 1 : 0,
    'parts_available'              => ($parts_availableRaw === 'true') ? 1 : 0,
    'set_manual_url'               => isset($_POST['set_manual_url']) ? 1 : 0,
    'manual_url'                   => isset($_POST['manual_url']) ? trim((string)$_POST['manual_url']) : '',
  );

  if ($action === 'preview' || $action === 'apply_mass_update') {
    $productIds = bx_eu_garan_get_product_ids(
      $formData['filter_category_id'],
      $formData['filter_include_subcategories'] === 1,
      $formData['filter_manufacturers_id'],
      $formData['filter_status']
    );

    $previewCount = count($productIds);

    if ($action === 'apply_mass_update') {
      $warrantyUpdates = array();
      $repairUpdates   = array();

      if ($formData['set_manufacturer_guarantee_available'] === 1) {
        $warrantyUpdates[] = "`manufacturer_guarantee_available` = '".(int)$formData['manufacturer_guarantee_available']."'";
      }
      if ($formData['set_guarantee_years'] === 1) {
        $warrantyUpdates[] = "`guarantee_years` = '".(int)$formData['guarantee_years']."'";
      }
      if ($formData['set_requires_additional_cost'] === 1) {
        $warrantyUpdates[] = "`requires_additional_cost` = '".($formData['requires_additional_cost'] === 1 ? 1 : 0)."'";
      }
      if ($formData['set_qr_url'] === 1) {
        $warrantyUpdates[] = "`qr_url` = ".bx_eu_garan_to_nullable_string($formData['qr_url']);
      }

      if ($formData['set_repair_score'] === 1) {
        $repairUpdates[] = "`repair_score` = '".(int)$formData['repair_score']."'";
      }
      if ($formData['set_parts_available'] === 1) {
        $repairUpdates[] = "`parts_available` = '".($formData['parts_available'] === 1 ? 1 : 0)."'";
      }
      if ($formData['set_manual_url'] === 1) {
        $repairUpdates[] = "`manual_url` = ".bx_eu_garan_to_nullable_string($formData['manual_url']);
      }

      if (empty($warrantyUpdates) && empty($repairUpdates)) {
        $feedback[] = array('type' => 'error', 'text' => TEXT_BX_EU_GARAN_FEEDBACK_SELECT_AT_LEAST_ONE_FIELD);
      } elseif ($previewCount === 0) {
        $feedback[] = array('type' => 'error', 'text' => TEXT_BX_EU_GARAN_FEEDBACK_NO_PRODUCTS_FOUND);
      } else {
        $updatedProducts = 0;
        $warrantyCount   = 0;
        $repairCount     = 0;

        foreach ($productIds as $productId) {
          $productId = (int)$productId;

          if (!empty($warrantyUpdates)) {
            $warrantySql = "INSERT INTO `bx_products_warranty_guarantee` (`products_id`, `created_at`, `updated_at`)
                            VALUES ('".$productId."', NOW(), NOW())
                            ON DUPLICATE KEY UPDATE ".implode(', ', $warrantyUpdates).", `updated_at` = NOW()";
            xtc_db_query($warrantySql);
            $warrantyCount++;
          }

          if (!empty($repairUpdates)) {
            $repairSql = "INSERT INTO `bx_products_repairability` (`products_id`, `created_at`, `updated_at`)
                          VALUES ('".$productId."', NOW(), NOW())
                          ON DUPLICATE KEY UPDATE ".implode(', ', $repairUpdates).", `updated_at` = NOW()";
            xtc_db_query($repairSql);
            $repairCount++;
          }

          $updatedProducts++;
        }

        $feedback[] = array(
          'type' => 'success',
          'text' => sprintf(TEXT_BX_EU_GARAN_FEEDBACK_SUCCESS, $updatedProducts, $warrantyCount, $repairCount)
        );
      }
    }
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

        <div class="pageHeadingImage" style="min-width: 40px;"><?php echo xtc_image(DIR_WS_ICONS.'heading/icon_bx_eu_garan.png', HEADING_BX_EU_GARAN_TITLE, '', '', 'style="max-height: 32px;"'); ?></div>
        <div class="flt-l">
          <div class="pageHeading pdg2"><?php echo HEADING_BX_EU_GARAN_TITLE; ?></div>
          <div class="main pdg2"><?php echo HEADING_BX_EU_GARAN_SUB_TITLE; ?></div>
        </div>

        <table class="tableCenter">
          <tr>
            <td class="boxCenterLeft">
              <div id="bx_eu_garan_header" class="main">
                <div class="main">
                  <?php echo HEADING_BX_EU_GARAN_TITLE; ?>
                </div>
              </div>

              <div valign="top" class="clear div_box" style="max-width: 100%;">
                <h3 style="margin-top:0;"><?php echo HEADING_BX_EU_GARAN_MASS_EDIT_TITLE; ?></h3>
                <p class="main" style="margin:0 0 12px 0;"><?php echo TEXT_BX_EU_GARAN_MASS_EDIT_DESCRIPTION; ?></p>
                <p class="main" style="margin:0 0 12px 0;"><?php echo TEXT_BX_EU_GARAN_MASS_EDIT_LEGAL_NOTE; ?></p>

<?php
  foreach ($feedback as $message) {
    $bgColor = $message['type'] === 'success' ? '#e7f7ea' : '#fdeaea';
    $bdColor = $message['type'] === 'success' ? '#6aa56f' : '#cf6a6a';
    echo '<div style="background: '.$bgColor.'; border:1px solid '.$bdColor.'; padding:10px; margin-bottom:10px;">'.htmlspecialchars($message['text']).'</div>';
  }

  if ($previewCount !== null) {
    echo '<div style="background:#f0f4fb; border:1px solid #9bb0d3; padding:10px; margin-bottom:10px;">'.sprintf(TEXT_BX_EU_GARAN_PREVIEW_RESULT, (int)$previewCount).'</div>';
  }

  echo xtc_draw_form('bx_eu_garan_form', 'bx_eu_garan.php');
?>

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

                  <table class="tableBXConfig">
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
                    <tr>
                      <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_REPAIR_SCORE; ?></td>
                      <td class="col-middle txta-c">
<?php echo xtc_draw_checkbox_field('set_repair_score', '1', $formData['set_repair_score'] === 1); ?>
                      </td>
                      <td class="col-right"><input type="number" min="0" max="10" step="1" name="repair_score" value="<?php echo (int)$formData['repair_score']; ?>"></td>
                      <td class="col-right"></td>
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
                      <td class="col-left"><?php echo TEXT_BX_EU_GARAN_FIELD_MANUAL_URL; ?></td>
                      <td class="col-middle txta-c"><?php echo xtc_draw_checkbox_field('set_manual_url', '1', $formData['set_manual_url'] === 1); ?></td>
                      <td class="col-right"><input type="text" name="manual_url" value="<?php echo htmlspecialchars($formData['manual_url']); ?>"></td>
                      <td class="col-right"></td>
                    </tr>
                  </table>

                  <button class="button" type="submit" name="action" value="preview"><?php echo BUTTON_BX_EU_GARAN_PREVIEW; ?></button>
                  <button class="button" type="submit" name="action" value="apply_mass_update" onclick="return confirm('<?php echo TEXT_BX_EU_GARAN_CONFIRM_MASS_UPDATE; ?>');"><?php echo BUTTON_BX_EU_GARAN_APPLY; ?></button>
                </form>
              </div>

            </td>
            <!-- boxCenterLeft //-->
            <td class="boxRight">
<?php

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