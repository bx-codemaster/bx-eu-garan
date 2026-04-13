<?php
/* -----------------------------------------------------------------------------------------
   BX EU Garan - PDP hook via product_info_end auto-include
   ---------------------------------------------------------------------------------------*/

if (!isset($info_smarty) || !is_object($info_smarty) || !isset($product) || !is_object($product)) {
  return;
}
if (defined('MODULE_BX_EU_GARAN_STATUS') && constant('MODULE_BX_EU_GARAN_STATUS') !== 'True') {
  return;
}

$productId = isset($product->data['products_id']) ? (int)$product->data['products_id'] : 0;
if ($productId <= 0) {
  return;
}

$warranty = array(
  'manufacturer_guarantee_available' => 0,
  'guarantee_years'                  => 0,
  'covers_full_product'              => 1,
  'requires_additional_cost'         => 0,
  'qr_url'                           => '',
);

$warrantyQuery = xtc_db_query("SELECT * FROM bx_products_warranty_guarantee WHERE products_id = '".$productId."' LIMIT 1");

if ($warrantyQuery && xtc_db_num_rows($warrantyQuery) > 0) {
  $row = xtc_db_fetch_array($warrantyQuery);
  $warranty['manufacturer_guarantee_available'] = isset($row['manufacturer_guarantee_available']) ? (int)$row['manufacturer_guarantee_available'] : 0;
  $warranty['guarantee_years']                  = isset($row['guarantee_years']) ? (int)$row['guarantee_years'] : 0;
  $warranty['covers_full_product']              = isset($row['covers_full_product']) ? (int)$row['covers_full_product'] : 1;
  $warranty['requires_additional_cost']         = isset($row['requires_additional_cost']) ? (int)$row['requires_additional_cost'] : 0;
  $warranty['qr_url']                           = isset($row['qr_url']) ? trim((string)$row['qr_url']) : '';
}

$showWarrantyLabel = (
  $warranty['manufacturer_guarantee_available'] === 1
  && $warranty['guarantee_years'] > 2
  && $warranty['covers_full_product'] === 1
  && $warranty['requires_additional_cost'] === 0
);

$manufacturerName = '';
if (isset($product->data['manufacturers_name']) && $product->data['manufacturers_name'] !== '') {
  $manufacturerName = (string)$product->data['manufacturers_name'];
} elseif (isset($product->data['manufacturers_id']) && (int)$product->data['manufacturers_id'] > 0) {

  $manufacturerQuery = xtc_db_query(
    "SELECT manufacturers_name FROM ".TABLE_MANUFACTURERS." WHERE manufacturers_id = '".(int)$product->data['manufacturers_id']."' LIMIT 1"
  );
  if ($manufacturerQuery && xtc_db_num_rows($manufacturerQuery) > 0) {
    $manufacturerData = xtc_db_fetch_array($manufacturerQuery);
    $manufacturerName = isset($manufacturerData['manufacturers_name']) ? (string)$manufacturerData['manufacturers_name'] : '';
  }
}

$modelIdentifier = '';
if (!empty($product->data['products_manufacturers_model'])) {
  $modelIdentifier = (string)$product->data['products_manufacturers_model'];
} elseif (!empty($product->data['products_ean'])) {
  $modelIdentifier = (string)$product->data['products_ean'];
} elseif (!empty($product->data['products_model'])) {
  $modelIdentifier = (string)$product->data['products_model'];
}

$defaultLegalQrUrl = 'https://europa.eu/youreurope/citizens/consumers/shopping/guarantees/index_'.$_SESSION["language_code"].'.htm';

$legalWarrantyContentGroup = defined('MODULE_BX_EU_GARAN_WARRANTY_CONTENT_GROUP')
  ? (int)constant('MODULE_BX_EU_GARAN_WARRANTY_CONTENT_GROUP')
  : 0;

$legalQrUrlRaw = $legalWarrantyContentGroup > 0
  ? xtc_href_link(FILENAME_CONTENT, 'coID='.(int)$legalWarrantyContentGroup)
  : $defaultLegalQrUrl;

$legalQrUrl    = htmlspecialchars($legalQrUrlRaw, ENT_QUOTES, 'UTF-8');

$legal_label_path = DIR_WS_IMAGES . 'warranty_guarantee/';

$legal_label_btn = '<a href="'.$legalQrUrl.'">'.PHP_EOL
                  .'  <img class="bx_eu_garan_legal_label_btn" src="'.$legal_label_path.'legal_guarantee_btn_'.$_SESSION["language_code"].'.png" alt="" width="180" />'.PHP_EOL
                  .'</a>';

$info_smarty->assign('BX_EU_GARAN_LEGAL_LABEL_BTN', $legal_label_btn);
$info_smarty->assign('BX_EU_GARAN_LEGAL_LABEL', $legal_label_path.'legal_guarantee_'.$_SESSION["language_code"].'.png');


$info_smarty->assign('BX_EU_GARAN_SHOW_WARRANTY_LABEL', $showWarrantyLabel ? '1' : '0');
$info_smarty->assign('BX_EU_GARAN_WARRANTY_YEARS', (int)$warranty['guarantee_years']);
$info_smarty->assign('BX_EU_GARAN_WARRANTY_MANUFACTURER', $manufacturerName);
$info_smarty->assign('BX_EU_GARAN_WARRANTY_MODEL', $modelIdentifier);

if ($showWarrantyLabel) {
  $years = sprintf('%02d', (int)$warranty['guarantee_years']);

  $smallSvgPath  = DIR_FS_DOCUMENT_ROOT . DIR_WS_IMAGES . 'warranty_guarantee/garan.svg';
  $smallTemplate = file_get_contents($smallSvgPath);

  if ($smallTemplate !== false && class_exists('DOMDocument')) {
    $smallDom = new DOMDocument();
    $previousUseInternalErrors = libxml_use_internal_errors(true);
    if ($smallDom->loadXML($smallTemplate)) {
      $smallXpath = new DOMXPath($smallDom);

      $yearsNodes = $smallXpath->query('//*[@id="text_years"]');
      if ($yearsNodes instanceof DOMNodeList && $yearsNodes->length > 0) {
        $yearsNodes->item(0)->nodeValue = $years !== '' ? $years : 'XX';
      }
      
      $smallSvgNode = $smallDom->documentElement;
      if ($smallSvgNode instanceof DOMElement && strtolower($smallSvgNode->tagName) === 'svg') {
        $labelSmallSvg = $smallDom->saveXML($smallSvgNode);
        if ($labelSmallSvg !== false && $labelSmallSvg !== '') {
          $labelSmall = '<div id="bx-eu-garan-label-small">'.$labelSmallSvg.'<div id="bx-eu-garan-label-big"></div></div>';
          $info_smarty->assign('BX_EU_GARAN_LABEL_SMALL', $labelSmall);
        }
      }
    }
  }

  $labelQrUrlRaw = $warranty['qr_url'] !== '' ? $warranty['qr_url'] : 'https://europa.eu/youreurope/citizens/consumers/shopping/commercial-guarantee-durability/index_'.$_SESSION["language_code"].'.htm';
  $labelQrUrl    = htmlspecialchars($labelQrUrlRaw, ENT_QUOTES, 'UTF-8');
  
  $qrCodeDataUri = '';
  if (file_exists(DIR_FS_CATALOG . 'includes/classes/bx_dependency_resolver.php')) {
    require_once DIR_FS_CATALOG . 'includes/classes/bx_dependency_resolver.php';
    try {
      $dependencyResult = bx_dependency_resolver::requireMultiple(array('modified_qrcode'));
      if (isset($dependencyResult['modified_qrcode']['status']) && $dependencyResult['modified_qrcode']['status'] === 'loaded') {
        if (class_exists('\\Endroid\\QrCode\\QrCode') && class_exists('\\Endroid\\QrCode\\Writer\\PngWriter')) {
          $qrCode = new \Endroid\QrCode\QrCode(
            data: $labelQrUrl,
            size: 1024,
            margin: 0
          );
          $writer = new \Endroid\QrCode\Writer\PngWriter();
          $result = $writer->write($qrCode);
          $qrCodeDataUri = 'data:image/png;base64,'.base64_encode($result->getString());
        }
      }
    } catch (Exception $e) {
      $qrCodeDataUri = '';
    }
  }

  $bigSvgPath  = DIR_FS_DOCUMENT_ROOT . DIR_WS_IMAGES . 'warranty_guarantee/garan_big.svg';
  $bigTemplate = file_get_contents($bigSvgPath);
  if ($bigTemplate !== false && class_exists('DOMDocument')) {
    $bigDom = new DOMDocument();
    $previousUseInternalErrors = libxml_use_internal_errors(true);
    if ($bigDom->loadXML($bigTemplate)) {
      $bigXpath = new DOMXPath($bigDom);

      $brandNodes = $bigXpath->query('//*[@id="text_brand"]');
      if ($brandNodes instanceof DOMNodeList && $brandNodes->length > 0) {
        $brandNodes->item(0)->nodeValue = $manufacturerName !== '' ? $manufacturerName : 'Brand/Trademark';
      }

      $modelNodes = $bigXpath->query('//*[@id="text_model"]');
      if ($modelNodes instanceof DOMNodeList && $modelNodes->length > 0) {
        $modelNode = $modelNodes->item(0);
        $modelNode->nodeValue = $modelIdentifier !== '' ? $modelIdentifier : 'Model/Identifier';
        if ($modelNode instanceof DOMElement) {
          $modelNode->setAttribute('text-anchor', 'end');
        }
      }

      $yearsNodes = $bigXpath->query('//*[@id="text_years"]');
      if ($yearsNodes instanceof DOMNodeList && $yearsNodes->length > 0) {
        $yearsNodes->item(0)->nodeValue = $years !== '' ? $years : 'XX';
      }

      if ($qrCodeDataUri !== '') {
        $rectNodes = $bigXpath->query('//*[@id="rect_code"]');
        if ($rectNodes instanceof DOMNodeList && $rectNodes->length > 0) {
          $rectNode = $rectNodes->item(0);
          if ($rectNode instanceof DOMElement) {
            $svgNode = $bigDom->documentElement;
            if ($svgNode instanceof DOMElement && !$svgNode->hasAttribute('xmlns:xlink')) {
              $svgNode->setAttribute('xmlns:xlink', 'http://www.w3.org/1999/xlink');
            }

            $x = $rectNode->getAttribute('x');
            $y = $rectNode->getAttribute('y');
            $width = $rectNode->getAttribute('width');
            $height = $rectNode->getAttribute('height');

            $imageNode = $bigDom->createElementNS('http://www.w3.org/2000/svg', 'image');
            $imageNode->setAttribute('id', 'rect_code');
            $imageNode->setAttribute('x', $x);
            $imageNode->setAttribute('y', $y);
            $imageNode->setAttribute('width', $width);
            $imageNode->setAttribute('height', $height);
            $imageNode->setAttribute('preserveAspectRatio', 'none');
            $imageNode->setAttribute('href', $qrCodeDataUri);
            $imageNode->setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', $qrCodeDataUri);

            if ($rectNode->parentNode !== null) {
              $rectNode->parentNode->insertBefore($imageNode, $rectNode);
              $rectNode->parentNode->removeChild($rectNode);
            }
          }
        }
      }

      $bigSvgNode = $bigDom->documentElement;
      if ($bigSvgNode instanceof DOMElement && strtolower($bigSvgNode->tagName) === 'svg') {
        $labelBigSvg = $bigDom->saveXML($bigSvgNode);
        if ($labelBigSvg !== false && $labelBigSvg !== '') {
          $labelBig = $labelBigSvg;
          $smallLabel = '';
          if (method_exists($info_smarty, 'getTemplateVars')) {
            $smallLabel = (string)$info_smarty->getTemplateVars('BX_EU_GARAN_LABEL_SMALL');
          } elseif (method_exists($info_smarty, 'get_template_vars')) {
            $smallLabel = (string)$info_smarty->get_template_vars('BX_EU_GARAN_LABEL_SMALL');
          }
          if ($smallLabel !== '') {
            $smallLabel = str_replace('<div id="bx-eu-garan-label-big"></div>', '<div id="bx-eu-garan-label-big">'.$labelBig.'</div>', $smallLabel);
            $info_smarty->assign('BX_EU_GARAN_LABEL_SMALL', $smallLabel);
          }
          $info_smarty->assign('BX_EU_GARAN_LABEL_BIG', '');
        }
      }
    }
    libxml_clear_errors();
    libxml_use_internal_errors($previousUseInternalErrors);
  }
}
