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
  
  $action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : NULL);

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

              <div valign="top" class="clear div_box" style="max-width: 100%;">Axel Benkert</div>

            </td>
            <!-- boxCenterLeft //-->
            <td class="boxRight">
<?php

  $heading  = array();
  $contents = array();

  $heading[]  = array('text' => '<strong>Titel</strong>');
  $contents[] = array('text' => '<a class="button" href="https://www.it-recht-kanzlei.de/neue-label-gewaehrleistung-garantie-2026.html" target="_blank">Neue Gewährleistungs- und Garantie-Label</a>');
  $contents[] = array('text' => '<a class="button" href="https://www.it-recht-kanzlei.de/faq-gewaehrleistunglabel-garantielabel.html" target="_blank">FAQ zum Gewährleistungs- und Garantielabel</a>');
  $contents[] = array('text' => '<a class="button" href="https://www.ihk.de/stuttgart/fuer-unternehmen/recht-und-steuern/wettbewerbsrecht/garantien-und-gewaehrleistung-neue-informationspflichten-7004604" target="_blank">IHK Stuttgart: Garantien und Gewährleistung</a>');
  $contents[] = array('text' => '<a class="button" href="https://eur-lex.europa.eu/legal-content/DE/TXT/?uri=CELEX:32025R1960" target="_blank">Durchführungsverordnung (EU) 2025/1960 der Kommission vom 25. September 2025</a>');


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
  <!-- body_eof //-->
  <!-- footer //-->
  <?php require(DIR_WS_INCLUDES.'footer.php'); ?>
  <!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES.'application_bottom.php'); ?>