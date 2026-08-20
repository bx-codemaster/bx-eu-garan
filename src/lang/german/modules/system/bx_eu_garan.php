<?php
/** 
 * ██████╗  ███████╗ ███╗   ██╗  █████╗  ██╗  ██╗
 * ██╔══██╗ ██╔════╝ ████╗  ██║ ██╔══██╗ ╚██╗██╔╝
 * ██████╔╝ █████╗   ██╔██╗ ██║ ███████║  ╚███╔╝
 * ██╔══██╗ ██╔══╝   ██║╚██╗██║ ██╔══██║  ██╔██╗
 * ██████╔╝ ███████╗ ██║ ╚████║ ██║  ██║ ██╔╝ ██╗
 * ╚═════╝  ╚══════╝ ╚═╝  ╚═══╝ ╚═╝  ╚═╝ ╚═╝  ╚═╝
 * BX EU Garan - German System Module Texts
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

  define('MODULE_BX_EU_GARAN_TITLE', 'BX EU Garan');

  $description = '
  <details class="bxac-card">
    <summary class="bxac-summary" style="list-style: none;">
      <span class="bxac-arrow">▸</span>
      ' . xtc_image(DIR_WS_ICONS.'heading/bx_eu_garan.png', 'BX EU Garan', '', '', 'style="max-height: 32px; margin: 2px;"') . '
      <span class="bxac-title">BX EU Garan</span>
    </summary>
    <div class="bxac-body">
    <h3 style="margin-top: 0;">Herstellergarantie und EU-Konformität</h3>
    <p>ist ein professionelles Verwaltungstool für Modified eCommerce Shopsofware.</p>';
  
  if((!defined('MODULE_BX_EU_GARAN_STATUS')) || (MODULE_BX_EU_GARAN_STATUS != 'True') && basename($_SERVER['PHP_SELF']) == 'module_export.php') {
    $description .= '<p><a class="button btnbox but_red" style="text-align:center;" onclick="return confirmLink(\'Alle Dateien löschen?\', \'\' ,this);" href="'.xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=bx_eu_garan&action=custom').'">Alle Moduldateien löschen</a></p>';
  }
  $description .= '</div></details>';

  define('MODULE_BX_EU_GARAN_DESC', $description);
  
  define('MODULE_BX_EU_GARAN_STATUS_TITLE', 'Modul aktiv?');
  define('MODULE_BX_EU_GARAN_STATUS_DESC', 'Soll das Modul angezeigt werden?');
  
  define('MODULE_BX_EU_GARAN_VERSION_TITLE', 'Modulversion');
  define('MODULE_BX_EU_GARAN_VERSION_DESC', 'Die aktuelle Version des Moduls.');

  define('MODULE_BX_EU_GARAN_CONFIG_ID_TITLE', 'Konfigurations-ID');
  define('MODULE_BX_EU_GARAN_CONFIG_ID_DESC', 'Die eindeutige ID für die Modulkonfiguration. Wird automatisch generiert und sollte nicht geändert werden.');

  // Custom Deinstallation Messages
  define('MODULE_BX_EU_GARAN_TEXT_FILES_DELETED', 'Erfolgreich gelöscht:');
  define('MODULE_BX_EU_GARAN_TEXT_FILES_FAILED', 'Fehler beim Löschen (bitte manuell per FTP entfernen):');
  define('MODULE_BX_EU_GARAN_TEXT_SUCCESSFULLY_REMOVED', 'BX EU Garan wurde vollständig entfernt!');
  define('MODULE_BX_EU_GARAN_TEXT_REMOVAL_INCOMPLETE', 'BX EU Garan wurde teilweise entfernt. Bitte prüfen Sie die Fehlermeldungen und löschen Sie die verbliebenen Dateien manuell per FTP.');
  define('MODULE_BX_EU_GARAN_TEXT_COULD_NOT_BE_DELETED', 'Die folgenden Dateien konnten nicht gelöscht werden:');
  define('MODULE_BX_EU_GARAN_WARRANTY_CONTENT_GROUP_TITLE', 'Garantieinformationen');
  define('MODULE_BX_EU_GARAN_WARRANTY_CONTENT_GROUP_DESC', 'Hier können Sie die Garantieinformationen für Ihre Produkte eingeben. Diese Informationen werden auf der Produktdetailseite angezeigt und informieren Ihre Kunden über die Herstellergarantie und EU-Konformität Ihrer Produkte.');
  define('MODULE_BX_EU_GARAN_NEW_WINDOW_TITLE', 'In neuem Fenster öffnen?');
  define('MODULE_BX_EU_GARAN_NEW_WINDOW_DESC', 'Soll der Link in einem neuen Fenster geöffnet werden?');

  define('MODULE_BX_EU_GARAN_CATEGORIES_DEINSTALL_FIRST', 'Bitte deinstallieren Sie zuerst das Modul "BX EU Garan Kategorien" bevor Sie das Hauptmodul deinstallieren. (Module -> Klassenerweiterungen -> Kategorien)');
  define('MODULE_BX_EU_GARAN_ORDER_DEINSTALL_FIRST', 'Bitte deinstallieren Sie zuerst das Modul "BX EU Garan Bestellungen" bevor Sie das Hauptmodul deinstallieren. (Module -> Klassenerweiterungen -> Bestellungen)');
  define('MODULE_BX_EU_GARAN_CART_DEINSTALL_FIRST', 'Bitte deinstallieren Sie zuerst das Modul "BX EU Garan Warenkorb" bevor Sie das Hauptmodul deinstallieren. (Module -> Klassenerweiterungen -> Warenkorb)');
