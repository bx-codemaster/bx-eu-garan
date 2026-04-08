<?php

  function bx_eu_garan_to_nullable_string($value) {
    $value = trim((string)$value);
    if ($value === '') {
      return 'NULL';
    }

    return "'".xtc_db_input($value)."'";
  }

  function bx_eu_garan_get_manufacturer_name($manufacturerId) {
    $manufacturerId = (int)$manufacturerId;
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

  function bx_eu_garan_get_model_identifier_from_product_data($productData) {
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

  function bx_eu_garan_get_product_reference_data($productId, $postedData = array()) {
    $productId = (int)$productId;
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

  function bx_eu_garan_is_harmonized_guarantee_label_required($manufacturerGuaranteeAvailable, $guaranteeYears, $requiresAdditionalCost) {
    return (
      (int)$manufacturerGuaranteeAvailable === 1
      && (int)$guaranteeYears > 2
      && (int)$requiresAdditionalCost === 0
    );
  }

  function bx_eu_garan_get_subcategory_ids($categoryId) {
    $result = array();
    $queue  = array((int)$categoryId);

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

  function bx_eu_garan_get_product_ids($categoryId, $includeSubCategories, $manufacturerId, $productStatus) {
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
  