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
 * @date       2026-04-04
 * @copyright  2020-2026 Axel Benkert
 * @license    GNU General Public License
 */

  define('MODULE_BX_EU_GARAN_TITLE', 'BX EU Manufacturer\'s warranty');

  $description = '<h3 style="margin-top:0; display:flex; align-items:center; gap:8px;"><span style="font-size: 2.5em; line-height:1;">🇪🇺</span> BX EU Manufacturer\'s warranty</h3><p>is a professional management tool for Modified eCommerce shop software that simplifies the sorting of products on the homepage and within categories. With a modern drag-and-drop interface, you can intuitively move products using the mouse – the sorting is saved automatically.</p>';

  if((!defined('MODULE_BX_EU_GARAN_STATUS')) || (MODULE_BX_EU_GARAN_STATUS != 'True') && basename($_SERVER['PHP_SELF']) == 'module_export.php') { 
    $description .= '<p><a class="button btnbox but_red" style="text-align:center;" onclick="return confirmLink(\'Delete all files?\', \'\' ,this);" href="'.xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=bx_eu_garan&action=custom').'">Delete all module files</a></p>';
  }
  define('MODULE_BX_EU_GARAN_DESC', $description);
  
  define('MODULE_BX_EU_GARAN_STATUS_TITLE', 'Module active?');
  define('MODULE_BX_EU_GARAN_STATUS_DESC', 'Should the module be displayed?');

  
  define('MODULE_BX_EU_GARAN_VERSION_TITLE', 'Module version');
  define('MODULE_BX_EU_GARAN_VERSION_DESC', 'The current version of the module.');

  define('MODULE_BX_EU_GARAN_CONFIG_ID_TITLE', 'Configuration ID');
  define('MODULE_BX_EU_GARAN_CONFIG_ID_DESC', 'The unique ID for the module configuration. It is generated automatically and should not be changed.');
  
  // Custom Deinstallation Messages
  define('MODULE_BX_EU_GARAN_TEXT_FILES_DELETED', 'Successfully deleted:');
  define('MODULE_BX_EU_GARAN_TEXT_FILES_FAILED', 'Error deleting (please remove manually via FTP):');
  define('MODULE_BX_EU_GARAN_TEXT_SUCCESSFULLY_REMOVED', 'BX EU Garan was successfully removed!');
  define('MODULE_BX_EU_GARAN_TEXT_REMOVAL_INCOMPLETE', 'BX EU Garan was partially removed. Please check the error messages and delete the remaining files manually via FTP.');
