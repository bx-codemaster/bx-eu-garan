<?php
	defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
  if (defined('MODULE_BX_EU_GARAN_STATUS') && 
              MODULE_BX_EU_GARAN_STATUS == 'True' && 
              basename($_SERVER['PHP_SELF']) == 'bx_eu_garan.php' ||
              basename($_SERVER['PHP_SELF']) == 'categories.php'
			) {
		if (!function_exists('xtc_try_upload')) {
			require_once(DIR_FS_INC . 'xtc_try_upload.inc.php');
		};

		if ( isset($_GET['task']) && $_GET['task'] === 'upload_manual') {
			$upload_dir = DIR_FS_CATALOG . 'pub/manuals/';
			
			if (!is_dir($upload_dir)) {
				if (!mkdir($upload_dir, 0775, true) && !is_dir($upload_dir)) {
					$messageStack->add_session(sprintf(TEXT_BX_EU_GARAN_MESSAGE_UPLOAD_DIR_NOT_WRITABLE, $upload_dir), 'error');
					xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('task'))));
				}
			}

			if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
				$messageStack->add_session(sprintf(TEXT_BX_EU_GARAN_MESSAGE_UPLOAD_DIR_NOT_WRITABLE, $upload_dir), 'error');
				xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('task'))));
			}

			$accepted_extensions = array('pdf', 'epub', 'doc', 'docx');
			$accepted_mime_types = array(
				'application/pdf',                                                        // .pdf
				'application/epub+zip',                                                   // .epub
				'application/msword',                                                     // .doc
				'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // .docx
			);

			$uploadResult = xtc_try_upload('new_manual_file', 
									$upload_dir, 
									'644', 
									$accepted_extensions, 
									$accepted_mime_types);

			if ($uploadResult !== false && isset($uploadResult->filename) && $uploadResult->filename !== '') {
				$messageStack->add_session(TEXT_BX_EU_GARAN_MESSAGE_UPLOAD_SUCCESS, 'success');
			} else {
				$messageStack->add_session(TEXT_BX_EU_GARAN_MESSAGE_UPLOAD_FAILED, 'warning');
			}

			xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('task'))));
		}
  }