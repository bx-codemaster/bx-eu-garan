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
  define('TEXT_BX_EU_GARAN_FEEDBACK_WARRANTY_CONTENT_SAVED', 'Gewährleistungsinhalt erfolgreich gespeichert.');
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
  define('TEXT_BX_EU_GARAN_FIELD_GUARANTEE_ACTIVE_NOTE', '<strong>Die Gewährleistungsmitteilung ist immer aktiv!</strong><br>Dieses Feld steuert nur die freiwillige Herstellergarantie, sofern Herstellerinformationen vorliegen.');
  define('TEXT_BX_EU_GARAN_FIELD_COVERS_FULL_PRODUCT', 'Deckt gesamtes Produkt ab');
  define('TEXT_BX_EU_GARAN_FIELD_COVERS_FULL_PRODUCT_NOTE', 'Die Kennzeichnung ist nur erforderlich, wenn das gesamte Produkt abgedeckt ist.');
  define('TEXT_BX_EU_GARAN_FIELD_REQUIRES_ADDITIONAL_COST', 'Zusatzkosten erforderlich');
  define('TEXT_BX_EU_GARAN_FIELD_REQUIRES_ADDITIONAL_COST_NOTE', 'Die Kennzeichnung ist nur erforderlich, wenn keine Zusatzkosten anfallen.');
  define('TEXT_BX_EU_GARAN_FIELD_QR_URL', 'QR URL');
  define('TEXT_BX_EU_GARAN_FIELD_REPAIR_SCORE', 'Reparierbarkeits-Score (0-10)');
  define('TEXT_BX_EU_GARAN_FIELD_MANUAL_URL', 'Handbuch URL');
  define('TEXT_BX_EU_GARAN_PRODUCT_LEGAL_NOTE', '<strong>Gesetzliche Gewährleistung:</strong> immer relevant und automatisch anzuzeigen.<br><strong>Freiwillige Herstellergarantie:</strong> nur angeben, wenn sie für dieses Produkt tatsächlich besteht.');
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
  define('TEXT_BX_EU_GARAN_PRODUCT_LABEL_RULE_NOTE', '<strong>Erforderlich nur wenn:</strong>
    <ul>
    <li>✅ freiwillige Herstellergarantie vorliegt</li>
    <li>✅ mehr als 2 Jahre gilt</li>
    <li>✅ keine Zusatzkosten anfallen</li>
    </ul>');
  define('TEXT_BX_EU_GARAN_PRODUCT_QR_URL', 'QR-URL (optional)');
  define('TEXT_BX_EU_GARAN_PRODUCT_REPAIR_SCORE', 'Reparierbarkeitswert (0-10)');
  define('TEXT_BX_EU_GARAN_PRODUCT_REPAIR_SERVICE_URL', 'Reparatur-Service (URL)');
  define('TEXT_BX_EU_GARAN_PRODUCT_MANUAL_URL', 'Reparatur-Anleitung (URL)');
  define('TEXT_BX_EU_GARAN_PRODUCT_REPAIR_RESTRICTIONS', 'Reparatur-Einschränkungen');
  
  define('TEXT_BX_EU_GARAN_FIELD_PARTS_AVAILABLE', 'Ersatzteile verfügbar');
  define('TEXT_BX_EU_GARAN_FIELD_PARTS_COST_INFO', 'Ersatzteile - Kosteninformationen');
  define('TEXT_BX_EU_GARAN_FIELD_PARTS_AVAILABLE_YEARS', 'Ersatzteilen - Verfügbarkeit in Jahren');
  define('TEXT_BX_EU_GARAN_FIELD_CURRENT_VALUE', 'Aktueller Wert:');

  define('TEXT_BX_EU_GARAN_FILTER_ALL_CATEGORIES', 'Alle Kategorien');
  define('TEXT_BX_EU_GARAN_FILTER_ALL_MANUFACTURERS', 'Alle Hersteller');
  define('TEXT_BX_EU_GARAN_FILTER_WITHOUT_MANUFACTURER', 'Ohne Hersteller');
  define('TEXT_BX_EU_GARAN_FILTER_ALL_PRODUCTS', 'Alle Produkte');
  define('TEXT_BX_EU_GARAN_FILTER_ONLY_ACTIVE', 'Nur aktiv');
  define('TEXT_BX_EU_GARAN_FILTER_ONLY_INACTIVE', 'Nur inaktiv');

  define('BUTTON_BX_EU_GARAN_PREVIEW', 'Vorschau anzeigen');
  define('BUTTON_BX_EU_GARAN_APPLY', 'Änderungen ausführen');
  define('BUTTON_BX_EU_GARAN_SAVE_WARRANTY_CONTENT', 'Gewährleistungstext speichern');
  define('BUTTON_BX_EU_GARAN_DELETE_PRESET', 'Löschen');
  define('BUTTON_BX_EU_GARAN_DELETE_PRESET_CONFIRM', 'Preset wirklich löschen?');
  define('TEXT_BX_EU_GARAN_SAVE_PRESET', 'Aktuelle Konfiguration als Preset speichern');
  define('BUTTON_BX_EU_GARAN_LOAD_PRESET', 'Laden');
  define('BUTTON_BX_EU_GARAN_SAVE_PRESET', 'Speichern');
  define('TEXT_BX_EU_GARAN_LOAD_PRESETS', 'Verfügbare Presets laden');
  define('TEXT_BX_EU_GARAN_NO_PRESETS', 'Noch keine Presets hinterlegt.');

  define('TEXT_BX_EU_GARAN_CONFIRM_MASS_UPDATE', 'Die ausgewählten Felder werden für alle gefilterten Produkte gesetzt. Fortfahren?');
  define('TEXT_BX_EU_GARAN_LEGAL_WARRANTY_BOX_TITLE', 'Gewährleistung');
  define('TEXT_BX_EU_GARAN_LEGAL_WARRANTY_BOX_DESCRIPTION', 'Wählen Sie einen Inhalt aus dem Contentmanager. Aus der coID wird der Link für den Gewährleistungsbutton aufgebaut.');

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

  define('TEXT_WARRANTY_AND_GUARANTEE_TITLE', 'Gewährleistung und Garantie im deutschen Recht');
  define('TEXT_WARRANTY_AND_GUARANTEE_DESC_01', 'In Deutschland werden die Begriffe Gewährleistung und Garantie im Alltag oft synonym verwendet, rechtlich gesehen beschreiben sie jedoch zwei völlig unterschiedliche Konzepte.');
  define('TEXT_WARRANTY_AND_GUARANTEE_DESC_02', 'Hier ist eine Übersicht, die Ordnung in das juristische Chaos bringt.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_TITLE', '1. Die Gewährleistung (Mängelhaftung)');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_DESC', 'Die Gewährleistung ist ein gesetzliches Recht. Sie regelt die Haftung des Verkäufers für Mängel, die bereits zum Zeitpunkt des Kaufs (Übergabe der Ware) bestanden haben.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_1_LABEL', 'Dauer:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_1_TEXT', 'Bei Neuwaren gesetzlich 24 Monate, bei Gebrauchtwaren kann sie auf 12 Monate verkürzt werden.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_2_LABEL', 'Verantwortlich:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_2_TEXT', 'Immer der Verkäufer (Händler), nicht der Hersteller.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_3_LABEL', 'Inhalt:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_3_TEXT', 'Der Käufer hat primär Anspruch auf Nacherfüllung (Reparatur oder Ersatzlieferung). Schlägt dies fehl, kommen Rücktritt, Minderung oder Schadensersatz infrage.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_SUBTITLE', 'Die Beweislastumkehr');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_SUBDESC', 'Dies ist der entscheidende Punkt in der Praxis:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_PROOF_1', 'In den ersten 12 Monaten wird vermutet, dass der Mangel schon beim Kauf vorlag. Der Verkäufer müsste das Gegenteil beweisen.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_PROOF_2', 'Nach 12 Monaten tritt die Beweislastumkehr ein: Nun muss der Käufer beweisen, dass der Fehler bereits bei Übergabe im Keim angelegt war.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_LEGAL_BASIS_TITLE', 'Rechtsgrundlagen:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_LEGAL_BASIS_1', '§ 437 BGB: Rechte des Käufers bei Mängeln.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_LEGAL_BASIS_2', '§ 438 BGB: Verjährung der Mängelansprüche.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_LEGAL_BASIS_3', '§ 477 BGB: Beweislastumkehr (besonders wichtig für Verbrauchsgüterkäufe).');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_TITLE', '2. Die Garantie');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_DESC', 'Die Garantie ist eine freiwillige Leistung. Sie ist ein zusätzliches Versprechen, das über die gesetzlichen Verpflichtungen hinausgeht.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_1_LABEL', 'Dauer:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_1_TEXT', 'Frei wählbar durch den Garantiegeber (z. B. 6 Monate, 5 Jahre oder "lebenslang").');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_2_LABEL', 'Verantwortlich:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_2_TEXT', 'Meistens der Hersteller (Herstellergarantie), seltener der Händler (Händlergarantie).');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_3_LABEL', 'Inhalt:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_3_TEXT', 'Die Bedingungen bestimmt der Garantiegeber selbst. Oft bezieht sie sich auf die Funktionsfähigkeit bestimmter Teile über einen gewissen Zeitraum.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_4_LABEL', 'Verhältnis:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_4_TEXT', 'Eine Garantie darf die gesetzliche Gewährleistung niemals einschränken oder ersetzen. Sie besteht parallel dazu.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_LEGAL_BASIS_TITLE', 'Rechtsgrundlagen:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_LEGAL_BASIS_1', '§ 443 BGB: Garantie.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_LEGAL_BASIS_2', '§ 479 BGB: Besondere Bestimmungen für Garantien beim Verbrauchsgüterkauf (Transparenzpflichten).');
  define('TEXT_WARRANTY_AND_GUARANTEE_SUMMARY_TITLE', 'Zusammenfassung: Die Unterschiede auf einen Blick');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_HEADER_FEATURE', 'Merkmal');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_HEADER_WARRANTY', 'Gewährleistung');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_HEADER_GUARANTEE', 'Garantie');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_STATUS', 'Status');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_STATUS_WARRANTY', 'Gesetzlich vorgeschrieben');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_STATUS_GUARANTEE', 'Freiwillige Zusatzleistung');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_CONTACT', 'Ansprechpartner');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_CONTACT_WARRANTY', 'Verkäufer (Händler)');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_CONTACT_GUARANTEE', 'Meist der Hersteller');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_DURATION', 'Dauer');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_DURATION_WARRANTY', '24 Monate (bei Neuware)');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_DURATION_GUARANTEE', 'Beliebig (je nach Vertrag)');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_COST', 'Kosten');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_COST_WARRANTY', 'Kostenlos für den Käufer');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_COST_GUARANTEE', 'Meist kostenlos inkludiert');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_LEGAL_BASIS', 'Rechtliche Basis');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_LEGAL_BASIS_WARRANTY', '§§ 434 ff. BGB');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_LEGAL_BASIS_GUARANTEE', '§ 443 BGB');
  define('TEXT_WARRANTY_AND_GUARANTEE_SOURCES_TITLE', 'Quellen und Weiterführende Informationen');
  define('TEXT_WARRANTY_AND_GUARANTEE_SOURCE_1', 'Bürgerliches Gesetzbuch (BGB): Die zentrale Rechtsquelle für das Kaufrecht in Deutschland.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SOURCE_2', 'Verbraucherzentrale: Bietet detaillierte Leitfäden zu aktuellen Urteilen und der praktischen Durchsetzung (z. B. zur Schuldrechtsreform 2022).');
  define('TEXT_WARRANTY_AND_GUARANTEE_SOURCE_3', 'Stiftung Warentest: Veröffentlicht regelmäßig Vergleiche zur Handhabung von Reklamationen bei großen Händlern.');
  define('TEXT_WARRANTY_AND_GUARANTEE_NOTE', 'Hinweis: Diese Erläuterung dient der Information und stellt keine Rechtsberatung dar.');
  