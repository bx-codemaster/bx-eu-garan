<?php
/** 
 * BX EU Garan - English Language Texts
 *
 * Interface texts for the BX EU module (Admin area).
 * All UI elements, buttons, and descriptions are in English.
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

  define('HEADING_BX_EU_GARAN_TITLE', 'BX EU Warranty and Manufacturer\'s Guarantee');
  define('HEADING_BX_EU_GARAN_SUB_TITLE', 'Central management of the harmonized warranty notice and the voluntary manufacturer\'s guarantee.');
  define('HEADING_BX_EU_GARAN_MASS_EDIT_TITLE', 'Mass Edit Manufacturer\'s Guarantee');
  define('HEADING_BX_EU_GARAN_PRODUCT_WARRANTY', 'BX EU Manufacturer\'s Guarantee');

  define('TEXT_BX_EU_GARAN_MASS_EDIT_DESCRIPTION', 'Set selected fields of the voluntary manufacturer\'s guarantee for many products at once using the category and/or manufacturer filter.');
  define('TEXT_BX_EU_GARAN_MASS_EDIT_LEGAL_NOTE', 'The harmonized notice for the statutory warranty is always relevant.<br>The harmonized labeling for the guarantee is only displayed if a voluntary manufacturer\'s guarantee exists.');
  define('TEXT_BX_EU_GARAN_FEEDBACK_SELECT_AT_LEAST_ONE_FIELD', 'Please select at least one field to set.');
  define('TEXT_BX_EU_GARAN_FEEDBACK_NO_PRODUCTS_FOUND', 'No products found with the selected filters.');
  define('TEXT_BX_EU_GARAN_FEEDBACK_SUCCESS', '%d products updated (%d guarantee).');
  define('TEXT_BX_EU_GARAN_FEEDBACK_WARRANTY_CONTENT_SAVED', 'Warranty content saved successfully.');
  define('TEXT_BX_EU_GARAN_PREVIEW_RESULT', 'Preview: <strong>%d</strong> products affected.');
  define('TEXT_BX_EU_GARAN_AUTOPLAY_WARNING_TITLE', 'WARNING!');
  define('TEXT_BX_EU_GARAN_AUTOPLAY_WARNING', 'Your browser is blocking the automatic playback of the warning sound.');

  define('TEXT_BX_EU_GARAN_TABLE_HEADING_FILTER', 'Filter');
  define('TEXT_BX_EU_GARAN_TABLE_HEADING_FIELD', 'Field');
  define('TEXT_BX_EU_GARAN_TABLE_HEADING_SET', 'Set');
  define('TEXT_BX_EU_GARAN_TABLE_HEADING_VALUE', 'Value');
  define('TEXT_BX_EU_GARAN_TABLE_HEADING_NOTE', 'Note');

  define('TEXT_BX_EU_GARAN_FIELD_CATEGORY', 'Category');
  define('TEXT_BX_EU_GARAN_FIELD_INCLUDE_SUBCATEGORIES', 'Include Subcategories');
  define('TEXT_BX_EU_GARAN_FIELD_MANUFACTURER', 'Manufacturer');
  define('TEXT_BX_EU_GARAN_FIELD_PRODUCT_STATUS', 'Product Status');
  define('TEXT_BX_EU_GARAN_FIELD_GUARANTEE_YEARS', 'Duration of Manufacturer\'s Guarantee (Years)');
  define('TEXT_BX_EU_GARAN_FIELD_GUARANTEE_YEARS_NOTE', 'The labeling is only required for more than 2 years.');
  define('TEXT_BX_EU_GARAN_FIELD_GUARANTEE_ACTIVE', 'Voluntary Manufacturer\'s Guarantee Present');
  define('TEXT_BX_EU_GARAN_FIELD_GUARANTEE_ACTIVE_NOTE', '<strong>The warranty notice is always active!</strong><br>This field only controls the voluntary manufacturer\'s guarantee, if manufacturer information is available.');
  define('TEXT_BX_EU_GARAN_FIELD_COVERS_FULL_PRODUCT', 'Covers Full Product');
  define('TEXT_BX_EU_GARAN_FIELD_COVERS_FULL_PRODUCT_NOTE', 'The labeling is only required if the entire product is covered.');
  define('TEXT_BX_EU_GARAN_FIELD_REQUIRES_ADDITIONAL_COST', 'Requires Additional Cost');
  define('TEXT_BX_EU_GARAN_FIELD_REQUIRES_ADDITIONAL_COST_NOTE', 'The labeling is only required if no additional costs are incurred.');
  define('TEXT_BX_EU_GARAN_FIELD_QR_URL', 'QR URL');
  define('TEXT_BX_EU_GARAN_FIELD_MANUAL_URL', 'Manual URL');
  define('TEXT_BX_EU_GARAN_PRODUCT_LEGAL_NOTE', '<strong>Statutory Warranty:</strong> always relevant and automatically displayed.<br><strong>Voluntary Manufacturer\'s Guarantee:</strong> only indicate if it actually exists for this product.');
  define('TEXT_BX_EU_GARAN_PRODUCT_ENABLED', 'Voluntary Manufacturer\'s Guarantee Present');
  define('TEXT_BX_EU_GARAN_PRODUCT_ENABLED_NOTE', 'Controls only the guarantee label.<br>The harmonized warranty notice is independent of this and always relevant.<br>No duty to investigate: Labeling only required if information is provided by the manufacturer.');
  define('TEXT_BX_EU_GARAN_PRODUCT_GUARANTEE_YEARS', 'Duration of Manufacturer\'s Guarantee (Years)');
  define('TEXT_BX_EU_GARAN_PRODUCT_MANUFACTURER_AUTO', 'Manufacturer (automatic)');
  define('TEXT_BX_EU_GARAN_PRODUCT_MODEL_IDENTIFIER_AUTO', 'Model Identifier (automatic)');
  define('TEXT_BX_EU_GARAN_PRODUCT_MODEL_IDENTIFIER_NOTE', 'Determined automatically from manufacturer model, EAN, or article number.');
  define('TEXT_BX_EU_GARAN_PRODUCT_COVERS_FULL_PRODUCT', 'Covers Full Product');
  define('TEXT_BX_EU_GARAN_PRODUCT_REQUIRES_ADDITIONAL_COST', 'Requires Additional Cost');
  define('TEXT_BX_EU_GARAN_PRODUCT_LABEL_REQUIREMENT', 'Guarantee Label Required');
  define('TEXT_BX_EU_GARAN_PRODUCT_LABEL_REQUIRED', 'Yes');
  define('TEXT_BX_EU_GARAN_PRODUCT_LABEL_NOT_REQUIRED', 'No');
  define('TEXT_BX_EU_GARAN_PRODUCT_LABEL_RULE_NOTE', '<strong>Required only if:</strong>
    <ul>
    <li>voluntary manufacturer\'s guarantee is present</li>
    <li>applies for more than 2 years</li>
    <li>no additional costs are incurred</li>
    </ul>');
  define('TEXT_BX_EU_GARAN_PRODUCT_QR_URL', 'QR-URL (optional)');

  define('TEXT_BX_EU_GARAN_FIELD_CURRENT_VALUE', 'Current Value:');
  define('TEXT_BX_EU_GARAN_DELETE_FILTERED_ENTRIES', 'Delete Filtered Entries');
  define('TEXT_BX_EU_GARAN_DELETE_ENTRIES_WARRANTY', 'Delete Entries with Warranty');

  define('TEXT_BX_EU_GARAN_FILTER_ALL_CATEGORIES', 'All Categories');
  define('TEXT_BX_EU_GARAN_FILTER_ALL_MANUFACTURERS', 'All Manufacturers');
  define('TEXT_BX_EU_GARAN_FILTER_WITHOUT_MANUFACTURER', 'Without Manufacturer');
  define('TEXT_BX_EU_GARAN_FILTER_ALL_PRODUCTS', 'All Products');
  define('TEXT_BX_EU_GARAN_FILTER_ONLY_ACTIVE', 'Only Active');
  define('TEXT_BX_EU_GARAN_FILTER_ONLY_INACTIVE', 'Only Inactive');

  define('BUTTON_BX_EU_GARAN_PREVIEW', 'Show Preview');
  define('BUTTON_BX_EU_GARAN_APPLY', 'Apply Changes');
  define('BUTTON_BX_EU_GARAN_SAVE_WARRANTY_CONTENT', 'Save Warranty Text');
  define('BUTTON_BX_EU_GARAN_DELETE_PRESET', 'Delete');
  define('BUTTON_BX_EU_GARAN_DELETE_PRESET_CONFIRM', 'Really delete preset?');
  define('TEXT_BX_EU_GARAN_SAVE_PRESET', 'Save Current Configuration as Preset');
  define('BUTTON_BX_EU_GARAN_LOAD_PRESET', 'Load');
  define('BUTTON_BX_EU_GARAN_SAVE_PRESET', 'Save');
  define('TEXT_BX_EU_GARAN_LOAD_PRESETS', 'Load Available Presets');
  define('TEXT_BX_EU_GARAN_NO_PRESETS', 'No Presets Available.');

  define('TEXT_BX_EU_GARAN_CONFIRM_MASS_UPDATE', 'The selected fields will be applied to all filtered products. Continue?');
  define('TEXT_BX_EU_GARAN_LEGAL_WARRANTY_BOX_TITLE', 'Warranty');
  define('TEXT_BX_EU_GARAN_LEGAL_WARRANTY_BOX_DESCRIPTION', 'Select content from the content manager. The link for the warranty button is generated from the coID.');

  define('TEXT_BX_EU_GARAN_INFOBOX_TITLE', 'Information');
  define('TEXT_BX_EU_GARAN_URL_NEW_LABELS', 'https://www.it-recht-kanzlei.de/neue-label-gewaehrleistung-garantie-2026.html');
  define('TEXT_BX_EU_GARAN_URL_FAQ', 'https://www.it-recht-kanzlei.de/faq-gewaehrleistunglabel-garantielabel.html');
  define('TEXT_BX_EU_GARAN_URL_IHK', 'https://www.ihk.de/stuttgart/fuer-unternehmen/recht-und-steuern/wettbewerbsrecht/garantien-und-gewaehrleistung-neue-informationspflichten-7004604');
  define('TEXT_BX_EU_GARAN_URL_EUR_LEX', 'https://eur-lex.europa.eu/legal-content/DE/TXT/?uri=CELEX:32025R1960');
  define('TEXT_BX_EU_GARAN_LINK_NEW_LABELS', 'New Warranty and Guarantee Labels');
  define('TEXT_BX_EU_GARAN_LINK_FAQ', 'FAQ on the Warranty and Guarantee Label');
  define('TEXT_BX_EU_GARAN_LINK_IHK', 'IHK Stuttgart: Guarantees and Warranty');
  define('TEXT_BX_EU_GARAN_LINK_EUR_LEX', 'Commission Implementing Regulation (EU) 2025/1960 of 25 September 2025');
  define('TEXT_BX_EU_GARAN_NO_INFO_PROVIDED', 'No information provided');

  define('TEXT_WARRANTY_AND_GUARANTEE_TITLE', 'Warranty and Guarantee under German Law');
  define('TEXT_WARRANTY_AND_GUARANTEE_DESC_01', 'In Germany, the terms warranty and guarantee are often used synonymously in everyday life, but legally they describe two completely different concepts.');
  define('TEXT_WARRANTY_AND_GUARANTEE_DESC_02', 'Here is an overview that brings order to the legal chaos.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_TITLE', '1. The Warranty (Liability for Defects)');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_DESC', 'The warranty is a legal right. It regulates the seller\'s liability for defects that already existed at the time of purchase (handover of the goods).');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_1_LABEL', 'Duration:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_1_TEXT', 'For new goods legally 24 months, for used goods it can be reduced to 12 months.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_2_LABEL', 'Responsible:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_2_TEXT', 'Always the seller (dealer), not the manufacturer.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_3_LABEL', 'Content:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_3_TEXT', 'The buyer primarily has the right to subsequent performance (repair or replacement delivery). If this fails, withdrawal, reduction or damages come into question.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_SUBTITLE', 'Reversal of the Burden of Proof');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_SUBDESC', 'This is the crucial point in practice:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_PROOF_1', 'In the first 12 months, it is assumed that the defect already existed at the time of purchase. The seller would have to prove the opposite.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_PROOF_2', 'After 12 months, the reversal of the burden of proof applies: Now the buyer must prove that the defect was already present at the time of delivery.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_LEGAL_BASIS_TITLE', 'Legal Basis:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_LEGAL_BASIS_1', '§ 437 BGB: Rights of the buyer in case of defects.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_LEGAL_BASIS_2', '§ 438 BGB: Limitation of claims for defects.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_LEGAL_BASIS_3', '§ 477 BGB: Reversal of the burden of proof (particularly important for consumer goods purchases).');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_TITLE', '2. The Guarantee');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_DESC', 'The guarantee is a voluntary service. It is an additional promise that goes beyond the legal obligations.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_1_LABEL', 'Duration:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_1_TEXT', 'Freely selectable by the guarantor (e.g., 6 months, 5 years or "lifetime").');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_2_LABEL', 'Responsible:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_2_TEXT', 'Mostly the manufacturer (manufacturer\'s guarantee), less often the dealer (dealer\'s guarantee).');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_3_LABEL', 'Content:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_3_TEXT', 'The conditions are determined by the guarantor himself. Often it refers to the functionality of certain parts over a certain period of time.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_4_LABEL', 'Relationship:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_4_TEXT', 'A guarantee may never restrict or replace the statutory warranty. It exists in parallel.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_LEGAL_BASIS_TITLE', 'Legal Basis:');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_LEGAL_BASIS_1', '§ 443 BGB: Guarantee.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_LEGAL_BASIS_2', '§ 479 BGB: Special provisions for guarantees in consumer goods purchases (transparency obligations).');
  define('TEXT_WARRANTY_AND_GUARANTEE_SUMMARY_TITLE', 'Summary: The Differences at a Glance');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_HEADER_FEATURE', 'Feature');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_HEADER_WARRANTY', 'Warranty');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_HEADER_GUARANTEE', 'Guarantee');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_STATUS', 'Status');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_STATUS_WARRANTY', 'Statutory');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_STATUS_GUARANTEE', 'Voluntary Additional Service');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_CONTACT', 'Contact Person');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_CONTACT_WARRANTY', 'Seller (Dealer)');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_CONTACT_GUARANTEE', 'Mostly the Manufacturer');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_DURATION', 'Duration');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_DURATION_WARRANTY', '24 months (for new goods)');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_DURATION_GUARANTEE', 'Any (depending on the contract)');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_COST', 'Cost');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_COST_WARRANTY', 'Free for the buyer');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_COST_GUARANTEE', 'Mostly included for free');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_LEGAL_BASIS', 'Legal Basis');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_LEGAL_BASIS_WARRANTY', '§§ 434 ff. BGB');
  define('TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_LEGAL_BASIS_GUARANTEE', '§ 443 BGB');
  define('TEXT_WARRANTY_AND_GUARANTEE_SOURCES_TITLE', 'Sources and Further Information');
  define('TEXT_WARRANTY_AND_GUARANTEE_SOURCE_1', 'Bürgerliches Gesetzbuch (BGB): The central legal source for purchase law in Germany.');
  define('TEXT_WARRANTY_AND_GUARANTEE_SOURCE_2', 'Verbraucherzentrale: Provides detailed guides on current rulings and practical enforcement (e.g., on the 2022 reform of the law of obligations).');
  define('TEXT_WARRANTY_AND_GUARANTEE_SOURCE_3', 'Stiftung Warentest: Regularly publishes comparisons on handling complaints with major retailers.');
  define('TEXT_WARRANTY_AND_GUARANTEE_NOTE', 'Note: This explanation is for informational purposes only and does not constitute legal advice.');

  define('MODULE_BX_EU_GARAN_CATEGORIES_INSTALL_FIRST', 'Please install the "BX EU Garan Categories" module first before using the main module. (Modules -> Class Extensions -> Categories)');
  define('MODULE_BX_EU_GARAN_ORDER_INSTALL_FIRST', 'Please install the "BX EU Garan Orders" module first before using the main module. (Modules -> Class Extensions -> Orders)');
  define('MODULE_BX_EU_GARAN_CART_INSTALL_FIRST', 'Please install the "BX EU Garan Cart" module first before using the main module. (Modules -> Class Extensions -> Cart)');

  define('TEXT_BX_EU_GARAN_PLEASE_CHOOSE', '-- Please choose --');
  define('TEXT_BX_EU_GARAN_MESSAGE_UPLOAD_SUCCESS', 'The manual was successfully uploaded.');
  define('TEXT_BX_EU_GARAN_MESSAGE_UPLOAD_FAILED', 'Error uploading the manual.');
  define('TEXT_BX_EU_GARAN_MESSAGE_UPLOAD_DIR_NOT_WRITABLE', 'The directory for manuals is not writable: %s');
