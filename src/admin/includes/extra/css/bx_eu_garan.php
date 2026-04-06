<?php
/** 
 * ██████╗  ███████╗ ███╗   ██╗  █████╗  ██╗  ██╗
 * ██╔══██╗ ██╔════╝ ████╗  ██║ ██╔══██╗ ╚██╗██╔╝
 * ██████╔╝ █████╗   ██╔██╗ ██║ ███████║  ╚███╔╝
 * ██╔══██╗ ██╔══╝   ██║╚██╗██║ ██╔══██║  ██╔██╗
 * ██████╔╝ ███████╗ ██║ ╚████║ ██║  ██║ ██╔╝ ██╗
 * ╚═════╝  ╚══════╝ ╚═╝  ╚═══╝ ╚═╝  ╚═╝ ╚═╝  ╚═╝
 * BX Global Sort - CSS Stylesheet
 * 
 * Externe Stylesheet-Datei für BX Global Sort Modul.
 * Enthält Styles für:
 * - jQuery UI Sortable Drag & Drop Effekte (state-highlight Placeholder)
 * - Toast-Notifications (success/error mit Slide-Animations)
 * - Row-States (saving/saved/error) für visuelles Feedback
 * - Kategorie-Pfad Badge-Styling (kompakte Chips mit Hover-Effekt)
 * - FontAwesome 6.5.1 Icon-Integration
 * 
 * @package    BX Global Sort
 * @subpackage Stylesheet
 * @category   Admin
 * @author     Axel Benkert
 * @version    1.2
 * @since      1.0.0
 * @date       2025-11-09
 * @copyright  2020-2025 Axel Benkert
 * @license    GNU General Public License
 */

  defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
  if (defined('MODULE_BX_EU_GARAN_STATUS') && MODULE_BX_EU_GARAN_STATUS == 'True' && basename($_SERVER['PHP_SELF']) == 'bx_eu_garan.php') {
?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    div#bx_eu_garan_header {
      display: block; 
      background: #AF417E; 
      border-radius: 4px; 
      margin: 0 0 5px 0; 
      padding: 10px 0 6px 0;
    }

    div#bx_eu_garan_header .main {
      font-weight: bold;
      color: #fff;
      margin: 5px 10px;
      /*text-align: center; */
    }
  </style>
<?php
  }
?>