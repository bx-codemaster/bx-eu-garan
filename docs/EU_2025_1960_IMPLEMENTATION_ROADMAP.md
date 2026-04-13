# EU-Verordnung 2025/1960 – Implementierungs-Roadmap für modified eCommerce

**Dokument:** Harmonisierte Mitteilung über gesetzliches Gewährleistungsrecht & Haltbarkeitsgarantie-Label  
**Verordnung:** [Durchführungsverordnung (EU) 2025/1960](https://eur-lex.europa.eu/legal-content/DE/TXT/?uri=CELEX:32025R1960)  
**Gültig ab:** 27. September 2026  
**Erstellt:** 2. April 2026 | **Aktualisiert:** 8. April 2026 | **Meilenstein:** Backend produktionsbereit ✅  

---

## 📋 Inhaltsverzeichnis

1. [Verordnung – Kernaussagen](#verordnung--kernaussagen)
2. [Anforderungsübersicht](#anforderungsübersicht)
3. [Umsetzungs-Roadmap](#umsetzungs-roadmap)
4. [Kritische Dateipfade](#kritische-dateipfade)
5. [Technisches Datenmodell](#technisches-datenmodell)
6. [QA-Checkliste](#qa-checkliste)

------

## Verordnung – Kernaussagen

### Zweck
Die Verordnung 2025/1960 schafft zwei harmonisierte Hinweis-Instrumente:

1. **Harmonisierte Mitteilung** (Pflicht für alle Verkäufer)  
   - Informiert Verbraucher über ihr gesetzliches Gewährleistungsrecht (mind. 2 Jahre)
   - Muss vorvertraglich sichtbar sein (Produktseite, Checkout)
   - Einheitliches Design für die EU

2. **Harmonisierte Kennzeichnung** (Pflicht des Händlers – wenn Hersteller Infos liefert)  
   - Label für freiwillige Herstellergarantien auf Haltbarkeit
   - Kennzeichnungspflicht entsteht, wenn der Hersteller dem Händler die Infos bereitstellt
   - **Keine Nachforschungspflicht** des Händlers! (IHK-Klarstellung)
   - Voraussetzungen für die Anzeige:
     - Garantie **> 2 Jahre** Dauer ✓
     - Für **gesamtes Produkt** (nicht einzelne Teile) ✓
     - Ohne Zusatzkosten für Käufer ✓
   - Sprach-neutral: "GARAN" (relevant für alle EU-Sprachen)

3. **Reparierbarkeitswert** (neu ab 27.09.2026 – EmpCo-Richtlinie 2024/825)  
   - Pflicht, über den Reparierbarkeitswert zu informieren (vom Hersteller berechnet)
   - **Aktuell:** Nur für Smartphones und Slate-Tablets
   - **Für alle anderen Produkte:** Informationspflicht über Ersatzteil-Verfügbarkeit, Reparaturkosten, Bestellverfahren für Ersatzteile, Reparatur- und Wartungsanleitungen, Reparatureinschränkungen
   - Gilt nur, sofern der Hersteller diese Infos dem Händler bereitstellt

### Anwendungsdatum
- **Inkrafttreten:** 20 Tage nach Veröffentlichung (erfolgt)
- **Verbindliche Anwendung:** **27. September 2026**

### Wichtige Einschränkungen (Verordnung 2025/1960)
> ⚠️ **Design ist unveränderbar!** Farben, Schriftarten und Inhalte dürfen **nicht** angepasst werden. Labels dürfen nicht verkleinert, verzerrt oder in eigene Designs integriert werden.

> ⚠️ **Geschachteltes Format nur für die harmonisierte Kennzeichnung (Garantie-Label) im Online-Fernabsatz zulässig.** In diesem Fall muss beim **ersten Klick/Hover/Touch** sofort die vollständige Kennzeichnung erscheinen.

### Technische Anforderungen
- **QR-Codes:** Müssen unter Normallicht mobil lesbar sein
- **Farben Online:** Muss farbig sein (Pflicht für Fernabsatzverträge)
- **Farben Offline:** Farbig oder schwarz-weiß zulässig
- **Größen Gewährleistungs-Mitteilung (Offline):** Mind. **A4**; auch A3, A2, A1 möglich
- **Größen Garantie-Etikett (Offline):** Mind. **95 × 100 mm**; Schrift: 7pt mehrsprachig, 9pt Hersteller/Modell, 80pt Jahreszahl
- **Schriftart Garantie-Etikett:** **Inter** (Regular, SemiBold, ExtraBold), auch in editierbaren Feldern
- **Online:** Mitteilung vollständig farbig; Kennzeichnung vollständig farbig und optional geschachtelt nach EU-Vorgabe

---

## Anforderungsübersicht

### Was muss implementiert werden?

| Komponente | Frontend | Admin | Datenbank | Sprache | Priorität |
|------------------------------------|----------------------------------|-----------|------------|---------|-----------|
| Gewährleistungs-Mitteilung         | ✓ (PDP, Checkout, Footer)        | –         | –          | ✓ | KRITISCH |
| Haltbarkeits-Label                 | ✓ (PDP, **Warenkorb**, Checkout) | ✓ Felder  | ✓ Tabelle | ✓ | KRITISCH |
| QR-Code Integration                | ✓ (Generator)                    | –         | –       | – | HOCH |
| Admin-Eingabe-Felder               | – | ✓ Neue Felder                | ✓ Schema  | –       | HOCH |
| E-Mail nach Vertragsschluss        | ✓ Bestellmail                    | –         | –       | ✓ | HOCH |
| Reparierbarkeitswert (Smartphones) | ✓ (PDP)                          | ✓ Felder  | ✓ Felder | ✓ | HOCH |
| Produktdaten-Export                | ✓ im Export-Modul                | –         | ✓ Felder | – | MITTEL |
| PDF/Print-Ausgabe                  | ✓ (Bestelldruck)                 | –         | – | – | MITTEL |

### Anzeigestellen (Muss-Orte)

1. **Website allgemein** (Pflicht – z. B. Footer-Link)
   - Gewährleistungs-Mitteilung: Mind. als "allgemeine Erinnerung" (§ 312d BGB)
   - Empfehlung: Fußzeile mit Verlinkung zum vollständigen Label

2. **Produktdetailseite** ([product_info.php](includes/modules/product_info.php)) (Empfohlen, sicherer)
   - Gewährleistungs-Mitteilung: sichtbar & farbig, vollständig
   - Haltbarkeits-Label: neben dem Produktbild (Erwägungsgrund 28 der RL 2024/825)

3. **Warenkorb** (**PFLICHT** – § 312j Abs. 2 BGB)
   - Garantie-Etikett (Haltbarkeits-Label) **muss** im Warenkorb angezeigt werden
   - Gewährleistungs-Mitteilung: empfohlen

4. **Checkout-Bestätigung** (Pflicht – vor Bestellabschluss)
   - Gewährleistungs-Mitteilung: vollständig, farbig, in Rechtstext-Bereich
   - Haltbarkeits-Label: Pro Produktposition

5. **Bestellbestätigungs-Mail / dauerhafter Datenträger** (**PFLICHT** – § 312f Abs. 2 BGB)
   - Beide Labels müssen nach Vertragsschluss, spätestens bei Lieferung, auf dauerhaftem Datenträger übermittelt werden
   - E-Mail gilt als dauerhafter Datenträger (von der Durchführungs-VO nicht explizit ausgeschlossen)

> ⚠️ **Hinweis:** Eine geschachtelte Anzeige ist nur für die **harmonisierte Kennzeichnung** online zulässig. Dann muss beim ersten Klick/Hover/Touch die vollständige Kennzeichnung erscheinen (Anhang II).

---

## Umsetzungs-Roadmap

### Phase 1: Recht & Fachkonzept (1–2 Tage)

**Ziel:** Verbindliche fachliche Grundlagen schaffen

**Aufgaben:**
- [ ] Finaler Rechtstext für Gewährleistungs-Mitteilung mit Jurist/in abstimmen
- [ ] QR-Code Ziele festlegen:
  - Gewährleistungs-Label: `https://europa.eu/youreurope/legal-guarantee/index.htm` (deutsch)
  - Haltbarkeits-Label: `https://europa.eu/youreurope/commercial-guarantee-durability/index.htm`
- [ ] Geschäftslogik für Haltbarkeits-Label Trigger definieren:
  - Wird Label angezeigt?: → `enabled = 1 AND guarantee_years > 2 AND covers_full_product = 1`
- [ ] Klären: Für welche Produktkategorien liegt ein Reparierbarkeitswert vom Hersteller vor?
- [ ] Prozess definieren: Wie erhalten wir Hersteller-Garantieinfos? (kein eigenes Nachforschen nötig, aber aktiv annehmen wenn geliefert)
- [ ] Design-Guideline für Farbvarianten online/offline – **Design darf nicht verändert werden!**
- [ ] Offizielle SVG/PDF-Vorlagen aus Durchführungs-VO besorgen (noch kein offizieller Download-Link bekannt, IHK 30.03.2026)

**Deliverable:**
- Abgenommener Text für Gewährleistungs-Mitteilung
- Entscheidungsmatrix für Label-Anzeige
- Design-Mockups auf PDP + Checkout

---

### Phase 2: Datenmodell (1–2 Tage)

**Ziel:** Datenhaltung updatesicher etablieren

**Verbindliche Architekturentscheidung (Performance + Wartbarkeit):**
- **Separate 1:1-Modultabellen** statt direkter Erweiterung der `products`-Tabelle
- **Optionales Cache-Flag** in `products` für schnelle Listen-Filterung
- Ergebnis: Sehr gute Laufzeit in PDP/Warenkorb/Checkout bei minimaler Last auf Standard-Produktabfragen

**Neue Tabelle: `bx_products_warranty_guarantee` (Pflichtteil Garantie/Kennzeichnung)**

```sql
CREATE TABLE `bx_products_warranty_guarantee` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `products_id` INT NOT NULL UNIQUE,
  `enabled` TINYINT(1) DEFAULT 0,
  `guarantee_years` INT DEFAULT 0,
  `manufacturer_name_override` VARCHAR(255),
  `model_identifier_override` VARCHAR(255),
  `covers_full_product` TINYINT(1) DEFAULT 1,
  `requires_additional_cost` TINYINT(1) DEFAULT 0,
  `qr_url` VARCHAR(500),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`products_id`) REFERENCES `products`(`products_id`) ON DELETE CASCADE
);
```

**Neue Tabelle: `bx_products_repairability` (Pflichtteil Reparierbarkeitsinfos)**

```sql
CREATE TABLE `bx_products_repairability` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `products_id` INT NOT NULL UNIQUE,
  `repair_score` TINYINT UNSIGNED DEFAULT NULL,
  `parts_available` TINYINT(1) DEFAULT NULL,
  `parts_cost_info` VARCHAR(500) DEFAULT NULL,
  `manual_url` VARCHAR(500) DEFAULT NULL,
  `repair_restrictions` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`products_id`) REFERENCES `products`(`products_id`) ON DELETE CASCADE
);
```

**Optionale Hybrid-Optimierung in `products`:**

```sql
ALTER TABLE `products`
  ADD `bx_has_garan_label` TINYINT(1) NOT NULL DEFAULT 0;
```

**Index-Strategie (performant für euren Use-Case):**
- `UNIQUE(products_id)` auf beiden Modultabellen (1:1-Zugriff)
- Kein unnötiger Mehrspaltenindex für PDP/Warenkorb/Checkout erforderlich
- Optional bei großen Katalogen: `INDEX(enabled, guarantee_years)` auf `bx_products_warranty_guarantee`

**Query-Strategie:**
- Nur dort JOINen, wo Anzeige nötig ist: PDP, Warenkorb, Checkout, Bestellmail
- Kategorie-/Listingseiten ohne EU-Label-Anzeige: kein JOIN auf Modultabellen
- Falls Listen das Label brauchen: erst über `products.bx_has_garan_label` vorfiltern, dann gezielt JOIN

**Migrationsreihenfolge (deploy-sicher):**
1. Tabellen anlegen (`bx_products_warranty_guarantee`, `bx_products_repairability`)
2. Optionales Cache-Flag `products.bx_has_garan_label` anlegen
3. Admin-Speichern implementieren und Flag beim Speichern synchronisieren
4. Frontend-Reads aktivieren (PDP -> Warenkorb -> Checkout -> E-Mail)
5. `EXPLAIN` für Warenkorb- und Checkout-Queries prüfen

**Vorteil:** 
- `products` bleibt schlank und schnell für Standardshop-Abfragen
- Modul bleibt update-sicher und sauber deinstallierbar
- EU- und Reparierbarkeitsdaten sind sauber getrennt und erweiterbar

**Alternative (wenn direkt in Core gewünscht):**
- Mehrere neue Spalten direkt in `products`
- Etwas weniger JOIN-Overhead, aber höhere Last auf allen Produktabfragen
- Für dieses Modul **nicht empfohlen**

**Dateipfade (Schema/Migration):**
- Schema-Datei: `admin/includes/extra/database_tables/bx_products_warranty.php`
- SQL-Init: `includes/extra/database_tables/bx_products_warranty.php`
- Autoloader Integration: Bereits durch Auto-Include

---

### Phase 3: Admin-Pflege (2–3 Tage)

**Ziel:** Backend-Eingabe für Garantiedaten

**Neue Admin-Felder in Produktbearbeitung:**

Ort: [admin/includes/modules/new_product.php](admin/includes/modules/new_product.php#L100-L200)

**Neue Feldgruppe:**
```
+------ HALTBARKEITSGARANTIE ------+
| ☐ Aktiviert
| 
| Garantiedauer (Jahre): [____]
| Min. 2 Jahre for Label-Anzeige
|
| Herstellername: [____________]
| (Leer = Hersteller aus Produkt-Basis)
|
| Modellkennung: [____________]
| (Leer = products_model verwenden)
|
| ☐ Deckt gesamtes Produkt ab
|
| ☑ Keine Zusatzkosten
|   (Muss aktiviert sein für Label)
+-------------------------------+
```

**Sprachlabels ergänzen in:**
- [lang/german/admin/categories.php](lang/german/admin/categories.php)

```php
define('TEXT_PRODUCTS_WARRANTY_GUARANTEE', 'Haltbarkeitsgarantie');
define('TEXT_PRODUCTS_WARRANTY_ENABLED', 'Aktiviert');
define('TEXT_PRODUCTS_WARRANTY_YEARS', 'Garantiedauer (Jahre)');
define('TEXT_PRODUCTS_WARRANTY_MANUFACTURER', 'Herstellername');
define('TEXT_PRODUCTS_WARRANTY_MODEL', 'Modellkennung');
define('TEXT_PRODUCTS_WARRANTY_FULL_PRODUCT', 'Deckt gesamtes Produkt ab');
define('TEXT_PRODUCTS_WARRANTY_NO_COST', 'Keine Zusatzkosten für Käufer');
define('TEXT_PRODUCTS_WARRANTY_HINT', 'Label wird nur angezeigt wenn: aktiviert + Jahre > 2 + Ganzes Produkt + Kostenlos');
```

**Validierung:**
- Jahre nur Integer ≥ 3
- Wenn "aktiviert": alle Bedingungen müssen erfüllt sein
- DB-Fehler bei Einsparungsregelbruch

---

### Phase 4: Frontend – Produktseite (2 Tage)

**Ziel:** Gewährleistungs-Mitteilung + Label auf PDP

**Logik-Erweiterung:**

Datei: [includes/modules/product_info.php](includes/modules/product_info.php)

Neue Abschnitte im Modul (~nach Zeile 280):
```php
// WARRANTY GUARANTEE DATA
$warranty_query = xtc_db_query(
  "SELECT * FROM `bx_products_warranty_guarantee` 
   WHERE `products_id` = '".(int)$product->data['products_id']."'"
);
$warranty_data = array();
if (xtc_db_num_rows($warranty_query) > 0) {
  $warranty_data = xtc_db_fetch_array($warranty_query);
}

// Is label eligible for display?
$show_warranty_label = false;
if ($warranty_data && 
    $warranty_data['enabled'] == 1 && 
    $warranty_data['guarantee_years'] > 2 &&
    $warranty_data['covers_full_product'] == 1 &&
    $warranty_data['requires_additional_cost'] == 0) {
  $show_warranty_label = true;
}

// Assign to Smarty
$info_smarty->assign('WARRANTY_DATA', $warranty_data);
$info_smarty->assign('SHOW_WARRANTY_LABEL', $show_warranty_label);
$info_smarty->assign('WARRANTY_YEARS', (int)$warranty_data['guarantee_years']);
$info_smarty->assign('WARRANTY_MANUFACTURER', 
  $warranty_data['manufacturer_name_override'] ?: $product->data['manufacturers_name']);
$info_smarty->assign('WARRANTY_MODEL', 
  $warranty_data['model_identifier_override'] ?: $product->data['products_model']);
```

**Template-Erweiterung:**

Datei: [templates/tpl_modified_responsive/module/product_info/product_info_v1.html](templates/tpl_modified_responsive/module/product_info/product_info_v1.html)

A) **Gewährleistungs-Mitteilung** (immer anzeigen):
```html
{if isset($MANUFACTURER_NAME)}
<div class="pd_infobox">
  <div class="warranty-notice">
    <h4>{#warranty_notice_title#}</h4>
    <p>{#warranty_notice_content#}</p>
    <div class="warranty-qr">
      <img alt="QR-Code gesetzliche Gewährleistung" 
           src="..." />
    </div>
  </div>
</div>
{/if}
```

B) **Haltbarkeits-Label** (wenn berechtigt):
```html
{if $SHOW_WARRANTY_LABEL}
<div class="warranty-label-container">
  <img class="warranty-label" 
       src="/templates/assets/warranty-label.svg"
       data-years="{$WARRANTY_YEARS}"
       data-manufacturer="{$WARRANTY_MANUFACTURER}"
       data-model="{$WARRANTY_MODEL}"
       alt="Herstellergarantie {$WARRANTY_YEARS} Jahre" />
</div>
{/if}
```

**CSS-Klassen:**
```css
.warranty-notice {
  border: 2px solid #003399;
  padding: 15px;
  background: #f9f9f9;
  margin: 20px 0;
}

.warranty-label-container {
  text-align: center;
  margin: 20px 0;
}

.warranty-label {
  max-width: 200px;
  height: auto;
}
```

---

### Phase 5: Frontend – Warenkorb & Checkout (3 Tage)

**Ziel:** Kennzeichnung im Warenkorb (Pflicht) + Mitteilung und Kennzeichnung in Checkout/E-Mail, sauber getrennt nach Rechtsgrundlage

**Trennung Mitteilung vs. Kennzeichnung (Pflichtlogik):**
- **Harmonisierte Mitteilung (gesetzliches Gewährleistungsrecht):** allgemeiner Hinweis, immer vorvertraglich in hervorgehobener Weise bereitstellen
- **Harmonisierte Kennzeichnung (gewerbliche Haltbarkeitsgarantie):** nur bei Garantie > 2 Jahre, ganze Ware, ohne Zusatzkosten und nur wenn Herstellerdaten vorliegen
- **Warenkorb:** Kennzeichnung ist Pflicht, wenn Kennzeichnungsvoraussetzungen erfüllt sind
- **Geschachtelte Darstellung:** nur für die Kennzeichnung bei Online-Verträgen zulässig; vollständige Kennzeichnung muss beim ersten Klick/Hover/Touch erscheinen

#### Modul-Installreihenfolge und Konfiguration (kurz)

**Ziel:** Hinweistext zu Gewaehrleistung/Garantie im Warenkorb und in der Checkout-Bestaetigung anzeigen, ohne Core-Dateien zu aendern.

1. **Systemmodul zuerst aktivieren (Pflichtabhaengigkeit)**
  - Modul: `bx_eu_garan` (System)
  - Muss aktiv sein: `MODULE_BX_EU_GARAN_STATUS = 'True'`
  - Grund: Die Module lesen Produktdaten aus `bx_products_warranty_guarantee` und zeigen nur bei aktivem Systemmodul Hinweise an.

2. **Shopping-Cart-Modul installieren**
  - Datei: `includes/modules/shopping_cart/bx_eu_garan_cart.php`
  - Konfiguration:
    - `MODULE_SHOPPING_CART_BX_EU_GARAN_CART_STATUS = 'true'`
    - `MODULE_SHOPPING_CART_BX_EU_GARAN_CART_SORT_ORDER` nach Bedarf
  - Eintrag in `MODULE_SHOPPING_CART_INSTALLED` sicherstellen.

3. **Order-Modul installieren**
  - Datei: `includes/modules/order/bx_eu_garan_order.php`
  - Konfiguration:
    - `MODULE_ORDER_BX_EU_GARAN_ORDER_STATUS = 'true'`
    - `MODULE_ORDER_BX_EU_GARAN_ORDER_SORT_ORDER` nach Bedarf
  - Eintrag in `MODULE_ORDER_INSTALLED` sicherstellen.

4. **Ausgabe-Hooks/Template aktiv haben**
  - Warenkorb-Ausgabe (Hook): `includes/extra/modules/order_details_cart_content/bx_eu_garan.php`
  - Checkout-Bestaetigung (Nova): `templates/tpl_modified_nova/module/checkout_confirmation.html`
  - In beiden Faellen wird nur ein optischer Hinweis (`eu_garan_notice`) ausgegeben, kein bestellbares Attribut und keine Bestellpositions-Persistenz.

5. **Fachliche Absicherung**
  - Kein Eingriff in `checkout_process.php` noetig.
  - Wenn keine Herstellergarantie vorliegt, bleibt mindestens der gesetzliche Gewaehrleistungs-Hinweis sichtbar.

**Controller-Erweiterung:**

Datei: [checkout_confirmation.php](checkout_confirmation.php)

Nach Zeile 250 (bei Order-Array-Zusammenstellung):
```php
// Add warranty data to each product
foreach ($order->products as &$product) {
  $warranty_query = xtc_db_query(
    "SELECT * FROM `bx_products_warranty_guarantee` 
     WHERE `products_id` = '".(int)$product['products_id']."'"
  );
  if (xtc_db_num_rows($warranty_query) > 0) {
    $warranty = xtc_db_fetch_array($warranty_query);
    
    // Determine if label eligible
    $product['warranty_enabled'] = (
      $warranty['enabled'] == 1 && 
      $warranty['guarantee_years'] > 2 &&
      $warranty['covers_full_product'] == 1 &&
      $warranty['requires_additional_cost'] == 0
    );
    
    $product['warranty_years'] = $warranty['guarantee_years'];
    $product['warranty_manufacturer'] = 
      $warranty['manufacturer_name_override'] ?: 
      $GLOBALS['product']->data['manufacturers_name'];
    $product['warranty_model'] = 
      $warranty['model_identifier_override'] ?: 
      $product['model'];
  }
}
```

**Template-Erweiterung:**

Datei: [templates/tpl_modified_responsive/module/checkout_confirmation.html](templates/tpl_modified_responsive/module/checkout_confirmation.html)

In der Produktliste (~nach Zeile 160):
```html
{foreach name=aussen item=data from=$PRODUCTS_ARRAY}
  <li>
    {* Existing product row ... *}
    
    {if $data.warranty_enabled}
    <div class="checkout-warranty-label">
      <img src="/templates/assets/warranty-label.svg"
           data-years="{$data.warranty_years}"
           data-manufacturer="{$data.warranty_manufacturer}"
           data-model="{$data.warranty_model}"
           alt="Garantie {$data.warranty_years}J" />
    </div>
    {/if}
  </li>
{/foreach}
```

**Gewährleistungs-Mitteilung** (global auf Seite, ~nach Zeile 40):
```html
<div class="checkout-warranty-notice">
  <h4>{#warranty_notice_title#}</h4>
  <p>{#warranty_notice_content#}</p>
</div>
```

**Warenkorb – Garantie-Etikett (§ 312j Abs. 2 BGB):**

Datei: [templates/tpl_modified_responsive/module/shopping_cart.html](templates/tpl_modified_responsive/module/shopping_cart.html)

```html
{* In der Produktzeile des Warenkorbs *}
{if $product.warranty_enabled}
<div class="cart-warranty-label">
  <img src="/templates/assets/warranty-label.svg"
       data-years="{$product.warranty_years}"
       alt="Garantie {$product.warranty_years} Jahre" />
</div>
{/if}
```

**E-Mail nach Vertragsschluss (§ 312f Abs. 2 BGB):**

Datei: E-Mail-Template in [lang/german/email/](lang/german/email/) (Bestellbestätigungs-Mail)

- Gewährleistungs-Mitteilung als vollständigen Hinweisblock (nicht nur als versteckter Link) einfügen
- Haltbarkeits-Kennzeichnung pro Produkt anhängen (wenn zutreffend)
- Kennzeichnung bei Bedarf geschachtelt darstellen, aber beim ersten Klick/Hover/Touch vollständig öffnen

> ⚠️ Die Durchführungs-VO sieht keine explizite E-Mail-Übermittlung vor – DIN-A4-Ausdruck als Beilage zur Lieferung wäre rechtssicherer. Klärung mit Anwalt empfohlen.

---

### Phase 6: Sprache & Assets (2–3 Tage)

**Ziel:** Alle Texte + visuelle Assets fertig, mit klarer Trennung zwischen Mitteilung und Kennzeichnung

**Frontend-Sprachdatei:**

Datei: [lang/german/lang_german.custom](lang/german/lang_german.custom)

```conf
[warranty_guarantee]
warranty_notice_title = 'Gesetzliche Gewährleistung'
warranty_notice_content = 'Für Ihre Sicherheit: Jedes Produkt unterliegt einer gesetzlichen Gewährleistung von mindestens 2 Jahren. Diese Gewährleistung ist kostenlos und wird automatisch eingeräumt. Es ist kein separater Preis erforderlich. Weitere Informationen finden Sie unter dem QR-Code oder auf https://europa.eu/youreurope/.'

warranty_label_title = 'Herstellergarantie'
warranty_label_duration = '{$years} Jahre Garantie'
warranty_label_manufacturer = 'Hersteller: {$manufacturer}'
warranty_label_model = 'Modell: {$model}'
warranty_label_info = 'Zusätzliche kostenlose Garantie des Herstellers'

checkout_warranty_notice_title = 'Ihre Gewährleistungsrechte'
checkout_warranty_notice_text = 'Mit diesem Kauf erhalten Sie die gesetzlich gewährleisteten Ansprüche gegen Mängel für mindestens 2 Jahre ab Kaufdatum.'

label_nested_trigger_text = 'Mehr zur Herstellergarantie'
label_nested_close_text = 'Schließen'
```

**Text- und Inhaltsregeln aus der Verordnung:**
- Mitteilungselemente sind nicht editierbar
- Kennzeichnung hat feste und editierbare Elemente; editierbar sind nur die vorgesehenen Felder (z. B. XX Jahre, Brand/Trademark, Model identifier)
- Keine eigenen Textkürzungen oder Layout-Umstellungen außerhalb der erlaubten Felder

**QR-Code Generator:**

Neue Hilfsfunktion in [inc/](inc/) neuer Datei `warranty_labels.inc.php`:

```php
<?php
function xtc_generate_warranty_qr_code($type = 'guarantee') {
  $urls = array(
    'guarantee' => 'https://europa.eu/youreurope/legal-guarantee/index.htm?lang=de',
    'durability' => 'https://europa.eu/youreurope/commercial-guarantee-durability/index.htm?lang=de',
  );
  
  $url = $urls[$type] ?? $urls['guarantee'];
  
  // Using a simple QR API (z.B. qr-server.com oder internale Library)
  return 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($url);
}
?>
```

**Visuelle Assets:**

1. **Harmonisiertes Label-Template** (SVG):
   - Datei: [templates/assets/warranty-label-template.svg](templates/assets/warranty-label-template.svg)
   - Größe: 200px × 200px (wird via CSS skaliert)
   - Elementen:
     - "GARAN" Titel (Blau #003399)
     - Häkchen-Symbol (✓)
     - Kalender-Symbol (📅)
     - "XX Jahre" Platzhalter
     - Gestell für Hersteller/Modell (editierbar)
     - QR-Code-Bereich
   - Schrift: **Inter** (Regular, SemiBold, ExtraBold) gemäß Anhang II

   **Nested-Variante (nur Kennzeichnung, nur online):**
   - Kleiner Trigger erlaubt
   - Vollständige Kennzeichnung muss beim ersten Klick/Hover/Touch sofort erscheinen
   - Mitteilung darf nicht als geschachtelte Mini-Variante umgesetzt werden

2. **Mitteilungs-Box CSS:**
   - [templates/css/warranty-notice.css](templates/css/warranty-notice.css)

   ```css
   .warranty-notice {
     background: linear-gradient(135deg, #fff9e6 0%, #fffbf0 100%);
     border-left: 4px solid #003399;
     padding: 15px 20px;
     margin: 20px 0;
     border-radius: 4px;
     font-size: 14px;
     line-height: 1.6;
   }
   
   .warranty-notice h4 {
     color: #003399;
     margin: 0 0 10px 0;
     font-weight: bold;
   }
   
   .warranty-qr {
     text-align: center;
     margin-top: 15px;
   }
   
   .warranty-qr img {
     width: 120px;
     height: 120px;
     border: 1px solid #ddd;
   }
   ```

---

### Phase 7: Reparierbarkeitswert (1–2 Tage, je nach Sortiment)

**Ziel:** Informationspflicht über Reparierbarkeit umsetzen (EmpCo, § 312 BGB)

**Gilt ab 27.09.2026:**
- **Smartphones & Tablets:** Reparierbarkeitswert (Score) anzeigen – Wert kommt vom Hersteller
- **Alle anderen Waren:** Infos über Ersatzteil-Verfügbarkeit, Kosten, Reparaturanleitungen, Einschränkungen
- **Keine Pflicht** wenn Hersteller die Infos nicht liefert
- **Warenkorb:** Hier ist keine zusätzliche Anzeige erforderlich

**Neue Admin-Felder (Produktbearbeitung):**
```
+------ REPARIERBARKEITSWERT ------+
| Reparierbarkeitswert:  [___] /10
| (Nur für Smartphones/Tablets)
|
| Ersatzteile verfügbar: [Ja/Nein/k.A.]
| Geschätzte Kosten:     [________]
| Reparaturanleitung:    [URL/Text]
| Reparatureinschr.:     [Textarea]
+----------------------------------+
```

**Neue Tabellenspalten (alternativ eigene Tabelle):**
```sql
ALTER TABLE `products` 
  ADD `repair_score` TINYINT DEFAULT NULL COMMENT 'Reparierbarkeitswert 0-10',
  ADD `repair_parts_available` TINYINT(1) DEFAULT NULL,
  ADD `repair_parts_cost_info` VARCHAR(500) DEFAULT NULL,
  ADD `repair_manual_url` VARCHAR(500) DEFAULT NULL,
  ADD `repair_restrictions` TEXT DEFAULT NULL;
```

---

### Phase 8: Optional – Import/Export (1–2 Tage)

**Ziel:** Garantie-Daten in Produktexport integrieren

**Exporterweiterung:**

Datei: [admin/includes/modules/export/products_export.php](admin/includes/modules/export/products_export.php)

Bei Datensammlung (~Zeile 75, warranty + repair fields):
```php
// Add warranty guarantee fields
$warranty_query = xtc_db_query(
  "SELECT guarantee_years, manufacturer_name_override, model_identifier_override 
   FROM bx_products_warranty_guarantee 
   WHERE products_id = '".$export['products_id']."' 
   LIMIT 1"
);
if (xtc_db_num_rows($warranty_query) > 0) {
  $warranty = xtc_db_fetch_array($warranty_query);
  $export_data_array['warranty_years'] = $warranty['guarantee_years'];
  $export_data_array['warranty_manufacturer'] = $warranty['manufacturer_name_override'];
  $export_data_array['warranty_model'] = $warranty['model_identifier_override'];
}
```

---

## Kritische Dateipfade

### Frontend (Shop-Sicht)

| Datei | Beschreibung | Änderung |
|-------|-------------|----------|
| [includes/modules/product_info.php](includes/modules/product_info.php) | Produktlogik | Warranty-Daten laden & Smarty-Variablen setzen |
| [templates/tpl_modified_responsive/module/product_info/product_info_v1.html](templates/tpl_modified_responsive/module/product_info/product_info_v1.html) | PDP-Template | Mitteilung & Label anzeigen |
| [checkout_confirmation.php](checkout_confirmation.php) | Checkout-Logik | Warranty-Daten pro Produkt laden |
| [templates/tpl_modified_responsive/module/shopping_cart.html](templates/tpl_modified_responsive/module/shopping_cart.html) | Warenkorb-Template | **Pflicht:** Garantie-Label pro Produkt |
| [templates/tpl_modified_responsive/module/checkout_confirmation.html](templates/tpl_modified_responsive/module/checkout_confirmation.html) | Checkout-Template | Mitteilung & Label-Tabelle |
| E-Mail-Template | Bestellbestätigung | Mitteilung + Label nach Vertragsschluss (§ 312f) |
| [lang/german/lang_german.custom](lang/german/lang_german.custom) | Frontend-Sprache | Neue Textblöcke `[warranty_guarantee]` |

### Admin (Verwaltung)

| Datei | Beschreibung | Änderung |
|-------|-------------|----------|
| [admin/includes/modules/new_product.php](admin/includes/modules/new_product.php) | Produkt-Bearbeitung | Warranty-Eingabefelder |
| [lang/german/admin/categories.php](lang/german/admin/categories.php) | Admin-Sprache | Label-Definitionen |
| [admin/includes/extra/database_tables/bx_products_warranty.php](admin/includes/extra/database_tables/bx_products_warranty.php) | DB-Konstanten | `TABLE_PRODUCTS_WARRANTY_GUARANTEE` |

### Datenbank & Hilfsfunktionen

| Datei/Tabelle | Beschreibung | Details |
|--------|-------------|---------|
| `bx_products_warranty_guarantee` | Neue Tabelle | Schema siehe Phase 2 |
| [inc/warranty_labels.inc.php](inc/warranty_labels.inc.php) | Hilfsfunktionen | QR-Code-Generator, Label-Logik |
| [admin/includes/modules/export/products_export.php](admin/includes/modules/export/products_export.php) | Export-Extension | Warranty-Felder hinzufügen |

### Assets

| Datei | Beschreibung |
|-------|-------------|
| [templates/assets/warranty-label-template.svg](templates/assets/warranty-label-template.svg) | Label-SVG-Template |
| [templates/css/warranty-notice.css](templates/css/warranty-notice.css) | Styling für Mitteilung + Label |

---

## Technisches Datenmodell

### Datenbank-Schema

```sql
-- Warranty Guarantee Table
CREATE TABLE IF NOT EXISTS `bx_products_warranty_guarantee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Label aktiviert?',
  `guarantee_years` int(11) NOT NULL DEFAULT '0' COMMENT 'Garantiedauer in Jahren (min. 2 für Label)',
  `manufacturer_name_override` varchar(255) DEFAULT NULL COMMENT 'Custom Hersteller-Name (sonst products.manufacturers_id)',
  `model_identifier_override` varchar(255) DEFAULT NULL COMMENT 'Custom Modell-ID (sonst products.products_model)',
  `covers_full_product` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Garantie deckt gesamtes Produkt?',
  `requires_additional_cost` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Zusatzkosten nötig? (Must be 0)',
  `qr_url` varchar(500) DEFAULT NULL COMMENT 'Custom QR-Ziel (optional)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_id` (`products_id`),
  FOREIGN KEY (`products_id`) REFERENCES `products`(`products_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
```

### Geschäftslogik-Matrix

**Wann wird das Label angezeigt?**

```
IF (
  enabled = 1 
  AND guarantee_years > 2
  AND covers_full_product = 1
  AND requires_additional_cost = 0
)
THEN show_warranty_label = TRUE
ELSE show_warranty_label = FALSE
```

**Fallbeispiele:**

| Szenario | enabled | years | full | cost | Label? | Begründung |
|----------|---------|-------|------|------|--------|-----------|
| Standard-Produkt | 0 | – | – | – | ❌ | Deaktiviert |
| 3-Jahr-Garantie | 1 | 3 | 1 | 0 | ✅ | Alle Bedingungen erfüllt |
| 2-Jahr-Garantie | 1 | 2 | 1 | 0 | ❌ | Exakt 2 Jahre nicht > 2 |
| Nur Teile garantiert | 1 | 5 | 0 | 0 | ❌ | Nicht auf ganzes Produkt |
| Mit Zusatzkosten | 1 | 5 | 1 | 1 | ❌ | Verbraucher zahlt Mehrkosten |

---

## QA-Checkliste

### Funktionale Tests (vor 27.09.2026)

- [ ] **Produktseite – Gewährleistung**
  - [ ] Mitteilung trägt immer auf
  - [ ] Text ist komplett & aktuell
  - [ ] QR-Code ist mobil lesbar (scan TEST)
  
- [ ] **Produktseite – Label**
  - [ ] Label nur bei 4 Bedingungen erfüllt
  - [ ] Farben korrekt (RGB Mode online)
  - [ ] Garantiejahre, Hersteller, Modell korrekt befüllt
  - [ ] SVG responsive auf Mobile
  
- [ ] **Warenkorb – Garantie-Etikett (PFLICHT § 312j Abs. 2 BGB)**
  - [ ] Label erscheint pro Produkt wenn Bedingungen erfüllt
  - [ ] Vollständig dargestellt (kein Mouse-Over, kein Aufklappen)
  - [ ] Farbig (Online-Pflicht)

- [ ] **Checkout – beide Hinweise**
  - [ ] Mitteilung vor "Kaufen"-Button, vollständig & farbig
  - [ ] Label mit korrekten Daten pro Artikel
  - [ ] Seitenbreite nutzt Platz optimal
  - [ ] Falls geschachtelt: vollständiges Label beim ersten Klick/Hover/Touch

- [ ] **Bestellbestätigungs-Mail / dauerhafter Datenträger (§ 312f Abs. 2 BGB)**
  - [ ] Gewährleistungs-Mitteilung enthalten
  - [ ] Haltbarkeits-Label pro Produkt enthalten (wenn zutreffend)
  - [ ] Rechtliche Klärung: E-Mail vs. DIN-A4-Beilage
  
- [x] **Admin-Input** ✅ Produktionsbereit (08.04.2026)
  - [x] Neue Felder speichern korrekt
  - [x] Datenmodell: separate Tabellen `bx_products_warranty_guarantee` + `bx_products_repairability`
  - [x] Boolean-Felder (covers_full_product, requires_additional_cost) werden korrekt als 0/1 gespeichert
  - [x] Label-Requirement-Anzeige (Badge grün/rot) nach Geschäftslogik
  - [x] Referenzdaten (Hersteller, Modellkennung) automatisch aus Produktstamm
  - [ ] Validierung: Jahre nur 0 oder ≥3
  - [ ] Validierung: Wenn enabled=1, dann alle 4 Bedingungen check

### Browser/Geräte-Kompatibilität

- [ ] Firefox Desktop / Mobile
- [ ] Chrome Desktop / Mobile
- [ ] Safari Desktop / iOS
- [ ] Edge Desktop
- [ ] Print (über Browser-Print) – schwarz/weiß OK?

### Datenschutz & Sicherheit

- [ ] QR-Code-URLs sind öffentlich (DSGVO OK?)
- [ ] Keine Kundendaten im Label/Mitteilung
- [ ] Keine Logs von Garantie-Abrufen

### Sprachenkompatibilität

- [ ] Deutsch: Alle Texte aktuell
- [ ] English (falls Multi-Lang): Texte ergänzt
- [ ] Weitere Sprachen (falls verfügbar): Texte ergänzt

### Import/Export (Phase 7)

- [ ] Export: Warranty-Felder gehen raus
- [ ] Import: Warranty-Felder werden korrekt eingelesen
- [ ] CSV-Header korrekt

### Juristische/Regulatorische

- [ ] Text der Gewährleistungs-Mitteilung von Anwalt/in freigegeben
- [ ] Klärung: E-Mail ausreichend für § 312f Abs. 2 BGB oder Druck-Beilage erforderlich?
- [ ] Design-Konformität: Label unverändert (keine eigenen Farben/Schriften)
- [ ] QR-Code-Ziele regelmäßig getestet (nicht broken links?)
- [ ] Kunden-Service instruiert (FAQ für Gewährleistungs-Anfragen)
- [ ] Prozess für Hersteller-Info-Eingang definiert (Nachforschungspflicht besteht nicht, aber Infos verarbeiten wenn geliefert)

### Reparierbarkeitswert

- [ ] Welche Produkte haben einen Reparierbarkeitswert vom Hersteller?
- [ ] Anzeige auf PDP für Smartphones/Tablets implementiert
- [ ] Für alle anderen Produkte: Ersatzteil-Infos, Kosten, Anleitungen, Einschränkungen gepflegt
- [ ] Admin: Felder vorhanden und befüllbar

---

## Zeitschätzung & Meilensteine

### Gesamt-Dauer: **4–5 Wochen**

| Phase | Dauer | Meilenstein | Status |
|-------|-------|-------------|--------|
| **1. Konzept & Jura** | 1–2 Tage | Freigabetexte, Design-Guideline, § 312f-Klärung | 📋 To-Do |
| **2. Datenmodell** | 1–2 Tage | Schema finalisiert, Migration getestet | ✅ Abgeschlossen (08.04.2026) |
| **3. Admin** | 2–3 Tage | Eingabe funktioniert, Validierung aktiv | ✅ Abgeschlossen (08.04.2026) |
| **4. PDP Frontend** | 2 Tage | Mitteilung + Label korrekt angezeigt | 📋 To-Do |
| **5. Warenkorb & Checkout** | 3 Tage | **Warenkorb-Pflicht** + Bestätigung + E-Mail | 📋 To-Do |
| **6. Sprache & Assets** | 2–3 Tage | Alle Texte, SVG, CSS fertig | 📋 To-Do |
| **7. Reparierbarkeitswert** | 1–2 Tage | Abhängig vom Sortiment | 📌 Je nach Sortiment |
| **8. Import/Export** | 1–2 Tage | Daten austauschbar | 📌 Optional |
| **QA & Testing** | 3–5 Tage | Browser-Compat, Warenkorb, E-Mail, UAT | 📋 To-Do |
| **Deployment** | 1 Tag | Go-Live 27.09.2026 | 🎯 Target |

### Kritischer Pfad  
Phase 1 → Phase 2 → Phase 3 → (Phase 4 + 5 parallel) → Phase 6 → QA → Deploy

---

## Best Practices & Tipps

1. **Updatesicherheit:** Separate Tabelle nutzen; Core-Produkt-Tabelle nicht ändern
2. **Design-Pflicht:** Label **unverändert** verwenden – keine eigenen Farben, Schriftarten, Skalierungen; Design ist durch Verordnung festgelegt
3. **Verschachtelung nur wo erlaubt:** Nur die harmonisierte Kennzeichnung darf online geschachtelt sein; beim ersten Klick/Hover/Touch muss die vollständige Kennzeichnung erscheinen
4. **Warenkorb ist Pflicht:** § 312j Abs. 2 BGB – Garantie-Etikett muss im Warenkorb erscheinen
5. **E-Mail / dauerhafter Datenträger:** § 312f Abs. 2 BGB – Labels nach Vertragsschluss übermitteln; Klärung ob E-Mail ausreicht
6. **Keine Nachforschungspflicht:** Händler muss Garantie-Infos verarbeiten wenn Hersteller sie liefert, aber nicht aktiv suchen
7. **QR-Codes:** Regelmäßig testen (nicht broken links); Offizielle EU-URLs verwenden
8. **SVG:** Für Label verwenden (skalierbar, Responsive) – aus offizieller Vorlage generieren
9. **Testing:** Warenkorb mobil + Desktop; QR-Scan; E-Mail-Ansicht prüfen
10. **Deployment:** Feature-Flag/Config Boolean für Aktivierung → einfacher Rollback

---

## Referenzen

- **Verordnung (EU) 2025/1960:** https://eur-lex.europa.eu/legal-content/DE/TXT/?uri=CELEX:32025R1960
- **EmpCo-Richtlinie (EU) 2024/825:** https://eur-lex.europa.eu/legal-content/DE/TXT/?uri=CELEX:32024L0825
- **IHK Stuttgart – Neue Informationspflichten (30.03.2026):** https://www.ihk.de/stuttgart/fuer-unternehmen/recht-und-steuern/wettbewerbsrecht/garantien-und-gewaehrleistung-neue-informationspflichten-7004604
- **Bundesgesetzblatt 2026 (Umsetzungsgesetz):** https://www.recht.bund.de/bgbl/1/2026/28/VO.html
- **EUR-Lex – Your Europe Portal:** https://europa.eu/youreurope/
- **modified Documentation:** https://www.modified-shop.org/
- **QR-Code Standard (ISO/IEC 18004):** Mindest-Lesbarkeit mobil; 200×200px empfohlen

---

**Dokument-Version:** 1.4 | **Letzte Änderung:** 5. April 2026  
**Quellen:** EU 2025/1960, EmpCo 2024/825, IHK Stuttgart (30.03.2026), BGB §§ 312d, 312f, 312j  
**Verantwortlich:** Development Team | **Status:** Draft – Juristische Freigabe ausstehend
