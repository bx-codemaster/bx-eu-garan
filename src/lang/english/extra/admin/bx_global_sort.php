<?php
/** 
 * ██████╗  ███████╗ ███╗   ██╗  █████╗  ██╗  ██╗
 * ██╔══██╗ ██╔════╝ ████╗  ██║ ██╔══██╗ ╚██╗██╔╝
 * ██████╔╝ █████╗   ██╔██╗ ██║ ███████║  ╚███╔╝
 * ██╔══██╗ ██╔══╝   ██║╚██╗██║ ██╔══██║  ██╔██╗
 * ██████╔╝ ███████╗ ██║ ╚████║ ██║  ██║ ██╔╝ ██╗
 * ╚═════╝  ╚══════╝ ╚═╝  ╚═══╝ ╚═╝  ╚═╝ ╚═╝  ╚═╝
 * BX Global Sort - English Language Texts
 * 
 * Interface texts for the BX Global Sort module (Admin area).
 * All UI elements, buttons and descriptions in English language.
 * 
 * @package    BX Global Sort
 * @subpackage Language
 * @category   Admin
 * @author     Axel Benkert
 * @version    1.2
 * @since      1.0.0
 * @date       2025-11-09
 * @copyright  2020-2025 Axel Benkert
 * @license    GNU General Public License
 */

  define('HEADING_BX_GLOBAL_SORT_TITLE', 'BX Global Sort');
  define('HEADING_BX_GLOBAL_SORT_SUB_TITLE', 'Central product sorting for the homepage and categories');
  define('BX_GS_TXT_STARTPAGE', 'Start page');
  define('BX_GS_TXT_SAVE', 'Save');
  define('BX_GS_TXT_IMAGE', 'Image');
  define('BX_GS_TXT_ART_NO', 'Art.-No.');
  define('BX_GS_TXT_NAME', 'Product name');
  define('BX_GS_TXT_CATEGORY', 'Category');
  define('BX_GS_TXT_STATUS', 'Status');
  define('BX_GS_TXT_CURRENT', 'Current');
  define('BX_GS_TXT_TOP', 'Top');
  define('BX_GS_TXT_NEW', 'Nes');  
  define('BX_GS_TXT_SAVED_SUCCESSFULLY', 'The new sort order was saved successfully!');
  define('BX_GS_TXT_MOVE_TOP', 'To the very top');
  define('BX_GS_TXT_MOVE_BOTTOM', 'To the very bottom');
  define('BX_GS_TXT_MOVE_UP', 'Up one');
  define('BX_GS_TXT_MOVE_DOWN', 'Down one');
  define('BX_GS_TXT_CHOOSE_CATEGORY', 'Please select category.');
  define('BX_GS_TXT_CATEGORIES', 'Categories');
  
  // AJAX Toast-Notifications
  define('BX_GS_AJAX_ERROR_NO_PRODUCT_ID', 'Error: Product ID not found');
  define('BX_GS_AJAX_ERROR_INVALID_PRODUCT_ID', 'Error: Invalid Product ID');
  define('BX_GS_AJAX_SUCCESS_SAVED', 'Sort order saved');
  define('BX_GS_AJAX_ERROR_SAVING', 'Error saving');
  define('BX_GS_AJAX_ERROR_SERVER', 'Server error');
  
  // AJAX Backend Response Messages
  define('BX_GS_AJAX_SUCCESS_STARTPAGE', 'Start page sorting saved');
  define('BX_GS_AJAX_SUCCESS_CATEGORY', 'Category sorting saved');
  define('BX_GS_AJAX_ERROR_DATABASE', 'Database error while saving');
  define('BX_GS_AJAX_ERROR_INVALID_INPUT', 'Invalid input data');
  
  // Translation Validation Error Messages
  define('BX_GS_TRANSLATION_ERROR_TITLE', 'Missing Translations Found');
  define('BX_GS_TRANSLATION_ERROR_MESSAGE', 'The following categories and/or products do not have translations in the %s language. Please add the missing translations before using this page.');
  define('BX_GS_MISSING_CATEGORIES', 'Categories Without Translation');
  define('BX_GS_MISSING_PRODUCTS', 'Products Without Translation');
  define('BX_GS_EDIT_TRANSLATION', 'Edit');
  define('BX_GS_WHAT_TO_DO', 'What to do?');
  define('BX_GS_INSTRUCTION_1', 'Click "Edit" next to each entry to add the missing translation');
  define('BX_GS_INSTRUCTION_2', 'Fill in the "Category Name" or "Product Name" field in the corresponding language');
  define('BX_GS_INSTRUCTION_3', 'After saving, click "Reload Page" to continue');
  define('BX_GS_RELOAD_PAGE', 'Reload Page');
  
  // Error Messages
  define('BX_GS_NO_CATEGORY_PATH', 'No category assigned');
  