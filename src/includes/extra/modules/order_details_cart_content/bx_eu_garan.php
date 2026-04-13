<?php
/**
 * -----------------------------------------------------------------------------------------
 * BX EU Garan - Hook für order_details_cart_content
 * -----------------------------------------------------------------------------------------
 *
 * Zweck
 * - Dieses Hook-File überträgt vorbereitete EU-GARAN Label-Markup-Daten aus dem
 *   Produktdatensatz ($products[$i]) in den Template-Datensatz ($module_content[$i]).
 * - Es erzeugt bewusst KEIN eigenes HTML und führt keine Fachlogik aus.
 *
 * Einbindungspunkt
 * - Die Datei wird in includes/modules/order_details_cart.php per auto_include()
 *   während der Warenkorb-Aufbereitung eingebunden.
 * - Ausführung erfolgt innerhalb der Produkt-Schleife mit gültigem Index $i.
 *
 * Datenfluss
 * - Quelle:
 *   - $products[$i]['eu_garan_legal_label_btn']
 *   - $products[$i]['eu_garan_label_small']
 * - Ziel:
 *   - $module_content[$i]['EU_GARAN_LEGAL_LABEL_BTN']
 *   - $module_content[$i]['EU_GARAN_LABEL_SMALL']
 *
 * Bedingungen
 * - Werte werden nur übernommen, wenn sie vorhanden sind und nach trim() nicht leer sind.
 * - Dadurch bleiben bestehende Template-Ausgaben stabil und es werden keine leeren
 *   Platzhalter gerendert.
 *
 * Wichtige Hinweise
 * - Das File ist ein reines Mapping-Hook-File. Die Label-Erzeugung passiert in den
 *   Modulen includes/modules/shopping_cart/bx_eu_garan_cart.php und
 *   includes/modules/order/bx_eu_garan_order.php.
 * - Löschen/Deaktivieren dieser Datei unterbindet die Label-Anzeige im Warenkorb,
 *   selbst wenn die Label-Daten im Produktdatensatz vorhanden sind.
 */

if (isset($products[$i]['eu_garan_legal_label_btn']) && trim((string)$products[$i]['eu_garan_legal_label_btn']) !== '') {
  $module_content[$i]['EU_GARAN_LEGAL_LABEL_BTN'] = $products[$i]['eu_garan_legal_label_btn'];
}

if (isset($products[$i]['eu_garan_label_small']) && trim((string)$products[$i]['eu_garan_label_small']) !== '') {
  $module_content[$i]['EU_GARAN_LABEL_SMALL'] = $products[$i]['eu_garan_label_small'];
}