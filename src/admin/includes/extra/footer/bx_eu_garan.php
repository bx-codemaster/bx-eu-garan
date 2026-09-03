<?php
/**
 * Footer for bx_eu_garan module
 */

	defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
  if (defined('MODULE_BX_EU_GARAN_STATUS') && 
              MODULE_BX_EU_GARAN_STATUS == 'True' && 
              basename($_SERVER['PHP_SELF']) == 'bx_eu_garan.php' ||
              basename($_SERVER['PHP_SELF']) == 'categories.php'
			) {
        $bx_form_parameter = xtc_get_all_get_params(array('task')) . 'task=upload_manual';
        echo xtc_draw_form('bx_eu_garan_upload_form', FILENAME_CATEGORIES, $bx_form_parameter, 'post', 'enctype="multipart/form-data" id="bx_eu_garan_upload_form"').'</form>'.PHP_EOL;
  }
  