<?php
/* -----------------------------------------------------------------------------------------
	 BX EU Garan - new_product admin hook
	 ---------------------------------------------------------------------------------------*/

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

$bx_eu_garan_values = array(
	'enabled'                    => 0,
	'guarantee_years'            => '',
	'manufacturer_name_override' => '',
	'model_identifier_override'  => '',
	'covers_full_product'        => 1,
	'requires_additional_cost'   => 0,
	'qr_url'                     => '',
	'repair_score'               => '',
	'parts_available'            => '',
	'parts_cost_info'            => '',
	'manual_url'                 => '',
	'repair_restrictions'        => '',
);

if (isset($pInfo->products_id) && (int)$pInfo->products_id > 0) {
	$product_id = (int)$pInfo->products_id;

	$warranty_query = xtc_db_query("SELECT * FROM bx_products_warranty_guarantee WHERE products_id = '".$product_id."' LIMIT 1");
	if ($warranty_query && xtc_db_num_rows($warranty_query) > 0) {
		$warranty = xtc_db_fetch_array($warranty_query);
		$bx_eu_garan_values['enabled']                    = (int)$warranty['enabled'];
		$bx_eu_garan_values['guarantee_years']            = (string)$warranty['guarantee_years'];
		$bx_eu_garan_values['manufacturer_name_override'] = (string)$warranty['manufacturer_name_override'];
		$bx_eu_garan_values['model_identifier_override']  = (string)$warranty['model_identifier_override'];
		$bx_eu_garan_values['covers_full_product']        = (int)$warranty['covers_full_product'];
		$bx_eu_garan_values['requires_additional_cost']   = (int)$warranty['requires_additional_cost'];
		$bx_eu_garan_values['qr_url']                     = (string)$warranty['qr_url'];
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
	$bx_eu_garan_values['enabled']                    = isset($_POST['bx_eu_garan_enabled']) ? 1 : 0;
	$bx_eu_garan_values['guarantee_years']            = isset($_POST['bx_eu_garan_guarantee_years']) ? (string)$_POST['bx_eu_garan_guarantee_years'] : '';
	$bx_eu_garan_values['manufacturer_name_override'] = isset($_POST['bx_eu_garan_manufacturer_name_override']) ? (string)$_POST['bx_eu_garan_manufacturer_name_override'] : '';
	$bx_eu_garan_values['model_identifier_override']  = isset($_POST['bx_eu_garan_model_identifier_override']) ? (string)$_POST['bx_eu_garan_model_identifier_override'] : '';
	$bx_eu_garan_values['covers_full_product']        = isset($_POST['bx_eu_garan_covers_full_product']) ? 1 : 0;
	$bx_eu_garan_values['requires_additional_cost']   = isset($_POST['bx_eu_garan_requires_additional_cost']) ? 1 : 0;
	$bx_eu_garan_values['qr_url']                     = isset($_POST['bx_eu_garan_qr_url']) ? (string)$_POST['bx_eu_garan_qr_url'] : '';
	$bx_eu_garan_values['repair_score']               = isset($_POST['bx_eu_garan_repair_score']) ? (string)$_POST['bx_eu_garan_repair_score'] : '';
	$bx_eu_garan_values['parts_available']            = isset($_POST['bx_eu_garan_parts_available']) ? (string)$_POST['bx_eu_garan_parts_available'] : '';
	$bx_eu_garan_values['parts_cost_info']            = isset($_POST['bx_eu_garan_parts_cost_info']) ? (string)$_POST['bx_eu_garan_parts_cost_info'] : '';
	$bx_eu_garan_values['manual_url']                 = isset($_POST['bx_eu_garan_manual_url']) ? (string)$_POST['bx_eu_garan_manual_url'] : '';
	$bx_eu_garan_values['repair_restrictions']        = isset($_POST['bx_eu_garan_repair_restrictions']) ? (string)$_POST['bx_eu_garan_repair_restrictions'] : '';
}

$parts_available_array = array(
	array('id' => '', 'text'  => TEXT_BX_EU_GARAN_NO_INFO_PROVIDED),
	array('id' => '1', 'text' => CFG_TXT_YES),
	array('id' => '0', 'text' => CFG_TXT_NO),
);
?>
<div style="clear:both;"></div>

<div class="main div_header"><b>BX EU Garan: Haltbarkeitsgarantie</b></div>
<div class="clear div_box mrg5">
	<table class="tableInput border0">
		<tr>
			<td style="width:280px;"><span class="main">Kennzeichnung aktiv</span></td>
			<td><span class="main"><?php echo draw_on_off_selection('bx_eu_garan_enabled', 'checkbox', ((int)$bx_eu_garan_values['enabled'] === 1)); ?></span></td>
		</tr>
		<tr>
			<td><span class="main">Garantiedauer (Jahre)</span></td>
			<td><span class="main"><?php echo xtc_draw_input_field('bx_eu_garan_guarantee_years', $bx_eu_garan_values['guarantee_years'], 'style="width: 155px"'); ?></span></td>
		</tr>
		<tr>
			<td><span class="main">Herstellername (Override)</span></td>
			<td><span class="main"><?php echo xtc_draw_input_field('bx_eu_garan_manufacturer_name_override', $bx_eu_garan_values['manufacturer_name_override'], 'style="width: 350px"'); ?></span></td>
		</tr>
		<tr>
			<td><span class="main">Modellkennung (Override)</span></td>
			<td><span class="main"><?php echo xtc_draw_input_field('bx_eu_garan_model_identifier_override', $bx_eu_garan_values['model_identifier_override'], 'style="width: 350px"'); ?></span></td>
		</tr>
		<tr>
			<td><span class="main">Deckt gesamtes Produkt ab</span></td>
			<td><span class="main"><?php echo draw_on_off_selection('bx_eu_garan_covers_full_product', 'checkbox', ((int)$bx_eu_garan_values['covers_full_product'] === 1)); ?></span></td>
		</tr>
		<tr>
			<td><span class="main">Zusatzkosten erforderlich</span></td>
			<td><span class="main"><?php echo draw_on_off_selection('bx_eu_garan_requires_additional_cost', 'checkbox', ((int)$bx_eu_garan_values['requires_additional_cost'] === 1)); ?></span></td>
		</tr>
		<tr>
			<td><span class="main">QR-URL (optional)</span></td>
			<td><span class="main"><?php echo xtc_draw_input_field('bx_eu_garan_qr_url', $bx_eu_garan_values['qr_url'], 'style="width: 100%"'); ?></span></td>
		</tr>
	</table>
</div>

<div class="main div_header"><b>BX EU Garan: Reparierbarkeit</b></div>
<div class="clear div_box mrg5">
	<table class="tableInput border0">
		<tr>
			<td style="width:280px;"><span class="main">Reparierbarkeitswert (0-10)</span></td>
			<td><span class="main"><?php echo xtc_draw_input_field('bx_eu_garan_repair_score', $bx_eu_garan_values['repair_score'], 'style="width: 155px"'); ?></span></td>
		</tr>
		<tr>
			<td><span class="main">Ersatzteile verfuegbar</span></td>
			<td><span class="main fixed_sumo" style="width:155px;"><?php echo xtc_draw_pull_down_menu('bx_eu_garan_parts_available', $parts_available_array, $bx_eu_garan_values['parts_available'], 'style="width: 155px"'); ?></span></td>
		</tr>
		<tr>
			<td><span class="main">Kosteninfo Ersatzteile</span></td>
			<td><span class="main"><?php echo xtc_draw_input_field('bx_eu_garan_parts_cost_info', $bx_eu_garan_values['parts_cost_info'], 'style="width: 100%"'); ?></span></td>
		</tr>
		<tr>
			<td><span class="main">Reparaturanleitung (URL)</span></td>
			<td><span class="main"><?php echo xtc_draw_input_field('bx_eu_garan_manual_url', $bx_eu_garan_values['manual_url'], 'style="width: 100%"'); ?></span></td>
		</tr>
		<tr>
			<td><span class="main">Reparatureinschraenkungen</span></td>
			<td><span class="main"><?php echo xtc_draw_textarea_field('bx_eu_garan_repair_restrictions', 'soft', 70, 4, $bx_eu_garan_values['repair_restrictions']); ?></span></td>
		</tr>
	</table>
</div>
