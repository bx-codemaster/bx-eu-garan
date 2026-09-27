<?php
/* -----------------------------------------------------------------------------------------
   BX EU Garan - zentrale Datenzugriffsklasse

   Einziger Ort im gesamten Modul, der den Tabellennamen von bx_eu_garan_guarantee kennt.
   Alle anderen Dateien (Kategorien-Hook, Massenänderung, new_product-Formular) rufen
   ausschließlich diese Klasse auf.
   ---------------------------------------------------------------------------------------*/

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

class bx_eu_garan_store {

  private string $table;
  private string $logTable;

  public function __construct() {
    if (!defined('TABLE_BX_EU_GARAN_GUARANTEE') || !defined('TABLE_BX_EU_GARAN_MASS_LOG')) {
      // Bewusst kein Fallback-String hier: genau diese Art doppelt gepflegter
      // Tabellennamen hat den ursprünglichen Bug verursacht. Lieber laut scheitern,
      // wenn die Konstanten (aus includes/extra/header/header_head/bx_eu_garan.php)
      // aus irgendeinem Grund nicht geladen wurden.
      throw new RuntimeException('BX_EU_GARAN_TABLES_NOT_DEFINED');
    }
    $this->table    = TABLE_BX_EU_GARAN_GUARANTEE;
    $this->logTable = TABLE_BX_EU_GARAN_MASS_LOG;
  }

  /**
   * Liest die Garantiedaten eines Produkts. Existiert noch kein Datensatz,
   * werden Default-Werte (inkl. revision = 0) zurückgegeben.
   */
  public function get(int $productsId): array {
    $productsId = (int)$productsId;
    if ($productsId > 0) {
      $result = $this->queryOrThrow("SELECT * FROM `".$this->table."` WHERE `products_id` = '".$productsId."' LIMIT 1");
      if (xtc_db_num_rows($result) > 0) {
        $row = xtc_db_fetch_array($result);
        $row['manufacturer_guarantee_available'] = (int)$row['manufacturer_guarantee_available'];
        $row['guarantee_years']                  = (int)$row['guarantee_years'];
        $row['covers_full_product']              = (int)$row['covers_full_product'];
        $row['requires_additional_cost']         = (int)$row['requires_additional_cost'];
        $row['revision']                         = (int)($row['revision'] ?? 0);
        return $row;
      }
    }
    return $this->defaults($productsId);
  }

  /**
   * Speichert (Insert oder Update) genau ein Produkt.
   *
   * @param array    $products_data     Rohdaten, z.B. direkt aus $_POST bzw. dem Hook-Array.
   * @param int|null $expectedRevision  Wenn gesetzt: Concurrency-Check gegen die aktuelle DB-Revision.
   * @param int|null $actorId           Admin-ID für das Audit-Log (optional).
   *
   * @throws RuntimeException bei Revisionskonflikt.
   */
  public function save(int $productsId, array $products_data, ?int $expectedRevision = null, ?int $actorId = null): void {
    $productsId = (int)$productsId;
    if ($productsId <= 0) {
      return;
    }

    $columns = $this->normalize($products_data);
    $sql = "INSERT INTO `".$this->table."`
      (`products_id`, `manufacturer_guarantee_available`, `guarantee_years`, `covers_full_product`,
       `requires_additional_cost`, `qr_url`, `revision`, `created_at`, `updated_at`)
      VALUES (
        ".$productsId.",
        ".$columns['manufacturer_guarantee_available'].",
        ".$columns['guarantee_years'].",
        ".$columns['covers_full_product'].",
        ".$columns['requires_additional_cost'].",
        ".$this->toSqlNullableString($columns['qr_url']).",
        1,
        NOW(),
        NOW()
      )
      ON DUPLICATE KEY UPDATE
        `manufacturer_guarantee_available` = VALUES(`manufacturer_guarantee_available`),
        `guarantee_years` = VALUES(`guarantee_years`),
        `covers_full_product` = VALUES(`covers_full_product`),
        `requires_additional_cost` = VALUES(`requires_additional_cost`),
        `qr_url` = VALUES(`qr_url`),
        `revision` = `revision` + 1,
        `updated_at` = NOW()";
    $this->queryOrThrow("START TRANSACTION");
    try {
      if ($expectedRevision !== null) {
        $revisionQuery = $this->queryOrThrow("SELECT `revision` FROM `".$this->table."` WHERE `products_id` = '".$productsId."' LIMIT 1 FOR UPDATE");
        $currentRevision = xtc_db_num_rows($revisionQuery) > 0
          ? (int)xtc_db_fetch_array($revisionQuery)['revision']
          : 0;
        if ($currentRevision !== $expectedRevision) {
          throw new RuntimeException('BX_EU_GARAN_CONCURRENT_CHANGE');
        }
      }

      $this->queryOrThrow($sql);
      $this->log($actorId, 'single_save', [$productsId], $columns);
      $this->queryOrThrow("COMMIT");
    } catch (Throwable $e) {
      xtc_db_query("ROLLBACK");
      throw $e;
    }
  }

  /**
   * Massenänderung "Setzen": schreibt dieselben Werte für mehrere Produkte.
   * Gibt die Anzahl der tatsächlich verarbeiteten Produkte zurück.
   */
  public function saveMany(array $productsIds, array $patch, ?int $actorId = null): int {
    $productsIds = array_values(array_unique(array_map('intval', $productsIds)));
    $productsIds = array_filter($productsIds, fn($id) => $id > 0);
    if (!$productsIds) {
      return 0;
    }

    $columns = $this->normalize($patch);

    $this->queryOrThrow("START TRANSACTION");
    try {
      foreach (array_chunk($productsIds, 500) as $chunkIds) {
        $values = [];
        foreach ($chunkIds as $productsId) {
          $values[] = "("
            .$productsId.","
            .$columns['manufacturer_guarantee_available'].","
            .$columns['guarantee_years'].","
            .$columns['covers_full_product'].","
            .$columns['requires_additional_cost'].","
            .$this->toSqlNullableString($columns['qr_url']).","
            ."1,NOW(),NOW())";
        }

        $sql = "INSERT INTO `".$this->table."`
          (`products_id`, `manufacturer_guarantee_available`, `guarantee_years`, `covers_full_product`,
           `requires_additional_cost`, `qr_url`, `revision`, `created_at`, `updated_at`)
          VALUES ".implode(',', $values)."
          ON DUPLICATE KEY UPDATE
            `manufacturer_guarantee_available` = VALUES(`manufacturer_guarantee_available`),
            `guarantee_years` = VALUES(`guarantee_years`),
            `covers_full_product` = VALUES(`covers_full_product`),
            `requires_additional_cost` = VALUES(`requires_additional_cost`),
            `qr_url` = VALUES(`qr_url`),
            `revision` = `revision` + 1,
            `updated_at` = NOW()";
        $this->queryOrThrow($sql);
      }

      $this->log($actorId, 'mass_save', $productsIds, $columns);
      $this->queryOrThrow("COMMIT");
    } catch (Throwable $e) {
      xtc_db_query("ROLLBACK");
      throw $e;
    }

    return count($productsIds);
  }

  /**
   * Löscht die Garantiedaten für ein einzelnes Produkt (z.B. remove_product-Hook).
   */
  public function delete(int $productsId, ?int $actorId = null): void {
    $productsId = (int)$productsId;
    if ($productsId <= 0) {
      return;
    }
    $this->queryOrThrow("START TRANSACTION");
    try {
      $this->queryOrThrow("DELETE FROM `".$this->table."` WHERE `products_id` = '".$productsId."'");
      $this->log($actorId, 'single_delete', [$productsId], []);
      $this->queryOrThrow("COMMIT");
    } catch (Throwable $e) {
      xtc_db_query("ROLLBACK");
      throw $e;
    }
  }

  /**
   * Massenänderung "Löschen". Gibt die Anzahl der betroffenen Produkte zurück.
   */
  public function deleteMany(array $productsIds, ?int $actorId = null): int {
    $productsIds = array_values(array_unique(array_map('intval', $productsIds)));
    $productsIds = array_filter($productsIds, fn($id) => $id > 0);
    if (!$productsIds) {
      return 0;
    }

    $this->queryOrThrow("START TRANSACTION");
    try {
      $idsList = implode(',', $productsIds);
      $this->queryOrThrow("DELETE FROM `".$this->table."` WHERE `products_id` IN (".$idsList.")");

      $this->log($actorId, 'mass_delete', $productsIds, []);
      $this->queryOrThrow("COMMIT");
    } catch (Throwable $e) {
      xtc_db_query("ROLLBACK");
      throw $e;
    }

    return count($productsIds);
  }

  /**
   * Kopiert die Garantiedaten eines Produkts auf ein anderes (z.B. duplicate_product_after-Hook).
   */
  public function duplicate(int $srcProductsId, int $dupProductsId, ?int $actorId = null): void {
    $srcProductsId = (int)$srcProductsId;
    $dupProductsId = (int)$dupProductsId;
    if ($srcProductsId <= 0 || $dupProductsId <= 0) {
      return;
    }

    $source = $this->get($srcProductsId);
    if ((int)$source['revision'] === 0) {
      // Quelle hatte keinen eigenen Datensatz -> nichts zu duplizieren.
      return;
    }

    $sql = "INSERT INTO `".$this->table."`
      (`products_id`, `manufacturer_guarantee_available`, `guarantee_years`, `covers_full_product`,
       `requires_additional_cost`, `qr_url`, `revision`, `created_at`, `updated_at`)
      VALUES (
        ".$dupProductsId.",
        ".(int)$source['manufacturer_guarantee_available'].",
        ".(int)$source['guarantee_years'].",
        ".(int)$source['covers_full_product'].",
        ".(int)$source['requires_additional_cost'].",
        ".$this->toSqlNullableString($source['qr_url']).",
        1,
        NOW(),
        NOW()
      )
      ON DUPLICATE KEY UPDATE
        `manufacturer_guarantee_available` = VALUES(`manufacturer_guarantee_available`),
        `guarantee_years` = VALUES(`guarantee_years`),
        `covers_full_product` = VALUES(`covers_full_product`),
        `requires_additional_cost` = VALUES(`requires_additional_cost`),
        `qr_url` = VALUES(`qr_url`),
        `revision` = `revision` + 1,
        `updated_at` = NOW()";
    $this->queryOrThrow("START TRANSACTION");
    try {
      $this->queryOrThrow($sql);
      $this->log($actorId, 'duplicate', [$dupProductsId], ['source_products_id' => $srcProductsId]);
      $this->queryOrThrow("COMMIT");
    } catch (Throwable $e) {
      xtc_db_query("ROLLBACK");
      throw $e;
    }
  }

  /**
   * Wandelt rohe Eingabedaten (aus $_POST bzw. Hook-Array) in die für die Tabelle
   * gültigen Spaltenwerte um. Zentrale Stelle für Validierung/Defaults.
   */
  private function normalize(array $products_data): array {
    $manufacturerGuaranteeAvailable = (isset($products_data['bx_eu_garan_manufacturer_guarantee_available'])
      && (int)$products_data['bx_eu_garan_manufacturer_guarantee_available'] === 1) ? 1 : 0;

    $guaranteeYears = isset($products_data['bx_eu_garan_guarantee_years'])
      ? (int)$products_data['bx_eu_garan_guarantee_years'] : 0;
    if ($guaranteeYears < 0) {
      $guaranteeYears = 0;
    }

    $coversFullProduct = (isset($products_data['bx_eu_garan_covers_full_product'])
      && (int)$products_data['bx_eu_garan_covers_full_product'] === 1) ? 1 : 0;

    $requiresAdditionalCost = (isset($products_data['bx_eu_garan_requires_additional_cost'])
      && (int)$products_data['bx_eu_garan_requires_additional_cost'] === 1) ? 1 : 0;

    $qrUrl = isset($products_data['bx_eu_garan_qr_url'])
      ? trim((string)$products_data['bx_eu_garan_qr_url']) : '';

    return [
      'manufacturer_guarantee_available' => $manufacturerGuaranteeAvailable,
      'guarantee_years'                  => $guaranteeYears,
      'covers_full_product'              => $coversFullProduct,
      'requires_additional_cost'         => $requiresAdditionalCost,
      'qr_url'                           => $qrUrl,
    ];
  }

  private function defaults(int $productsId): array {
    return [
      'products_id'                      => $productsId,
      'manufacturer_guarantee_available' => 0,
      'guarantee_years'                  => 0,
      'covers_full_product'              => 0,
      'requires_additional_cost'         => 0,
      'qr_url'                           => '',
      'revision'                         => 0,
    ];
  }

  private function toSqlNullableString(?string $value): string {
    if ($value === null || $value === '') {
      return 'NULL';
    }
    return "'".xtc_db_input((string)$value)."'";
  }

  /**
   * Schreibt einen Eintrag in das bestehende Audit-Log (bisher nur für Massenänderungen
   * genutzt, jetzt auch für Einzelspeicherung/-löschung/-duplikation).
   */
  private function log(?int $actorId, string $action, array $productsIds, array $changes): void {
    $filters = ['action' => $action, 'actor' => $actorId];
    $this->queryOrThrow("INSERT INTO `".$this->logTable."`
        (executed_at, affected_products_count, filters_json, changes_json)
      VALUES (
        NOW(),
        ".count($productsIds).",
        '".xtc_db_input(json_encode($filters, JSON_UNESCAPED_UNICODE))."',
        '".xtc_db_input(json_encode(['products' => $productsIds, 'changes' => $changes], JSON_UNESCAPED_UNICODE))."'
      )");
  }

  private function queryOrThrow(string $sql) {
    $result = xtc_db_query($sql);
    if ($result === false) {
      throw new RuntimeException('BX_EU_GARAN_DATABASE_ERROR');
    }
    return $result;
  }
}
