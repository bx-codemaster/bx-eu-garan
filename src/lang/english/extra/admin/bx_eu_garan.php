<?php
/**
 * ██████╗  ███████╗ ███╗   ██╗  █████╗  ██╗  ██╗
 * ██╔══██╗ ██╔════╝ ████╗  ██║ ██╔══██╗ ╚██╗██╔╝
 * ██████╔╝ █████╗   ██╔██╗ ██║ ███████║  ╚███╔╝
 * ██╔══██╗ ██╔══╝   ██║╚██╗██║ ██╔══██║  ██╔██╗
 * ██████╔╝ ███████╗ ██║ ╚████║ ██║  ██║ ██╔╝ ██╗
 * ╚═════╝  ╚══════╝ ╚═╝  ╚═══╝ ╚═╝  ╚═╝ ╚═╝  ╚═╝
 * BX EU Garan - English Language Texts
 *
 * Interface texts for the BX EU module (Admin area).
 * All UI elements, buttons and descriptions in English language.
 *
 * @package    BX EU Garan
 * @subpackage Language
 * @category   Admin
 * @author     Axel Benkert
 * @version    1.0.0
 * @date       2026-04-06
 * @copyright  2020-2026 Axel Benkert
 * @license    GNU General Public License
 */

  define('HEADING_BX_EU_GARAN_TITLE', 'BX EU legal warranty and manufacturer guarantee');
  define('HEADING_BX_EU_GARAN_SUB_TITLE', 'Central management of the harmonized legal warranty notice and the voluntary manufacturer guarantee.');
  define('HEADING_BX_EU_GARAN_MASS_EDIT_TITLE', 'Bulk edit manufacturer guarantee and repairability');
  define('HEADING_BX_EU_GARAN_PRODUCT_WARRANTY', 'BX EU manufacturer guarantee');
  define('HEADING_BX_EU_GARAN_PRODUCT_REPAIRABILITY', 'BX EU repairability');

  define('TEXT_BX_EU_GARAN_MASS_EDIT_DESCRIPTION', 'Sets selected fields for the voluntary manufacturer guarantee and repairability for many products at once using category and/or manufacturer filters.');
  define('TEXT_BX_EU_GARAN_MASS_EDIT_LEGAL_NOTE', 'The harmonized legal warranty notice is always relevant. The harmonized guarantee label is shown only if a voluntary manufacturer guarantee exists.');
  define('TEXT_BX_EU_GARAN_FEEDBACK_SELECT_AT_LEAST_ONE_FIELD', 'Please select at least one field to update.');
  define('TEXT_BX_EU_GARAN_FEEDBACK_NO_PRODUCTS_FOUND', 'No products found for the selected filters.');
  define('TEXT_BX_EU_GARAN_FEEDBACK_SUCCESS', 'Update successful. Products: %d, warranty updates: %d, repairability updates: %d.');
  define('TEXT_BX_EU_GARAN_FEEDBACK_WARRANTY_CONTENT_SAVED', 'Legal warranty content saved successfully.');
  define('TEXT_BX_EU_GARAN_PREVIEW_RESULT', 'Preview: <strong>%d</strong> products affected.');

  define('TEXT_BX_EU_GARAN_TABLE_HEADING_FILTER', 'Filter');
  define('TEXT_BX_EU_GARAN_TABLE_HEADING_FIELD', 'Field');
  define('TEXT_BX_EU_GARAN_TABLE_HEADING_SET', 'Set');
  define('TEXT_BX_EU_GARAN_TABLE_HEADING_VALUE', 'Value');
  define('TEXT_BX_EU_GARAN_TABLE_HEADING_NOTE', 'Note');

  define('TEXT_BX_EU_GARAN_FIELD_CATEGORY', 'Category');
  define('TEXT_BX_EU_GARAN_FIELD_INCLUDE_SUBCATEGORIES', 'Include subcategories');
  define('TEXT_BX_EU_GARAN_FIELD_MANUFACTURER', 'Manufacturer');
  define('TEXT_BX_EU_GARAN_FIELD_PRODUCT_STATUS', 'Product status');
  define('TEXT_BX_EU_GARAN_FIELD_GUARANTEE_YEARS', 'Manufacturer guarantee period (years)');
  define('TEXT_BX_EU_GARAN_FIELD_GUARANTEE_YEARS_NOTE', 'Label is required only if the period is more than 2 years.');
  define('TEXT_BX_EU_GARAN_FIELD_GUARANTEE_ACTIVE', 'Voluntary manufacturer guarantee available');
  define('TEXT_BX_EU_GARAN_FIELD_GUARANTEE_ACTIVE_NOTE', 'The legal warranty notice always remains active; this field only controls the voluntary manufacturer guarantee when manufacturer information is available.');
  define('TEXT_BX_EU_GARAN_FIELD_REQUIRES_ADDITIONAL_COST', 'Additional costs required');
  define('TEXT_BX_EU_GARAN_FIELD_REQUIRES_ADDITIONAL_COST_NOTE', 'Label is required only if no additional costs apply.');
  define('TEXT_BX_EU_GARAN_FIELD_QR_URL', 'QR URL');
  define('TEXT_BX_EU_GARAN_FIELD_REPAIR_SCORE', 'Repairability score (0-10)');
  define('TEXT_BX_EU_GARAN_FIELD_PARTS_AVAILABLE', 'Spare parts available');
  define('TEXT_BX_EU_GARAN_FIELD_MANUAL_URL', 'Manual URL');
  define('TEXT_BX_EU_GARAN_PRODUCT_LEGAL_NOTE', '<strong>Legal warranty:</strong> always relevant and displayed automatically.<br><strong>Voluntary manufacturer guarantee:</strong> only enter it if it actually exists for this product.');
  define('TEXT_BX_EU_GARAN_PRODUCT_ENABLED', 'Voluntary manufacturer guarantee available');
  define('TEXT_BX_EU_GARAN_PRODUCT_ENABLED_NOTE', 'Controls only the guarantee label. The harmonized legal warranty notice is independent and always relevant. No duty to investigate: label only if information is provided by the manufacturer.');
  define('TEXT_BX_EU_GARAN_PRODUCT_GUARANTEE_YEARS', 'Manufacturer guarantee period (years)');
  define('TEXT_BX_EU_GARAN_PRODUCT_MANUFACTURER_AUTO', 'Manufacturer (automatic)');
  define('TEXT_BX_EU_GARAN_PRODUCT_MODEL_IDENTIFIER_AUTO', 'Model identifier (automatic)');
  define('TEXT_BX_EU_GARAN_PRODUCT_MODEL_IDENTIFIER_NOTE', 'Determined automatically from manufacturer model, EAN, or product number.');
  define('TEXT_BX_EU_GARAN_PRODUCT_COVERS_FULL_PRODUCT', 'Covers full product');
  define('TEXT_BX_EU_GARAN_PRODUCT_REQUIRES_ADDITIONAL_COST', 'Additional cost required');
  define('TEXT_BX_EU_GARAN_PRODUCT_LABEL_REQUIREMENT', 'Guarantee label required');
  define('TEXT_BX_EU_GARAN_PRODUCT_LABEL_REQUIRED', 'Yes');
  define('TEXT_BX_EU_GARAN_PRODUCT_LABEL_NOT_REQUIRED', 'No');
  define('TEXT_BX_EU_GARAN_PRODUCT_LABEL_RULE_NOTE', '<strong>Required only if:</strong> 
  <ul>
    <li>✅ a voluntary manufacturer guarantee exists, 
    <li>✅ exceeds 2 years, 
    <li>✅ and no additional costs apply.
  </ul>
  ');
  define('TEXT_BX_EU_GARAN_PRODUCT_QR_URL', 'QR URL (optional)');
  define('TEXT_BX_EU_GARAN_PRODUCT_REPAIR_SCORE', 'Repairability score (0-10)');
  define('TEXT_BX_EU_GARAN_PRODUCT_PARTS_AVAILABLE', 'Spare parts available');
  define('TEXT_BX_EU_GARAN_PRODUCT_PARTS_COST_INFO', 'Spare parts cost info');
  define('TEXT_BX_EU_GARAN_PRODUCT_MANUAL_URL', 'Repair instructions (URL)');
  define('TEXT_BX_EU_GARAN_PRODUCT_REPAIR_RESTRICTIONS', 'Repair restrictions');

  define('TEXT_BX_EU_GARAN_FILTER_ALL_CATEGORIES', 'All categories');
  define('TEXT_BX_EU_GARAN_FILTER_ALL_MANUFACTURERS', 'All manufacturers');
  define('TEXT_BX_EU_GARAN_FILTER_WITHOUT_MANUFACTURER', 'Without manufacturer');
  define('TEXT_BX_EU_GARAN_FILTER_ALL_PRODUCTS', 'All products');
  define('TEXT_BX_EU_GARAN_FILTER_ONLY_ACTIVE', 'Active only');
  define('TEXT_BX_EU_GARAN_FILTER_ONLY_INACTIVE', 'Inactive only');

  define('BUTTON_BX_EU_GARAN_PREVIEW', 'Show preview');
  define('BUTTON_BX_EU_GARAN_APPLY', 'Apply changes');
  define('BUTTON_BX_EU_GARAN_SAVE_WARRANTY_CONTENT', 'Save legal warranty content');
  define('TEXT_BX_EU_GARAN_CONFIRM_MASS_UPDATE', 'The selected fields will be set for all filtered products. Continue?');

  define('TEXT_BX_EU_GARAN_LEGAL_WARRANTY_BOX_TITLE', 'Legal warranty');
  define('TEXT_BX_EU_GARAN_LEGAL_WARRANTY_BOX_DESCRIPTION', 'Select a content entry from the content manager. The coID will be used to build the legal warranty button link.');

  define('TEXT_BX_EU_GARAN_INFOBOX_TITLE', 'Information');
  define('TEXT_BX_EU_GARAN_URL_NEW_LABELS', 'https://www.it-recht-kanzlei.de/neue-label-gewaehrleistung-garantie-2026.html');
  define('TEXT_BX_EU_GARAN_URL_FAQ', 'https://www.it-recht-kanzlei.de/faq-gewaehrleistunglabel-garantielabel.html');
  define('TEXT_BX_EU_GARAN_URL_IHK', 'https://www.ihk.de/stuttgart/fuer-unternehmen/recht-und-steuern/wettbewerbsrecht/garantien-und-gewaehrleistung-neue-informationspflichten-7004604');
  define('TEXT_BX_EU_GARAN_URL_EUR_LEX', 'https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32025R1960');
  define('TEXT_BX_EU_GARAN_LINK_NEW_LABELS', 'New legal warranty and guarantee labels');
  define('TEXT_BX_EU_GARAN_LINK_FAQ', 'FAQ on legal warranty and guarantee labels');
  define('TEXT_BX_EU_GARAN_LINK_IHK', 'IHK Stuttgart: Guarantees and legal warranty');
  define('TEXT_BX_EU_GARAN_LINK_EUR_LEX', 'Commission Implementing Regulation (EU) 2025/1960 of 25 September 2025');

  define('TEXT_BX_EU_GARAN_NO_INFO_PROVIDED', 'n/a');