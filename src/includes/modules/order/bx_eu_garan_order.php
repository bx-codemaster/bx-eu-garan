<?php
/**
 * BX EU Garan - Order Module
 *
 * This module enriches checkout/order product rows with graphics-only EU
 * warranty/guarantee artifacts used by order and checkout templates:
 * - legal guarantee button image (linked to legal content)
 * - GARAN small label image/SVG (linked to guarantee details)
 *
 * Integration points:
 * - modified order module loader (`cart_products` hook)
 * - module configuration lifecycle (`keys`, `install`, `remove`)
 *
 * Data source:
 * - `bx_products_warranty_guarantee` per-product metadata
 */

class bx_eu_garan_order
{
  /** @var string Unique module code used by modified. */
  public $code;

  /** @var string Configuration key prefix (e.g. MODULE_ORDER_BX_...). */
  public $name;

  /** @var string Language constant value used in admin module list. */
  public $title;

  /** @var string Language constant value used in admin module list. */
  public $description;

  /** @var string Whether module output is currently enabled. */
  public $enabled;

  /** @var int|string Sort order configured in module settings. */
  public $sort_order;

  /** @var bool|int|null Cache for check() result. */
  public $_check;

  /** @var array<int, array<string, string>> Product context cache by product id. */
  public $context_cache;

  /** @var string Configuration table name from modified core. */
  public $configuration_table;

  /**
  * Initializes module identifiers and runtime defaults.
  */
  public function __construct()
  {
    $this->code                = 'bx_eu_garan_order';
    $this->name                = 'MODULE_ORDER_'.strtoupper($this->code);
    $this->title               = defined($this->name.'_TITLE') ? constant($this->name.'_TITLE') : 'BX EU Garan';
    $this->description         = defined($this->name.'_DESCRIPTION') ? constant($this->name.'_DESCRIPTION') : 'BX EU Garan - Order Module';
    $this->enabled             = defined($this->name . '_STATUS') && constant($this->name . '_STATUS') == 'true' ? 'true' : 'false';
    $this->sort_order          = defined($this->name . '_SORT_ORDER') ? constant($this->name . '_SORT_ORDER') : '10';
    $this->context_cache       = [];
    $this->configuration_table = TABLE_CONFIGURATION;
  }

  /**
   * Checks whether module configuration already exists in database.
   *
   * @return bool|int `true` if constant exists, otherwise row count result.
   */
  public function check()
  {
    if (!isset($this->_check)) {
      if (defined($this->name.'_STATUS')) {
        $this->_check = true;
      } else {
        $check_query = xtc_db_query("SELECT configuration_value FROM " . $this->configuration_table . " WHERE configuration_key = '".$this->name."_STATUS'");
        $this->_check = xtc_db_num_rows($check_query);
      }
    }

    return $this->_check;
  }

  /**
   * Returns configuration keys managed by this module.
   *
   * @return array<int, string>
   */
  public function keys()
  {

    defined($this->name.'_STATUS_TITLE') OR define($this->name.'_STATUS_TITLE', TEXT_DEFAULT_STATUS_TITLE);
    defined($this->name.'_STATUS_DESC') OR define($this->name.'_STATUS_DESC', TEXT_DEFAULT_STATUS_DESC);
    defined($this->name.'_SORT_ORDER_TITLE') OR define($this->name.'_SORT_ORDER_TITLE', TEXT_DEFAULT_SORT_ORDER_TITLE);
    defined($this->name.'_SORT_ORDER_DESC') OR define($this->name.'_SORT_ORDER_DESC', TEXT_DEFAULT_SORT_ORDER_DESC);
        
    return [
      $this->name.'_STATUS',
      $this->name.'_SORT_ORDER',
    ];
  }

  /**
   * Installs module configuration entries.
   *
   * @return void
   */
  public function install()
  {
    xtc_db_query("INSERT INTO " . $this->configuration_table . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('".$this->name."_STATUS', 'true', '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
    xtc_db_query("INSERT INTO " . $this->configuration_table . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('".$this->name."_SORT_ORDER', '10', '6', '2', now())");
  }

  /**
   * Removes module configuration entries.
   *
   * @return void
   */
  public function remove()
  {
    xtc_db_query("DELETE FROM " . $this->configuration_table . " WHERE configuration_key LIKE '".$this->name."_%'");
  }

  /**
   * Hook: enriches checkout product data with EU GARAN graphics.
   *
   * @param array<string, mixed> $products_data Existing checkout product payload.
   * @param mixed $products_id Product id or modified product identifier.
   *
   * @return array<string, mixed> Enriched checkout product payload.
   */
  public function cart_products($products_data, $products_id)
  {
    $plain_products_id = (int)xtc_get_prid($products_id);
    if ($plain_products_id < 1) {
      return $products_data;
    }

    $context = $this->get_context_by_product_id($plain_products_id);
    if ($context['legal_label_btn'] !== '') {
      $products_data['eu_garan_legal_label_btn'] = $context['legal_label_btn'];
    } else {
      unset($products_data['eu_garan_legal_label_btn']);
    }
    if ($context['label_small'] !== '') {
      $products_data['eu_garan_label_small'] = $context['label_small'];
    } else {
      unset($products_data['eu_garan_label_small']);
    }

    return $products_data;
  }

  /**
   * Builds cached visual context for one product.
   *
   * Context keys:
   * - `legal_label_btn`: linked legal button image HTML
   * - `label_small`: linked small GARAN label HTML
   *
   * @param int $products_id Product identifier.
   *
   * @return array<string, string>
   */
  public function get_context_by_product_id($products_id)
  {
    if (isset($this->context_cache[$products_id])) {
      return $this->context_cache[$products_id];
    }

    $context = [
      'legal_label_btn' => '',
      'label_small'     => '',
    ];

    if (strtolower((string)MODULE_BX_EU_GARAN_STATUS) !== 'true') {
      $this->context_cache[$products_id] = $context;
      return $context;
    }

    $language_code = 'de';
    if (isset($_SESSION['language_code']) && $_SESSION['language_code'] !== '') {
      $language_code = strtolower($_SESSION['language_code']);
    }

    $default_legal_qr_url         = 'https://europa.eu/youreurope/legal-guarantee/index.htm?lang='.$language_code;
    $legal_warranty_content_group = (int)MODULE_BX_EU_GARAN_WARRANTY_CONTENT_GROUP;
    $legal_qr_url_raw = $legal_warranty_content_group > 0
      ? xtc_href_link(FILENAME_CONTENT, 'coID='.(int)$legal_warranty_content_group)
      : $default_legal_qr_url;
    $legal_qr_url = htmlspecialchars($legal_qr_url_raw, ENT_QUOTES, 'UTF-8');

    $warranty = [
      'manufacturer_guarantee_available' => 0,
      'guarantee_years'                  => 0,
      'covers_full_product'              => 1,
      'requires_additional_cost'         => 0,
      'qr_url'                           => '',
    ];

    $query = xtc_db_query("SELECT manufacturer_guarantee_available, 
                                        guarantee_years,
                                        covers_full_product, 
                                        requires_additional_cost, 
                                        qr_url
                                  FROM bx_products_warranty_guarantee
                                 WHERE products_id = '".(int)$products_id."'
                                 LIMIT 1");
    if ($query && xtc_db_num_rows($query) > 0) {
      $data = xtc_db_fetch_array($query);
      $warranty['manufacturer_guarantee_available'] = isset($data['manufacturer_guarantee_available']) ? (int)$data['manufacturer_guarantee_available'] : 0;
      $warranty['guarantee_years']                  = isset($data['guarantee_years']) ? (int)$data['guarantee_years'] : 0;
      $warranty['covers_full_product']              = isset($data['covers_full_product']) ? (int)$data['covers_full_product'] : 1;
      $warranty['requires_additional_cost']         = isset($data['requires_additional_cost']) ? (int)$data['requires_additional_cost'] : 0;
      $warranty['qr_url']                           = isset($data['qr_url']) ? trim((string)$data['qr_url']) : '';
    }

    $show_warranty_label = (
      $warranty['manufacturer_guarantee_available'] === 1
      && $warranty['guarantee_years'] > 2
      && $warranty['covers_full_product'] === 1
      && $warranty['requires_additional_cost'] === 0
    );

    $label_qr_url_raw = $warranty['qr_url'] !== ''
      ? $warranty['qr_url']
      : 'https://europa.eu/youreurope/citizens/consumers/shopping/commercial-guarantee-durability/index_'.$language_code.'.htm';
    $label_qr_url = htmlspecialchars($label_qr_url_raw, ENT_QUOTES, 'UTF-8');

    $legal_link_new_window = '';
    if (defined('MODULE_BX_EU_GARAN_NEW_WINDOW') && constant('MODULE_BX_EU_GARAN_NEW_WINDOW') === 'True') {
      $legal_link_new_window = ' target="_blank" rel="noopener noreferrer"';
    }

    $legal_label_path = DIR_WS_IMAGES.'warranty_guarantee/';
    $context['legal_label_btn'] = '<a href="'.$label_qr_url.'"'.$legal_link_new_window.'>'
                                 .'<img class="bx_eu_garan_legal_label_btn" src="'.$legal_label_path.'legal_guarantee_btn_'.$language_code.'.png" alt="legal_guarantee_btn_'.$language_code.'">'
                                 .'</a>';

    if ($show_warranty_label) {
      $years          = sprintf('%02d', (int)$warranty['guarantee_years']);
      $label_small    = '';
      $small_svg_path = DIR_FS_DOCUMENT_ROOT.DIR_WS_IMAGES.'warranty_guarantee/garan.svg';
      $small_template = is_file($small_svg_path) ? file_get_contents($small_svg_path) : false;

      if ($small_template !== false && class_exists('DOMDocument')) {
        $small_dom = new DOMDocument();
        $previous_use_internal_errors = libxml_use_internal_errors(true);
        if ($small_dom->loadXML($small_template)) {
          $small_xpath = new DOMXPath($small_dom);

          $years_nodes = $small_xpath->query('//*[@id="text_years"]');
          if ($years_nodes instanceof DOMNodeList && $years_nodes->length > 0) {
            $years_nodes->item(0)->nodeValue = $years;
          }
          $small_svg_node = $small_dom->documentElement;
          if ($small_svg_node instanceof DOMElement && strtolower($small_svg_node->tagName) === 'svg') {
            $svg_markup = $small_dom->saveXML($small_svg_node);
            if ($svg_markup !== false && $svg_markup !== '') {
              $label_small = '<div class="bx-eu-garan-label-small">'.$svg_markup.'<div class="bx-eu-garan-label-big"></div></div>';
            }
          }
        }
        libxml_clear_errors();
        libxml_use_internal_errors($previous_use_internal_errors);
      }

      if ($label_small === '') {
        $label_small = '<div class="bx-eu-garan-label-small">'
                      .'<img src="'.$legal_label_path.'garan.svg" alt="SVG-Image">'
                      .'<div class="bx-eu-garan-label-big"></div>'
                      .'</div>';
      }

      $label_big = '';
      $qr_code_data_uri = '';
      if (file_exists(DIR_FS_CATALOG.'includes/classes/bx_dependency_resolver.php')) {
        require_once DIR_FS_CATALOG.'includes/classes/bx_dependency_resolver.php';
        try {
          $dependency_result = bx_dependency_resolver::requireMultiple(array('modified_qrcode'));
          if (isset($dependency_result['modified_qrcode']['status']) && $dependency_result['modified_qrcode']['status'] === 'loaded') {
            if (class_exists('\\Endroid\\QrCode\\QrCode') && class_exists('\\Endroid\\QrCode\\Writer\\PngWriter')) {
              $qr_code = new \Endroid\QrCode\QrCode(
                data: $label_qr_url,
                size: 1024,
                margin: 0
              );
              $writer = new \Endroid\QrCode\Writer\PngWriter();
              $result = $writer->write($qr_code);
              $qr_code_data_uri = 'data:image/png;base64,'.base64_encode($result->getString());
            }
          }
        } catch (Exception $e) {
          $qr_code_data_uri = '';
        }
      }
      $manufacturerName = '';
      $modelIdentifier = '';

      $product_query = xtc_db_query("SELECT p.products_manufacturers_model,
                                            p.products_ean,
                                            p.products_model,
                                            m.manufacturers_name
                                       FROM ".TABLE_PRODUCTS." p
                                  LEFT JOIN ".TABLE_MANUFACTURERS." m
                                         ON m.manufacturers_id = p.manufacturers_id
                                      WHERE p.products_id = '".(int)$products_id."'
                                      LIMIT 1");
      if ($product_query && xtc_db_num_rows($product_query) > 0) {
        $product_data = xtc_db_fetch_array($product_query);

        if (!empty($product_data['manufacturers_name'])) {
          $manufacturerName = trim((string)$product_data['manufacturers_name']);
        }

        if (!empty($product_data['products_manufacturers_model'])) {
          $modelIdentifier = (string)$product_data['products_manufacturers_model'];
        } elseif (!empty($product_data['products_ean'])) {
          $modelIdentifier = (string)$product_data['products_ean'];
        } elseif (!empty($product_data['products_model'])) {
          $modelIdentifier = (string)$product_data['products_model'];
        }
      }

      $big_svg_path = DIR_FS_DOCUMENT_ROOT.DIR_WS_IMAGES.'warranty_guarantee/garan_big.svg';
      $big_template = is_file($big_svg_path) ? file_get_contents($big_svg_path) : false;
      if ($big_template !== false && class_exists('DOMDocument')) {
        $big_dom = new DOMDocument();
        $previous_use_internal_errors = libxml_use_internal_errors(true);
        if ($big_dom->loadXML($big_template)) {
          $big_xpath = new DOMXPath($big_dom);

          $brandNodes = $big_xpath->query('//*[@id="text_brand"]');
          if ($brandNodes instanceof DOMNodeList && $brandNodes->length > 0) {
            $brandNodes->item(0)->nodeValue = $manufacturerName !== '' ? $manufacturerName : 'Brand/Trademark';
          }

          $modelNodes = $big_xpath->query('//*[@id="text_model"]');
          if ($modelNodes instanceof DOMNodeList && $modelNodes->length > 0) {
            $modelNode = $modelNodes->item(0);
            $modelNode->nodeValue = $modelIdentifier !== '' ? $modelIdentifier : 'Model/Identifier';
            if ($modelNode instanceof DOMElement) {
              $modelNode->setAttribute('text-anchor', 'end');
            }
          }

          $years_nodes = $big_xpath->query('//*[@id="text_years"]');
          if ($years_nodes instanceof DOMNodeList && $years_nodes->length > 0) {
            $years_nodes->item(0)->nodeValue = $years;
          }

          if ($qr_code_data_uri !== '') {
            $rect_nodes = $big_xpath->query('//*[@id="rect_code"]');
            if ($rect_nodes instanceof DOMNodeList && $rect_nodes->length > 0) {
              $rect_node = $rect_nodes->item(0);
              if ($rect_node instanceof DOMElement) {
                $svg_node = $big_dom->documentElement;
                if ($svg_node instanceof DOMElement && !$svg_node->hasAttribute('xmlns:xlink')) {
                  $svg_node->setAttribute('xmlns:xlink', 'http://www.w3.org/1999/xlink');
                }

                $image_node = $big_dom->createElementNS('http://www.w3.org/2000/svg', 'image');
                $image_node->setAttribute('id', 'rect_code');
                $image_node->setAttribute('x', $rect_node->getAttribute('x'));
                $image_node->setAttribute('y', $rect_node->getAttribute('y'));
                $image_node->setAttribute('width', $rect_node->getAttribute('width'));
                $image_node->setAttribute('height', $rect_node->getAttribute('height'));
                $image_node->setAttribute('preserveAspectRatio', 'none');
                $image_node->setAttribute('href', $qr_code_data_uri);
                $image_node->setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', $qr_code_data_uri);

                if ($rect_node->parentNode !== null) {
                  $rect_node->parentNode->insertBefore($image_node, $rect_node);
                  $rect_node->parentNode->removeChild($rect_node);
                }
              }
            }
          }

          $big_svg_node = $big_dom->documentElement;
          if ($big_svg_node instanceof DOMElement && strtolower($big_svg_node->tagName) === 'svg') {
            $label_big_svg = $big_dom->saveXML($big_svg_node);
            if ($label_big_svg !== false && $label_big_svg !== '') {
              $label_big = $label_big_svg;
            }
          }
        }
        libxml_clear_errors();
        libxml_use_internal_errors($previous_use_internal_errors);
      }

      if ($label_big !== '') {
        $label_small = str_replace('<div class="bx-eu-garan-label-big"></div>', '<div class="bx-eu-garan-label-big">'.$label_big.'</div>', $label_small);
      }

      $context['label_small'] = $label_small;
    }

    $this->context_cache[$products_id] = $context;

    return $context;
  }
}
