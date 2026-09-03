<?php
/** 
 * ██████╗  ███████╗ ███╗   ██╗  █████╗  ██╗  ██╗
 * ██╔══██╗ ██╔════╝ ████╗  ██║ ██╔══██╗ ╚██╗██╔╝
 * ██████╔╝ █████╗   ██╔██╗ ██║ ███████║  ╚███╔╝
 * ██╔══██╗ ██╔══╝   ██║╚██╗██║ ██╔══██║  ██╔██╗
 * ██████╔╝ ███████╗ ██║ ╚████║ ██║  ██║ ██╔╝ ██╗
 * ╚═════╝  ╚══════╝ ╚═╝  ╚═══╝ ╚═╝  ╚═╝ ╚═╝  ╚═╝
 * BX EU Garan - Filename Definition
 * 
 * Definiert die Dateinamens-Konstante für BX EU Garan.
 * Wird vom modified eCommerce Framework für Routing verwendet.
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

if(!isset($filename_array)) {
  $filename_array = array();
}

if(defined('PROJECT_MAJOR_VERSION') && (int)PROJECT_MAJOR_VERSION < 3) {
  define('FILENAME_BX_EU_GARAN', 'bx_eu_garan.php');
} else {
  $filename_array = array_merge($filename_array, array("FILENAME_BX_EU_GARAN" => "bx_eu_garan.php"));
}
