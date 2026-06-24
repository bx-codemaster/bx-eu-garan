<?php
/* -----------------------------------------------------------------------------------------
	 BX EU Garan - new_product admin hook
	 ---------------------------------------------------------------------------------------*/

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

$bx_eu_garan_values = array(
	'manufacturer_guarantee_available' => 0,
	'guarantee_years'          => '',
	'covers_full_product'      => 1,
	'requires_additional_cost' => 0,
	'qr_url'                   => '',
	'repair_score'             => '',
	'parts_available'          => '',
	'parts_cost_info'          => '',
	'manual_url'               => '',
	'repair_restrictions'      => '',
);

$bx_eu_garan_reference = array(
	'manufacturer_name'       => '',
	'model_identifier'        => '',
	'model_identifier_source' => '',
);

if (isset($pInfo->products_id) && (int)$pInfo->products_id > 0) {
	$product_id = (int)$pInfo->products_id;

	$warranty_query = xtc_db_query("SELECT * FROM bx_products_warranty_guarantee WHERE products_id = '".$product_id."' LIMIT 1");
	if ($warranty_query && xtc_db_num_rows($warranty_query) > 0) {
		$warranty = xtc_db_fetch_array($warranty_query);
		$bx_eu_garan_values['manufacturer_guarantee_available'] = (int)$warranty['manufacturer_guarantee_available'];
		$bx_eu_garan_values['guarantee_years']          = (string)$warranty['guarantee_years'];
		$bx_eu_garan_values['covers_full_product']      = (int)$warranty['covers_full_product'];
		$bx_eu_garan_values['requires_additional_cost'] = (int)$warranty['requires_additional_cost'];
		$bx_eu_garan_values['qr_url']                   = (string)$warranty['qr_url'];
	}

	$repair_query = xtc_db_query("SELECT * FROM bx_products_repairability WHERE products_id = '".$product_id."' LIMIT 1");
	if ($repair_query && xtc_db_num_rows($repair_query) > 0) {
		$repair = xtc_db_fetch_array($repair_query);
		$bx_eu_garan_values['repair_score']        = isset($repair['repair_score']) ? (string)$repair['repair_score'] : '';
		$bx_eu_garan_values['parts_available']     = isset($repair['parts_available']) ? (string)$repair['parts_available'] : '';
		$bx_eu_garan_values['parts_cost_info']     = (string)$repair['parts_cost_info'];
		$bx_eu_garan_values['manual_url']          = (string)$repair['manual_url'];
		$bx_eu_garan_values['repair_restrictions'] = (string)$repair['repair_restrictions'];
	}
}

if (!empty($_POST)) {
	$bx_eu_garan_values['manufacturer_guarantee_available'] = (isset($_POST['bx_eu_garan_manufacturer_guarantee_available']) && (int)$_POST['bx_eu_garan_manufacturer_guarantee_available'] === 1) ? 1 : 0;
	$bx_eu_garan_values['guarantee_years']          = isset($_POST['bx_eu_garan_guarantee_years']) ? (string)$_POST['bx_eu_garan_guarantee_years'] : '';
	$bx_eu_garan_values['covers_full_product']      = (isset($_POST['bx_eu_garan_covers_full_product']) && (int)$_POST['bx_eu_garan_covers_full_product'] === 1) ? 1 : 0;
	$bx_eu_garan_values['requires_additional_cost'] = (isset($_POST['bx_eu_garan_requires_additional_cost']) && (int)$_POST['bx_eu_garan_requires_additional_cost'] === 1) ? 1 : 0;
	$bx_eu_garan_values['qr_url']                   = isset($_POST['bx_eu_garan_qr_url']) ? (string)$_POST['bx_eu_garan_qr_url'] : '';
	$bx_eu_garan_values['repair_score']             = isset($_POST['bx_eu_garan_repair_score']) ? (string)$_POST['bx_eu_garan_repair_score'] : '';
	$bx_eu_garan_values['parts_available']          = isset($_POST['bx_eu_garan_parts_available']) ? (string)$_POST['bx_eu_garan_parts_available'] : '';
	$bx_eu_garan_values['parts_cost_info']          = isset($_POST['bx_eu_garan_parts_cost_info']) ? (string)$_POST['bx_eu_garan_parts_cost_info'] : '';
	$bx_eu_garan_values['manual_url']               = isset($_POST['bx_eu_garan_manual_url']) ? (string)$_POST['bx_eu_garan_manual_url'] : '';
	$bx_eu_garan_values['repair_restrictions']      = isset($_POST['bx_eu_garan_repair_restrictions']) ? (string)$_POST['bx_eu_garan_repair_restrictions'] : '';
}

$bx_eu_garan_reference = bx_eu_garan_get_product_reference_data(
	isset($pInfo->products_id) ? (int)$pInfo->products_id : 0,
	!empty($_POST) ? array(
		'manufacturers_id'             => isset($_POST['manufacturers_id']) ? (int)$_POST['manufacturers_id'] : 0,
		'products_manufacturers_model' => isset($_POST['products_manufacturers_model']) ? (string)$_POST['products_manufacturers_model'] : '',
		'products_ean'                 => isset($_POST['products_ean']) ? (string)$_POST['products_ean'] : '',
		'products_model'               => isset($_POST['products_model']) ? (string)$_POST['products_model'] : '',
	) : array()
);

$parts_available_array = array(
	array('id' => '', 'text'  => TEXT_BX_EU_GARAN_NO_INFO_PROVIDED),
	array('id' => '1', 'text' => CFG_TXT_YES),
	array('id' => '0', 'text' => CFG_TXT_NO),
);

$isGuaranteeLabelRequired = bx_eu_garan_is_harmonized_guarantee_label_required(
	$bx_eu_garan_values['manufacturer_guarantee_available'],
	$bx_eu_garan_values['guarantee_years'],
	$bx_eu_garan_values['requires_additional_cost']
);

$labelRequirementText = $isGuaranteeLabelRequired
	? TEXT_BX_EU_GARAN_PRODUCT_LABEL_REQUIRED
	: TEXT_BX_EU_GARAN_PRODUCT_LABEL_NOT_REQUIRED;
$labelRequirementColor = $isGuaranteeLabelRequired ? '#b42318' : '#027a48';
?>
<div style="clear:both;"></div>

<div class="info_message" style="margin-bottom:10px;">
	<?php echo TEXT_BX_EU_GARAN_PRODUCT_LEGAL_NOTE; ?>
</div>

<details class="bxac-card" style="margin-bottom:10px;">
	<summary class="bxac-summary">
		<span class="bxac-arrow">▸</span>
		<span class="bxac-title">
			<?php echo HEADING_BX_EU_GARAN_PRODUCT_WARRANTY; ?>
		</span>
	</summary>
	<div class="bxac-body">
		<table class="tableInput border0">
			<tr>
				<td style="width:280px;"><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_ENABLED; ?></span></td>
				<td><span class="main"><?php echo draw_on_off_selection('bx_eu_garan_manufacturer_guarantee_available', 'checkbox', ((int)$bx_eu_garan_values['manufacturer_guarantee_available'] === 1)); ?></span></td>
			</tr>
			<tr>
				<td></td>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_ENABLED_NOTE; ?></span></td>
			</tr>
			<tr>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_GUARANTEE_YEARS; ?></span></td>
				<td>
					<span class="main"><?php echo xtc_draw_input_field('bx_eu_garan_guarantee_years', $bx_eu_garan_values['guarantee_years'], 'style="width: 85px"', false, 'number'); ?></span>
				</td>
			</tr>
			<tr>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_MANUFACTURER_AUTO; ?></span></td>
				<td><span class="main"><?php echo $bx_eu_garan_reference['manufacturer_name'] !== '' ? htmlspecialchars($bx_eu_garan_reference['manufacturer_name']) : TEXT_BX_EU_GARAN_NO_INFO_PROVIDED; ?></span></td>
			</tr>
			<tr>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_MODEL_IDENTIFIER_AUTO; ?></span></td>
				<td><span class="main"><?php echo $bx_eu_garan_reference['model_identifier'] !== '' ? htmlspecialchars($bx_eu_garan_reference['model_identifier']) : TEXT_BX_EU_GARAN_NO_INFO_PROVIDED; ?></span></td>
			</tr>
			<tr>
				<td></td>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_MODEL_IDENTIFIER_NOTE; ?></span></td>
			</tr>
			<tr>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_COVERS_FULL_PRODUCT; ?></span></td>
				<td><span class="main"><?php echo draw_on_off_selection('bx_eu_garan_covers_full_product', 'checkbox', ((int)$bx_eu_garan_values['covers_full_product'] === 1)); ?></span></td>
			</tr>
			<tr>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_REQUIRES_ADDITIONAL_COST; ?></span></td>
				<td><span class="main"><?php echo draw_on_off_selection('bx_eu_garan_requires_additional_cost', 'checkbox', ((int)$bx_eu_garan_values['requires_additional_cost'] === 1)); ?></span></td>
			</tr>
			<tr>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_LABEL_REQUIREMENT; ?></span></td>
				<td>
					<span class="main">
						<span style="display:inline-block;padding:5px 8px;border-radius:5px;font-size:11px;font-weight:700;line-height:15px;color:#fff;background:<?php echo $labelRequirementColor; ?>;">
							<?php echo $labelRequirementText; ?>
						</span>
					</span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_LABEL_RULE_NOTE; ?></span></td>
			</tr>
			<tr>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_QR_URL; ?></span></td>
				<td><span class="main"><?php echo xtc_draw_input_field('bx_eu_garan_qr_url', $bx_eu_garan_values['qr_url'], 'style="width: 100%"'); ?></span></td>
			</tr>
		</table>
	</div>
</details>

<details class="bxac-card">
	<summary class="bxac-summary">
		<span class="bxac-arrow">▸</span>
		<span class="bxac-title">
			<?php echo HEADING_BX_EU_GARAN_PRODUCT_REPAIRABILITY; ?>
		</span>
	</summary>
	<div class="bxac-body">
		<table class="tableInput border0">
			<tr>
				<td style="width:280px;"><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_REPAIR_SCORE; ?></span></td>
				<td class="main" style="display: flex; align-items: center; gap: 15px;">
					<div id="repair_score_slider">
						<input type="range" min="0" max="10" step="1" id="bx_eu_garan_repair_score" name="bx_eu_garan_repair_score" value="<?php echo (int)$bx_eu_garan_values['repair_score']; ?>" list="scores" style="min-width: 250px;">
						<datalist id="scores">
							<option value="0"></option>
							<option value="1"></option>
							<option value="2"></option>
							<option value="3"></option>
							<option value="4"></option>
							<option value="5"></option>
							<option value="6"></option>
							<option value="7"></option>
							<option value="8"></option>
							<option value="9"></option>
							<option value="10"></option>
						</datalist>
					</div>
					<div >
						Aktueller Wert: <span id="repair_score_value" style="font-weight: bold;"><?php echo (int)$bx_eu_garan_values['repair_score']; ?></span>
						<script>
							var slider = document.getElementById("bx_eu_garan_repair_score");
							var output = document.getElementById("repair_score_value");
							output.innerHTML = slider.value; // Zeigt den Standardwert an

							// Aktualisiert den Wert, wenn der Benutzer schiebt
							slider.oninput = function() {
							output.innerHTML = this.value;
							}
					</script>
					</div>
				</td>
			</tr>
			<tr>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_PARTS_AVAILABLE; ?></span></td>
				<td><span class="main fixed_sumo" style="width:155px;"><?php echo xtc_draw_pull_down_menu('bx_eu_garan_parts_available', $parts_available_array, $bx_eu_garan_values['parts_available'], 'style="width: 155px"'); ?></span></td>
			</tr>
			<tr>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_PARTS_COST_INFO; ?></span></td>
				<td><span class="main"><?php echo xtc_draw_input_field('bx_eu_garan_parts_cost_info', $bx_eu_garan_values['parts_cost_info'], 'style="width: 100%"'); ?></span></td>
			</tr>
			<tr>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_MANUAL_URL; ?></span></td>
				<td><span class="main"><?php echo xtc_draw_input_field('bx_eu_garan_manual_url', $bx_eu_garan_values['manual_url'], 'style="width: 100%"'); ?></span></td>
			</tr>
			<tr>
				<td><span class="main"><?php echo TEXT_BX_EU_GARAN_PRODUCT_REPAIR_RESTRICTIONS; ?></span></td>
				<td><span class="main"><?php echo xtc_draw_textarea_field('bx_eu_garan_repair_restrictions', 'soft', 70, 4, $bx_eu_garan_values['repair_restrictions']); ?></span></td>
			</tr>
		</table>
	</div>
</details>
