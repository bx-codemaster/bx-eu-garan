<?php
/** 
 * ██████╗  ███████╗ ███╗   ██╗  █████╗  ██╗  ██╗
 * ██╔══██╗ ██╔════╝ ████╗  ██║ ██╔══██╗ ╚██╗██╔╝
 * ██████╔╝ █████╗   ██╔██╗ ██║ ███████║  ╚███╔╝
 * ██╔══██╗ ██╔══╝   ██║╚██╗██║ ██╔══██║  ██╔██╗
 * ██████╔╝ ███████╗ ██║ ╚████║ ██║  ██║ ██╔╝ ██╗
 * ╚═════╝  ╚══════╝ ╚═╝  ╚═══╝ ╚═╝  ╚═╝ ╚═╝  ╚═╝
 * BX EU Garan - English System Module Texts
 * 
 * System module configuration texts for BX EU Garan.
 * Module description, title, description and status constants.
 * 
 * @package    BX EU Garan
 * @subpackage Language
 * @category   System Module
 * @author     Axel Benkert
 * @version    1.2
 * @since      1.0.0
 * @date       2025-11-09
 * @copyright  2020-2025 Axel Benkert
 * @license    GNU General Public License
 */

  define('MODULE_BX_EU_GARAN_TITLE', 'BX EU Herstellergarantie');

  $description = '
  <details class="bxac-card">
    <summary class="bxac-summary" style="list-style: none;">
      <span class="bxac-arrow">▸</span>
      <span class="bxac-title">' . xtc_image(DIR_WS_ICONS.'heading/bx_eu_garan.png', 'BX EU Herstellergarantie', '', '', 'style="max-height: 32px; vertical-align: middle; margin-right: 8px;"') . 'BX EU Herstellergarantie</span>
    </summary>
    <div class="bxac-body">
    <h3 style="margin-top: 0;">Manufacturer Warranty and EU Compliance</h3>
    <p>is a professional management tool for Modified eCommerce Shop Software.</p>';
  
  if((!defined('MODULE_BX_EU_GARAN_STATUS')) || (MODULE_BX_EU_GARAN_STATUS != 'True') && basename($_SERVER['PHP_SELF']) == 'module_export.php') {
    $description .= '<p><a class="button btnbox but_red" style="text-align:center;" onclick="return confirmLink(\'Delete all files?\', \'\' ,this);" href="'.xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=bx_eu_garan&action=custom').'">Delete all module files</a></p>';
  }
  $description .= '</div></details>';

  define('MODULE_BX_EU_GARAN_DESC', $description);
  
  define('MODULE_BX_EU_GARAN_STATUS_TITLE', 'Module active?');
  define('MODULE_BX_EU_GARAN_STATUS_DESC', 'Should the module be displayed?');
  
  define('MODULE_BX_EU_GARAN_VERSION_TITLE', 'Module version');
  define('MODULE_BX_EU_GARAN_VERSION_DESC', 'The current version of the module.');

  define('MODULE_BX_EU_GARAN_CONFIG_ID_TITLE', 'Configuration ID');
  define('MODULE_BX_EU_GARAN_CONFIG_ID_DESC', 'The unique ID for the module configuration. It is generated automatically and should not be changed.');

  // Custom Deinstallation Messages
  define('MODULE_BX_EU_GARAN_TEXT_FILES_DELETED', 'Deleted successfully:');
  define('MODULE_BX_EU_GARAN_TEXT_FILES_FAILED', 'Failed to delete (please remove manually via FTP):');
  define('MODULE_BX_EU_GARAN_TEXT_SUCCESSFULLY_REMOVED', 'BX EU Garan was successfully removed!');
  define('MODULE_BX_EU_GARAN_TEXT_REMOVAL_INCOMPLETE', 'BX EU Garan was partially removed. Please check the error messages and delete the remaining files manually via FTP.');
  define('MODULE_BX_EU_GARAN_WARRANTY_CONTENT_GROUP_TITLE', 'Warranty Information');
  define('MODULE_BX_EU_GARAN_WARRANTY_CONTENT_GROUP_DESC', 'Here you can enter the warranty information for your products. This information will be displayed on the product detail page and informs your customers about the manufacturer\'s warranty and EU compliance of your products.');
  define('MODULE_BX_EU_GARAN_NEW_WINDOW_TITLE', 'Open in a new window?');
  define('MODULE_BX_EU_GARAN_NEW_WINDOW_DESC', 'Should the link be opened in a new window?');

  define('MODULE_BX_EU_GARAN_CATEGORIES_DEINSTALL_FIRST', 'Please uninstall the "BX EU Garan Categories" module first before uninstalling the main module. (Modules -> Class Extensions -> Categories)');
  define('MODULE_BX_EU_GARAN_ORDER_DEINSTALL_FIRST', 'Please uninstall the "BX EU Garan Orders" module first before uninstalling the main module. (Modules -> Class Extensions -> Orders)');
  define('MODULE_BX_EU_GARAN_CART_DEINSTALL_FIRST', 'Please uninstall the "BX EU Garan Cart" module first before uninstalling the main module. (Modules -> Class Extensions -> Cart)');
