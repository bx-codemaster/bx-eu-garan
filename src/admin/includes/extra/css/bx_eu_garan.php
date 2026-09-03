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
  if (defined('MODULE_BX_EU_GARAN_STATUS') && 
              MODULE_BX_EU_GARAN_STATUS == 'True' && 
              basename($_SERVER['PHP_SELF']) == 'bx_eu_garan.php' ||
              basename($_SERVER['PHP_SELF']) == 'categories.php' ||
              basename($_SERVER['PHP_SELF']) == 'module_export.php'
              ) {
?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>

    div.SumoSelect.filter_manufacturers_id,
    div.SumoSelect.filter_category_id,
    div.SumoSelect.filter_status {
      width: 100% !important;
      max-width: 250px;
    }

    .tableBXConfig{
      width:100%;
      padding:2px;
      border-collapse: collapse;
      margin-top: 5px;
    }
    .tableBXConfig td{
      padding:8px; 
      border-bottom: 1px solid #aaaaaa;
      border-top: 1px solid #aaaaaa;
    }
    .tableBXConfig td a {
      font-size: 12px;
      font-weight: bold;
    }
    .tableBXConfig td.col-left{
      font-size:12px;
      font-weight:bold;
      width:20%;
      background-color:#F1F1F1;
    }
    .tableBXConfig td.col-middle{
      background-color:#e8e8e8;
      width:70px;
    }
    .tableBXConfig td.col-right{
      width:auto;
      empty-cells: show;
      background-color:#F1F1F1;
    }
    .tableBXConfig td.col-single-right{
      background-color:#e8e8e8;
      width:80%;
    }
    .tableBXConfig td.mark{
      background-color:#c8c8c8;
    }
    .tableBXConfig td.col-error{
      background-color:#F2DEDE;
    }

    table.tableBXConfig tr:not(.dataTableHeadingRow),
    table.tableConfig tr:not(.dataTableHeadingRow) {
      border-left: 1px solid #aaa;
      border-right: 1px solid #aaa;
    }

    /* Future: fixed message stack (animated via JS) */
    .fixed_messageStack {
      position: fixed;
      top: 88px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 1000;
      width: 80%;
      padding: 10px 0;
      text-align: center;
      display: none;
    }

    .bx-tab-nav {
        display: flex;
        gap: 2px;
        border-bottom: 1px solid #ccc;
    }

    .bx-tab {
        display: inline-block;
        padding: 8px 15px;
        cursor: pointer;
        background: #eee;
        border: 1px solid #ccc;
        border-bottom: none;
        border-radius: 4px 4px 0 0;
        user-select: none;
    }

    .bx-tab:hover {
        background: #e5e5e5;
    }

    .bx-tab.active {
        background: #fff;
        font-weight: bold;
        position: relative;
        top: 1px;
    }

    .bx-tab-content {
        display: none;
        padding: 15px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .bx-tab-content.active {
        display: block;
    }

    /* Container-Design für das details-Element */
    details.check_delete {
      background-color: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 0.5rem;
      max-width: 450px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04) !important;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      color: #334155;
      transition: all 0.75s ease-in-out;
    }

    details.check_delete[open] {
      border-color: #cbd5e1;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
    }

    /* Header/Summary styling */
    details.check_delete summary {
      cursor: pointer;
      font-weight: 600;
      list-style: none; /* Standart-Dreieck entfernen */
      display: flex;
      align-items: center;
      justify-content: space-between;
      user-select: none;
      padding: 0;
    }

    /* Eigenes Pfeil-Icon erzeugen */
    details.check_delete summary::-webkit-details-marker {
      display: none;
    }

    details.check_delete summary::after {
      content: "";
      display: inline-block;
      width: 10px;
      height: 10px;
      border-right: 2px solid #64748b;
      border-bottom: 2px solid #64748b;
      transform: rotate(-45deg);
      transition: transform 0.2s ease;
      margin-right: 12px;
      margin-left: 0;
    }

    details.check_delete[open] summary::after {
      transform: rotate(45deg);
    }

    details.check_delete summary:hover {
      color: #0f172a;
    }

    /* Styling für alle Labels & Zeilen */
    details.check_delete label {
      display: flex;
      align-items: center;
      margin-left: 0 !important; /* Überschreibt das Inline-Style */
      padding: 6px 10px;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.15s ease;
      font-size: 0.95rem;
    }

    /* Einrückung für die untergeordneten Elemente */
    details.check_delete > label {
      margin-top: 4px;
      margin-left: 16px !important; 
      color: #475569;
    }

    details.check_delete label:hover {
      background-color: #f1f5f9;
    }

    details.check_delete input[type="checkbox"].ChkBox:not(old):not([disabled]) + em {
      line-height: 21px;
      margin-right: 0px;
    }

    /* Hilfs-Tag für Abstand ausblenden/nutzen */
    details.check_delete label em {
      display: none; /* Das inline-nbsp wird nicht mehr benötigt */
    }
  </style>
<?php
  }
?>