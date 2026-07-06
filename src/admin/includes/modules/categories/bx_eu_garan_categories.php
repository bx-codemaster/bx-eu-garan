<?php
/* -----------------------------------------------------------------------------------------
   BX EU Garan categories module hooks
   ---------------------------------------------------------------------------------------*/

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

class bx_eu_garan_categories {

  public string $code;
  public string $name;
  public string $title;
  public string $description;
  public bool $enabled;
  public int $sort_order;
  public ?bool $_check = null;

  private string $tableWarranty      = 'bx_products_warranty_guarantee';
  private string $tableRepairability = 'bx_products_repairability';

  public function __construct() {
    $this->code        = 'bx_eu_garan_categories';
    $this->name        = 'MODULE_CATEGORIES_'.strtoupper($this->code);
    $this->title       = defined($this->name.'_TITLE') ? constant($this->name.'_TITLE') : 'BX EU Garan Produkt-Hooks';
    $this->description = defined($this->name.'_DESCRIPTION') ? constant($this->name.'_DESCRIPTION') : 'Speichert EU-Garantie- und Reparierbarkeitsdaten beim Produktspeichern.';
    $this->enabled     = defined($this->name.'_STATUS') && constant($this->name.'_STATUS') == 'true';
    $this->sort_order  = defined($this->name.'_SORT_ORDER') ? constant($this->name.'_SORT_ORDER') : 999;
  }

  public function check(): bool {
    if (!isset($this->_check)) {
      if (defined($this->name.'_STATUS')) {
        $this->_check = true;
      } else {
        $check_query = xtc_db_query("SELECT configuration_value
                                       FROM ".TABLE_CONFIGURATION."
                                      WHERE configuration_key = '".$this->name."_STATUS'");
        $this->_check = xtc_db_num_rows($check_query) > 0;
      }
    }

    return $this->_check;
  }

  public function keys(): array {
    defined($this->name.'_STATUS_TITLE') or define($this->name.'_STATUS_TITLE', TEXT_DEFAULT_STATUS_TITLE);
    defined($this->name.'_STATUS_DESC') or define($this->name.'_STATUS_DESC', TEXT_DEFAULT_STATUS_DESC);
    defined($this->name.'_SORT_ORDER_TITLE') or define($this->name.'_SORT_ORDER_TITLE', TEXT_DEFAULT_SORT_ORDER_TITLE);
    defined($this->name.'_SORT_ORDER_DESC') or define($this->name.'_SORT_ORDER_DESC', TEXT_DEFAULT_SORT_ORDER_DESC);

    return array(
      $this->name.'_STATUS',
      $this->name.'_SORT_ORDER',
    );
  }

  public function install(): void {
    xtc_db_query("INSERT INTO ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added)
                  VALUES ('".$this->name."_STATUS', 'true', '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', NOW())");
    xtc_db_query("INSERT INTO ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, date_added)
                  VALUES ('".$this->name."_SORT_ORDER', '999', '6', '2', NOW())");
  }

  public function remove(): void {
    xtc_db_query("DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key LIKE '".$this->name."_%'");
  }

  public function insert_product_after(array $products_data, int $products_id): void {
    $products_id = (int)$products_id;
    if ($products_id <= 0) {
      return;
    }

    $manufacturerGuaranteeAvailable = (isset($products_data['bx_eu_garan_manufacturer_guarantee_available']) && (int)$products_data['bx_eu_garan_manufacturer_guarantee_available'] === 1) ? 1 : 0;
    $guaranteeYears         = isset($products_data['bx_eu_garan_guarantee_years']) ? (int)$products_data['bx_eu_garan_guarantee_years'] : 0;
    $coversFullProduct      = (isset($products_data['bx_eu_garan_covers_full_product']) && (int)$products_data['bx_eu_garan_covers_full_product'] === 1) ? 1 : 0;
    $requiresAdditionalCost = (isset($products_data['bx_eu_garan_requires_additional_cost']) && (int)$products_data['bx_eu_garan_requires_additional_cost'] === 1) ? 1 : 0;
    $qrUrl                  = isset($products_data['bx_eu_garan_qr_url']) ? trim((string)$products_data['bx_eu_garan_qr_url']) : '';

    if ($guaranteeYears < 0) {
      $guaranteeYears = 0;
    }

    $warrantyQuery = "INSERT INTO `".$this->tableWarranty."`
      (`products_id`, `manufacturer_guarantee_available`, `guarantee_years`, `covers_full_product`, `requires_additional_cost`, `qr_url`, `created_at`, `updated_at`)
      VALUES (
        ".$products_id.",
        ".$manufacturerGuaranteeAvailable.",
        ".$guaranteeYears.",
        ".$coversFullProduct.",
        ".$requiresAdditionalCost.",
        ".$this->toSqlNullableString($qrUrl).",
        NOW(),
        NOW()
      )
      ON DUPLICATE KEY UPDATE
        `manufacturer_guarantee_available` = VALUES(`manufacturer_guarantee_available`),
        `guarantee_years` = VALUES(`guarantee_years`),
        `covers_full_product` = VALUES(`covers_full_product`),
        `requires_additional_cost` = VALUES(`requires_additional_cost`),
        `qr_url` = VALUES(`qr_url`),
        `updated_at` = NOW()";
    xtc_db_query($warrantyQuery);

    $repairScore = isset($products_data['bx_eu_garan_repair_score']) && $products_data['bx_eu_garan_repair_score'] !== ''
      ? max(0, min(10, (int)$products_data['bx_eu_garan_repair_score']))
      : null;

    $availability_years = isset($products_data['bx_eu_garan_availability_years']) && $products_data['bx_eu_garan_availability_years'] !== ''
      ? max(0, min(30, (int)$products_data['bx_eu_garan_availability_years'])) // Von 10 auf 30 erhöht
      : null;

    $partsAvailable = null;
    if (isset($products_data['bx_eu_garan_parts_available']) && $products_data['bx_eu_garan_parts_available'] !== '') {
      $partsAvailable = (int)$products_data['bx_eu_garan_parts_available'] === 1 ? 1 : 0;
    }

    $partsCostInfo      = isset($products_data['bx_eu_garan_parts_cost_info']) ? trim((string)$products_data['bx_eu_garan_parts_cost_info']) : '';
    $manualUrl          = isset($products_data['bx_eu_garan_manual_url']) ? trim((string)$products_data['bx_eu_garan_manual_url']) : '';
    $repairRestrictions = isset($products_data['bx_eu_garan_repair_restrictions']) ? trim((string)$products_data['bx_eu_garan_repair_restrictions']) : '';
    $repairServiceUrl   = isset($products_data['bx_eu_garan_repair_service_url']) ? trim((string)$products_data['bx_eu_garan_repair_service_url']) : '';

    $repairQuery = "INSERT INTO `".$this->tableRepairability."`
      (`products_id`, `repair_score`, `parts_available`, `parts_cost_info`, `manual_url`, `repair_restrictions`, `repair_service_url`, `parts_availability_years`, `created_at`, `updated_at`)
      VALUES (
        ".$products_id.",
        ".$this->toSqlNullableInt($repairScore).",
        ".$this->toSqlNullableInt($partsAvailable).",
        ".$this->toSqlNullableString($partsCostInfo).",
        ".$this->toSqlNullableString($manualUrl).",
        ".$this->toSqlNullableString($repairRestrictions).",
        ".$this->toSqlNullableString($repairServiceUrl).",
        ".$this->toSqlNullableInt($availability_years).",
        NOW(),
        NOW()
      )
      ON DUPLICATE KEY UPDATE
        `repair_score` = VALUES(`repair_score`),
        `parts_available` = VALUES(`parts_available`),
        `parts_cost_info` = VALUES(`parts_cost_info`),
        `manual_url` = VALUES(`manual_url`),
        `repair_restrictions` = VALUES(`repair_restrictions`),
        `repair_service_url` = VALUES(`repair_service_url`),
        `parts_availability_years` = VALUES(`parts_availability_years`),
        `updated_at` = NOW()";
    xtc_db_query($repairQuery);
  }

  public function remove_product(int $products_id): void {
    $products_id = (int)$products_id;
    if ($products_id <= 0) {
      return;
    }

    xtc_db_query("DELETE FROM `".$this->tableWarranty."` WHERE `products_id` = '".$products_id."'");
    xtc_db_query("DELETE FROM `".$this->tableRepairability."` WHERE `products_id` = '".$products_id."'");
  }

  public function duplicate_product_after(array $sql_data_array, int $src_products_id, int $dest_categories_id, int $dup_products_id): void {
    $src_products_id = (int)$src_products_id;
    $dup_products_id = (int)$dup_products_id;

    if ($src_products_id > 0 && $dup_products_id > 0) {
      $warrantyQuery = xtc_db_query("SELECT * FROM `".$this->tableWarranty."` WHERE `products_id` = '".$src_products_id."' LIMIT 1");
      if ($warrantyQuery && xtc_db_num_rows($warrantyQuery) > 0) {
        $row = xtc_db_fetch_array($warrantyQuery);
        $insert = "INSERT INTO `".$this->tableWarranty."`
          (`products_id`, `manufacturer_guarantee_available`, `guarantee_years`, `covers_full_product`, `requires_additional_cost`, `qr_url`, `created_at`, `updated_at`)
          VALUES (
            ".$dup_products_id.",
            ".(int)$row['manufacturer_guarantee_available'].",
            ".(int)$row['guarantee_years'].",
            ".(int)$row['covers_full_product'].",
            ".(int)$row['requires_additional_cost'].",
            ".$this->toSqlNullableString($row['qr_url']).",
            NOW(),
            NOW()
          )";
        xtc_db_query($insert);
      }

      $repairQuery = xtc_db_query("SELECT * FROM `".$this->tableRepairability."` WHERE `products_id` = '".$src_products_id."' LIMIT 1");
      if ($repairQuery && xtc_db_num_rows($repairQuery) > 0) {
        $row = xtc_db_fetch_array($repairQuery);
        $insert = "INSERT INTO `".$this->tableRepairability."`
          (`products_id`, `repair_score`, `parts_available`, `parts_cost_info`, `manual_url`, `repair_restrictions`, `repair_service_url`, `parts_availability_years`, `created_at`, `updated_at`)
          VALUES (
            ".$dup_products_id.",
            ".$this->toSqlNullableInt(isset($row['repair_score']) ? (int)$row['repair_score'] : null).",
            ".$this->toSqlNullableInt(isset($row['parts_available']) ? (int)$row['parts_available'] : null).",
            ".$this->toSqlNullableString($row['parts_cost_info']).",
            ".$this->toSqlNullableString($row['manual_url']).",
            ".$this->toSqlNullableString($row['repair_restrictions']).",
            ".$this->toSqlNullableString($row['repair_service_url']).",
            ".$this->toSqlNullableInt(isset($row['parts_availability_years']) ? (int)$row['parts_availability_years'] : null).",
            NOW(),
            NOW()
          )";
        xtc_db_query($insert);
      }
    }
  }

  private function toSqlNullableString(?string $value): string {
    if ($value === null || $value === '') {
      return 'NULL';
    }

    return "'".xtc_db_input((string)$value)."'";
  }

  private function toSqlNullableInt(?int $value): string {
    if ($value === null) {
      return 'NULL';
    }

    return (string)$value;
  }

}
