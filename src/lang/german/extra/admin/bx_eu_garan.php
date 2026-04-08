<?php
/** 
 * ██████╗  ███████╗ ███╗   ██╗  █████╗  ██╗  ██╗
 * ██╔══██╗ ██╔════╝ ████╗  ██║ ██╔══██╗ ╚██╗██╔╝
 * ██████╔╝ █████╗   ██╔██╗ ██║ ███████║  ╚███╔╝
 * ██╔══██╗ ██╔══╝   ██║╚██╗██║ ██╔══██║  ██╔██╗
 * ██████╔╝ ███████╗ ██║ ╚████║ ██║  ██║ ██╔╝ ██╗
 * ╚═════╝  ╚══════╝ ╚═╝  ╚═══╝ ╚═╝  ╚═╝ ╚═╝  ╚═╝
 * BX EU Garan - Deutsche Sprachtexte
 * 
 * Interface-Texte für das BX EU Modul (Admin-Bereich).
 * Alle UI-Elemente, Buttons und Beschreibungen in deutscher Sprache.
 * 
 * @package    BX EU Garan
 * @subpackage Language
 * @category   Admin
 * @author     Axel Benkert
 * @version    1.0.0
 * @date       2026-04-05
 * @copyright  2020-2026 Axel Benkert
 * @license    GNU General Public License
 */

  define('HEADING_BX_EU_GARAN_TITLE', 'BX EU Gewährleistung und Herstellergarantie');
  define('HEADING_BX_EU_GARAN_SUB_TITLE', 'Zentrale Verwaltung der harmonisierten Gewährleistungsmitteilung und der freiwilligen Herstellergarantie.');
  define('HEADING_BX_EU_GARAN_MASS_EDIT_TITLE', 'Massenbearbeitung Herstellergarantie und Reparierbarkeit');
  define('HEADING_BX_EU_GARAN_PRODUCT_WARRANTY', 'BX EU Herstellergarantie');
  define('HEADING_BX_EU_GARAN_PRODUCT_REPAIRABILITY', 'BX EU Reparierbarkeit');

  define('TEXT_BX_EU_GARAN_MASS_EDIT_DESCRIPTION', 'Setzen Sie ausgewählte Felder der freiwilligen Herstellergarantie und Reparierbarkeit für viele Produkte gleichzeitig per Kategorie- und/oder Herstellerfilter.');
  define('TEXT_BX_EU_GARAN_MASS_EDIT_LEGAL_NOTE', 'Die harmonisierte Mitteilung zur gesetzlichen Gewährleistung ist immer relevant.<br>Die harmonisierte Kennzeichnung zur Garantie wird nur angezeigt, wenn eine freiwillige Herstellergarantie besteht.');
  define('TEXT_BX_EU_GARAN_FEEDBACK_SELECT_AT_LEAST_ONE_FIELD', 'Bitte mindestens ein Feld zum Setzen auswählen.');
  define('TEXT_BX_EU_GARAN_FEEDBACK_NO_PRODUCTS_FOUND', 'Keine Produkte mit den gewählten Filtern gefunden.');
  define('TEXT_BX_EU_GARAN_FEEDBACK_SUCCESS', 'Änderung erfolgreich. Produkte: %d, Garantie-Updates: %d, Reparierbarkeits-Updates: %d.');
  define('TEXT_BX_EU_GARAN_PREVIEW_RESULT', 'Vorschau: <strong>%d</strong> Produkte betroffen.');

  define('TEXT_BX_EU_GARAN_TABLE_HEADING_FILTER', 'Filter');
  define('TEXT_BX_EU_GARAN_TABLE_HEADING_FIELD', 'Feld');
  define('TEXT_BX_EU_GARAN_TABLE_HEADING_SET', 'Setzen');
  define('TEXT_BX_EU_GARAN_TABLE_HEADING_VALUE', 'Wert');
  define('TEXT_BX_EU_GARAN_TABLE_HEADING_NOTE', 'Anmerkung');

  define('TEXT_BX_EU_GARAN_FIELD_CATEGORY', 'Kategorie');
  define('TEXT_BX_EU_GARAN_FIELD_INCLUDE_SUBCATEGORIES', 'Unterkategorien einbeziehen');
  define('TEXT_BX_EU_GARAN_FIELD_MANUFACTURER', 'Hersteller');
  define('TEXT_BX_EU_GARAN_FIELD_PRODUCT_STATUS', 'Artikelstatus');
  define('TEXT_BX_EU_GARAN_FIELD_GUARANTEE_YEARS', 'Dauer der Herstellergarantie (Jahre)');
  define('TEXT_BX_EU_GARAN_FIELD_GUARANTEE_YEARS_NOTE', 'Die Kennzeichnung ist nur erforderlich bei mehr als 2 Jahren.');
  define('TEXT_BX_EU_GARAN_FIELD_GUARANTEE_ACTIVE', 'Freiwillige Herstellergarantie vorhanden');
  define('TEXT_BX_EU_GARAN_FIELD_GUARANTEE_ACTIVE_NOTE', 'Die Gewährleistungsmitteilung ist immer aktiv!<br>Dieses Feld steuert nur die freiwillige Herstellergarantie, sofern Herstellerinformationen vorliegen.');
  define('TEXT_BX_EU_GARAN_FIELD_REQUIRES_ADDITIONAL_COST', 'Zusatzkosten erforderlich');
  define('TEXT_BX_EU_GARAN_FIELD_REQUIRES_ADDITIONAL_COST_NOTE', 'Die Kennzeichnung ist nur erforderlich, wenn keine Zusatzkosten anfallen.');
  define('TEXT_BX_EU_GARAN_FIELD_QR_URL', 'QR URL');
  define('TEXT_BX_EU_GARAN_FIELD_REPAIR_SCORE', 'Reparierbarkeits-Score (0-10)');
  define('TEXT_BX_EU_GARAN_FIELD_PARTS_AVAILABLE', 'Ersatzteile verfügbar');
  define('TEXT_BX_EU_GARAN_FIELD_MANUAL_URL', 'Handbuch URL');
  define('TEXT_BX_EU_GARAN_PRODUCT_LEGAL_NOTE', 'Gesetzliche Gewährleistung: immer relevant und automatisch anzuzeigen.<br>Freiwillige Herstellergarantie: nur angeben, wenn sie für dieses Produkt tatsächlich besteht.');
  define('TEXT_BX_EU_GARAN_PRODUCT_ENABLED', 'Freiwillige Herstellergarantie vorhanden');
  define('TEXT_BX_EU_GARAN_PRODUCT_ENABLED_NOTE', 'Steuert ausschließlich das Garantie-Etikett.<br>Die harmonisierte Gewährleistungsmitteilung ist davon unabhängig und immer relevant.<br>Keine Nachforschungspflicht: Kennzeichnung nur bei vom Hersteller bereitgestellten Informationen.');
  define('TEXT_BX_EU_GARAN_PRODUCT_GUARANTEE_YEARS', 'Dauer der Herstellergarantie (Jahre)');
    define('TEXT_BX_EU_GARAN_PRODUCT_MANUFACTURER_AUTO', 'Hersteller (automatisch)');
    define('TEXT_BX_EU_GARAN_PRODUCT_MODEL_IDENTIFIER_AUTO', 'Modellkennung (automatisch)');
    define('TEXT_BX_EU_GARAN_PRODUCT_MODEL_IDENTIFIER_NOTE', 'Ermittlung automatisch aus Herstellermodell, EAN oder Artikelnummer.');
    define('TEXT_BX_EU_GARAN_PRODUCT_COVERS_FULL_PRODUCT', 'Deckt gesamtes Produkt ab');
    define('TEXT_BX_EU_GARAN_PRODUCT_REQUIRES_ADDITIONAL_COST', 'Zusatzkosten erforderlich');
    define('TEXT_BX_EU_GARAN_PRODUCT_LABEL_REQUIREMENT', 'Garantie-Kennzeichnung erforderlich');
    define('TEXT_BX_EU_GARAN_PRODUCT_LABEL_REQUIRED', 'Ja');
    define('TEXT_BX_EU_GARAN_PRODUCT_LABEL_NOT_REQUIRED', 'Nein');
    define('TEXT_BX_EU_GARAN_PRODUCT_LABEL_RULE_NOTE', 'Erforderlich nur wenn:
      <ul>
      <li>freiwillige Herstellergarantie vorliegt</li>
      <li>mehr als 2 Jahre gilt</li>
      <li>keine Zusatzkosten anfallen</li>
      </ul>');
    define('TEXT_BX_EU_GARAN_PRODUCT_QR_URL', 'QR-URL (optional)');
    define('TEXT_BX_EU_GARAN_PRODUCT_REPAIR_SCORE', 'Reparierbarkeitswert (0-10)');
    define('TEXT_BX_EU_GARAN_PRODUCT_PARTS_AVAILABLE', 'Ersatzteile verfügbar');
    define('TEXT_BX_EU_GARAN_PRODUCT_PARTS_COST_INFO', 'Kosteninfo Ersatzteile');
    define('TEXT_BX_EU_GARAN_PRODUCT_MANUAL_URL', 'Reparaturanleitung (URL)');
    define('TEXT_BX_EU_GARAN_PRODUCT_REPAIR_RESTRICTIONS', 'Reparatureinschränkungen');

  define('TEXT_BX_EU_GARAN_FILTER_ALL_CATEGORIES', 'Alle Kategorien');
  define('TEXT_BX_EU_GARAN_FILTER_ALL_MANUFACTURERS', 'Alle Hersteller');
  define('TEXT_BX_EU_GARAN_FILTER_WITHOUT_MANUFACTURER', 'Ohne Hersteller');
  define('TEXT_BX_EU_GARAN_FILTER_ALL_PRODUCTS', 'Alle Produkte');
  define('TEXT_BX_EU_GARAN_FILTER_ONLY_ACTIVE', 'Nur aktiv');
  define('TEXT_BX_EU_GARAN_FILTER_ONLY_INACTIVE', 'Nur inaktiv');

  define('BUTTON_BX_EU_GARAN_PREVIEW', 'Vorschau anzeigen');
  define('BUTTON_BX_EU_GARAN_APPLY', 'Änderungen ausführen');
  define('TEXT_BX_EU_GARAN_CONFIRM_MASS_UPDATE', 'Die ausgewählten Felder werden für alle gefilterten Produkte gesetzt. Fortfahren?');

  define('TEXT_BX_EU_GARAN_INFOBOX_TITLE', 'Informationen');
  define('TEXT_BX_EU_GARAN_URL_NEW_LABELS', 'https://www.it-recht-kanzlei.de/neue-label-gewaehrleistung-garantie-2026.html');
  define('TEXT_BX_EU_GARAN_URL_FAQ', 'https://www.it-recht-kanzlei.de/faq-gewaehrleistunglabel-garantielabel.html');
  define('TEXT_BX_EU_GARAN_URL_IHK', 'https://www.ihk.de/stuttgart/fuer-unternehmen/recht-und-steuern/wettbewerbsrecht/garantien-und-gewaehrleistung-neue-informationspflichten-7004604');
  define('TEXT_BX_EU_GARAN_URL_EUR_LEX', 'https://eur-lex.europa.eu/legal-content/DE/TXT/?uri=CELEX:32025R1960');
  define('TEXT_BX_EU_GARAN_LINK_NEW_LABELS', 'Neue Gewährleistungs- und Garantie-Label');
  define('TEXT_BX_EU_GARAN_LINK_FAQ', 'FAQ zum Gewährleistungs- und Garantielabel');
  define('TEXT_BX_EU_GARAN_LINK_IHK', 'IHK Stuttgart: Garantien und Gewährleistung');
  define('TEXT_BX_EU_GARAN_LINK_EUR_LEX', 'Durchführungsverordnung (EU) 2025/1960 der Kommission vom 25. September 2025');
  define('TEXT_BX_EU_GARAN_NO_INFO_PROVIDED', 'k. A.');
