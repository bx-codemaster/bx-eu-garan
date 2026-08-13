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
              basename($_SERVER['PHP_SELF']) == 'categories.php'
              ) {
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

    .bxac-card {
      position: relative;
      border: 1px solid #d9dee8;
      border-radius: 6px;
      background: #ffffff;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
      overflow: hidden;
      margin: 0;
    }

    .bxac-summary {
      list-style: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 2px;
      padding: 4px 8px;
      background: linear-gradient(180deg, rgb(195, 101, 152) 0%, rgb(175, 65, 126) 55%, rgb(146, 46, 102) 100%);
      border-bottom: 1px solid rgb(136, 45, 96);
      color: #ffffff;
    }
    .bxac-summary::-webkit-details-marker {
      display: none;
    }
    .bxac-arrow {
      transition: transform 0.2s ease;
      color: #fff;
      font-size: 40px;
      line-height: 30px;
    }
    .bxac-card[open] .bxac-arrow {
      transform: rotate(90deg);
    }
    .bxac-title {
      margin: 0;
      font-size: 12px;
      line-height: 1.4;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
    }
    .bxac-body {
      padding: 10px 12px;
      background: #f7fbff;
      border-left: 4px solid #c41e3a;
    }
    .bxac-body h4 {
      margin: 8px 0 6px;
      color: #1d3557;
    }
    .bxac-body ul {
      list-style-type: none;
      margin: 0 0 0 10px;
      padding: 0;
      line-height: 1.6;
    }
    .bxac-link {
      margin-top: 12px;
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
  </style>
<?php
  }
?>
  <style>      
    .bxac-card {
      position: relative;
      border: 1px solid #d9dee8;
      border-radius: 6px;
      background: #ffffff;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
      overflow: hidden;
      margin: 0;
    }
    .bx-card-hot {
      position: absolute;
      display: block;
      height: 1.75rem;
      width: auto;
      top: 0.5rem;
      right: -0.5rem;
      font-size: 1.5rem;
    }
    .bxac-summary {
      list-style: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 2px;
      padding: 4px 8px;
      background: linear-gradient(180deg, rgb(195, 101, 152) 0%, rgb(175, 65, 126) 55%, rgb(146, 46, 102) 100%);
      border-bottom: 1px solid rgb(136, 45, 96);
      color: #ffffff;
    }
    .bxac-summary::-webkit-details-marker {
      display: none;
    }
    .bxac-arrow {
      transition: transform 0.2s ease;
      color: #fff;
      font-size: 40px;
    }
    .bxac-card[open] .bxac-arrow {
      transform: rotate(90deg);
    }
    .bxac-title {
      margin: 0;
      font-size: 12px;
      line-height: 1.4;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
    }
    .bxac-body {
      padding: 10px 12px;
      background: #f7fbff;
      border-left: 4px solid #c41e3a;
    }
    .bxac-body h4 {
      margin: 8px 0 6px;
      color: #1d3557;
    }
    .bxac-body ul {
      list-style-type: none;
      margin: 0 0 0 10px;
      padding: 0;
      line-height: 1.6;
    }
    .bxac-link {
      margin-top: 12px;
    }
  </style>