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

  define('MODULE_BX_EU_GARAN_TITLE', 'BX EU Herstellergarantie');

  $description = '<h3 style="margin-top:0; display:flex; align-items:center; gap:8px;"><span style="font-size: 2.5em; line-height:1;">🇪🇺</span> BX EU Herstellergarantie</h3><p>ist ein professionelles Verwaltungstool für Modified eCommerce Shopsofware, das die Sortierung von Produkten auf der Startseite und in Kategorien vereinfacht. Mit einer modernen Drag & Drop Oberfläche können Sie Produkte intuitiv per Maus verschieben – die Sortierung wird automatisch gespeichert.</p>';
  
  if((!defined('MODULE_BX_EU_GARAN_STATUS')) || (MODULE_BX_EU_GARAN_STATUS != 'True') && basename($_SERVER['PHP_SELF']) == 'module_export.php') {
    $description .= '<p><a class="button btnbox but_red" style="text-align:center;" onclick="return confirmLink(\'Alle Dateien löschen?\', \'\' ,this);" href="'.xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=bx_global_sort&action=custom').'">Alle Moduldateien löschen</a></p>';
  }

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
