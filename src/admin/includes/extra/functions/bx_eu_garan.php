<?php
  if (!function_exists('bx_eu_garan_to_nullable_string')) {
    function bx_eu_garan_to_nullable_string(string $value): string {
      $value = trim($value);
      if ($value === '') {
        return 'NULL';
      }

      return "'".xtc_db_input($value)."'";
    }
  }

  if (!function_exists('bx_eu_garan_get_manufacturer_name')) {
    function bx_eu_garan_get_manufacturer_name(int $manufacturerId) {
      if ($manufacturerId <= 0) {
        return '';
      }

      $query = xtc_db_query("SELECT manufacturers_name
                              FROM manufacturers
                            WHERE manufacturers_id = '".$manufacturerId."'
                            LIMIT 1");
      if ($query === false || xtc_db_num_rows($query) < 1) {
        return '';
      }

      $row = xtc_db_fetch_array($query);
      return isset($row['manufacturers_name']) ? trim((string)$row['manufacturers_name']) : '';
    }
  }

  if (!function_exists('bx_eu_garan_get_model_identifier_from_product_data')) {
    function bx_eu_garan_get_model_identifier_from_product_data(array $productData): array {
      $fields = array(
        'products_manufacturers_model',
        'products_ean',
        'products_model',
      );

      foreach ($fields as $fieldName) {
        if (!isset($productData[$fieldName])) {
          continue;
        }

        $value = trim((string)$productData[$fieldName]);
        if ($value !== '') {
          return array(
            'value' => $value,
            'source' => $fieldName,
          );
        }
      }

      return array(
        'value' => '',
        'source' => '',
      );
    }
  }

  if (!function_exists('bx_eu_garan_get_product_reference_data')) {
    function bx_eu_garan_get_product_reference_data(int $productId, array $postedData = array()): array {
      $productData = array(
        'manufacturers_id' => 0,
        'manufacturers_name' => '',
        'products_manufacturers_model' => '',
        'products_ean' => '',
        'products_model' => '',
      );

      if ($productId > 0) {
        $query = xtc_db_query("SELECT p.manufacturers_id,
                                      p.products_manufacturers_model,
                                      p.products_ean,
                                      p.products_model,
                                      m.manufacturers_name
                                FROM products p
                                LEFT JOIN manufacturers m ON m.manufacturers_id = p.manufacturers_id
                                WHERE p.products_id = '".$productId."'
                                LIMIT 1");
        if ($query !== false && xtc_db_num_rows($query) > 0) {
          $row = xtc_db_fetch_array($query);
          $productData['manufacturers_id'] = isset($row['manufacturers_id']) ? (int)$row['manufacturers_id'] : 0;
          $productData['manufacturers_name'] = isset($row['manufacturers_name']) ? trim((string)$row['manufacturers_name']) : '';
          $productData['products_manufacturers_model'] = isset($row['products_manufacturers_model']) ? (string)$row['products_manufacturers_model'] : '';
          $productData['products_ean'] = isset($row['products_ean']) ? (string)$row['products_ean'] : '';
          $productData['products_model'] = isset($row['products_model']) ? (string)$row['products_model'] : '';
        }
      }

      if (is_array($postedData) && !empty($postedData)) {
        if (isset($postedData['manufacturers_id'])) {
          $productData['manufacturers_id'] = (int)$postedData['manufacturers_id'];
        }
        if (isset($postedData['products_manufacturers_model'])) {
          $productData['products_manufacturers_model'] = (string)$postedData['products_manufacturers_model'];
        }
        if (isset($postedData['products_ean'])) {
          $productData['products_ean'] = (string)$postedData['products_ean'];
        }
        if (isset($postedData['products_model'])) {
          $productData['products_model'] = (string)$postedData['products_model'];
        }

        $productData['manufacturers_name'] = bx_eu_garan_get_manufacturer_name($productData['manufacturers_id']);
      }

      $modelIdentifier = bx_eu_garan_get_model_identifier_from_product_data($productData);

      return array(
        'manufacturers_id' => (int)$productData['manufacturers_id'],
        'manufacturer_name' => (string)$productData['manufacturers_name'],
        'model_identifier' => $modelIdentifier['value'],
        'model_identifier_source' => $modelIdentifier['source'],
      );
    }
  }

  if (!function_exists('bx_eu_garan_is_harmonized_guarantee_label_required')) {
    function bx_eu_garan_is_harmonized_guarantee_label_required(int $manufacturerGuaranteeAvailable, int $guaranteeYears, int $requiresAdditionalCost): bool {
      return (
        $manufacturerGuaranteeAvailable === 1
        && $guaranteeYears > 2
        && $requiresAdditionalCost === 0
      );
    }
  }

  if (!function_exists('bx_eu_garan_get_subcategory_ids')) {
    function bx_eu_garan_get_subcategory_ids(int $categoryId): array {
      $result = array();
      $queue  = array($categoryId);

    while (!empty($queue)) {
      $currentId = (int)array_shift($queue);
      if ($currentId <= 0 || isset($result[$currentId])) {
        continue;
      }

      $result[$currentId] = $currentId;
      $childrenQuery = xtc_db_query("SELECT categories_id FROM categories WHERE parent_id = '".$currentId."'");
      while ($childrenRow = xtc_db_fetch_array($childrenQuery)) {
        $queue[] = (int)$childrenRow['categories_id'];
      }
    }

    return array_values($result);
    }
  }

  if (!function_exists('bx_eu_garan_get_product_ids')) {
    function bx_eu_garan_get_product_ids(int $categoryId, bool $includeSubCategories, string $manufacturerId, string $productStatus): array {
      $where = array();

      if ($manufacturerId !== '') {
        if ((int)$manufacturerId === 0) {
          $where[] = "p.manufacturers_id = '0'";
        } else {
          $where[] = "p.manufacturers_id = '".(int)$manufacturerId."'";
        }
      }

      if ($categoryId > 0) {
        if ($includeSubCategories) {
          $categoryIds = bx_eu_garan_get_subcategory_ids($categoryId);
        } else {
          $categoryIds = array((int)$categoryId);
        }

        if (!empty($categoryIds)) {
          $where[] = 'p2c.categories_id IN ('.implode(',', array_map('intval', $categoryIds)).')';
        }
      }

      $sql = "SELECT DISTINCT p.products_id
            FROM products p
            LEFT JOIN products_to_categories p2c ON p2c.products_id = p.products_id";

      if (!empty($where)) {
        $sql .= ' WHERE '.implode(' AND ', $where);
      }

      if ($productStatus !== '') {
        $sql .= (!empty($where) ? ' AND ' : ' WHERE ')."p.products_status = '".(int)$productStatus."'";
      }

      $sql .= ' ORDER BY p.products_id';

      $ids   = array();
      $query = xtc_db_query($sql);
      while ($row = xtc_db_fetch_array($query)) {
        $ids[] = (int)$row['products_id'];
      }

      return $ids;
    }
  }
  
  if (!function_exists('bx_eu_garan_get_configuration_value')) {
    function bx_eu_garan_get_configuration_value(string $key, string $default = ''): string {
      $query = xtc_db_query("SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".xtc_db_input($key)."' LIMIT 1");
      if ($query && xtc_db_num_rows($query) > 0) {
        $row = xtc_db_fetch_array($query);
        return isset($row['configuration_value']) ? (string)$row['configuration_value'] : (string)$default;
      }

      return (string)$default;
    }
  }

  if (!function_exists('bx_eu_garan_set_configuration_value')) {
    function bx_eu_garan_set_configuration_value(string $key, string $value): void {
      $keyEscaped   = xtc_db_input($key);
      $valueEscaped = xtc_db_input($value);
      $existsQuery  = xtc_db_query("SELECT configuration_id FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$keyEscaped."' LIMIT 1");

      if ($existsQuery && xtc_db_num_rows($existsQuery) > 0) {
        xtc_db_query("UPDATE ".TABLE_CONFIGURATION." SET configuration_value = '".$valueEscaped."', last_modified = NOW() WHERE configuration_key = '".$keyEscaped."'");
        return;
      }

      $groupId = defined('MODULE_BX_EU_GARAN_CONFIG_ID') ? (int)constant('MODULE_BX_EU_GARAN_CONFIG_ID') : 6;
      xtc_db_query("INSERT INTO ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, date_added, set_function, use_function)
                    VALUES ('".$keyEscaped."', '".$valueEscaped."', '".$groupId."', '50', NOW(), '', '')");
    }
  }

  /**
   * Konfigurationseingabefeld für die Modulversion (read-only)
   */
  if (!function_exists('bx_configuration_field_version')) {
    function bx_configuration_field_version(string $value, string $constant): string {
      return xtc_draw_input_field( 'configuration['.$constant.']', $value, 'readonly="true" style="opacity: 0.4;"');
    }
  }
