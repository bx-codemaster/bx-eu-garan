<?php
/** 
 * ██████╗  ███████╗ ███╗   ██╗  █████╗  ██╗  ██╗
 * ██╔══██╗ ██╔════╝ ████╗  ██║ ██╔══██╗ ╚██╗██╔╝
 * ██████╔╝ █████╗   ██╔██╗ ██║ ███████║  ╚███╔╝
 * ██╔══██╗ ██╔══╝   ██║╚██╗██║ ██╔══██║  ██╔██╗
 * ██████╔╝ ███████╗ ██║ ╚████║ ██║  ██║ ██╔╝ ██╗
 * ╚═════╝  ╚══════╝ ╚═╝  ╚═══╝ ╚═╝  ╚═╝ ╚═╝  ╚═╝
 * BX EU Garan - Admin Menu Integration
 * 
 * Registriert den Menüeintrag für BX EU Garan im Admin-Bereich.
 * Fügt das Modul in die Tools-Sektion des modified eCommerce Admin-Menüs ein.
 * 
 * Menu Configuration:
 * - Box: BOX_HEADING_TOOLS (Werkzeuge)
 * - Access Name: bx_eu_garan
 * - Filename: bx_eu_garan.php
 * - SSL: Required
 * - Status: Controlled by MODULE_BX_EU_GARAN_STATUS
 * 
 * @package    BX EU Garan
 * @subpackage Configuration
 * @category   Admin
 * @author     Axel Benkert
 * @version    1.2
 * @since      1.0.0
 * @date       2025-11-09
 * @copyright  2020-2025 Axel Benkert
 * @license    GNU General Public License
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

if (defined("MODULE_BX_EU_GARAN_STATUS") && 'True' === MODULE_BX_EU_GARAN_STATUS) {
  switch ($_SESSION['language_code']) {
    case 'de':
      if (!defined('MENU_NAME_BX_EU_GARAN')) define('MENU_NAME_BX_EU_GARAN', 'BX EU Herstellergarantie');
      break;
    default:
      if (!defined('MENU_NAME_BX_EU_GARAN')) define('MENU_NAME_BX_EU_GARAN', 'BX EU Manufacturer\'s warranty');
      break;
  }

  // BOX_HEADING_BX_MODULES = Werkzeuge-Menü im Admin
  $add_contents[BOX_HEADING_TOOLS][] = array( 
    'admin_access_name' => 'bx_eu_garan',
    'filename'          => 'bx_eu_garan.php',
    'boxname'           => MENU_NAME_BX_EU_GARAN,
    'parameters'        => '',
    'ssl' => 'SSL'
  );
}
