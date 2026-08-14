<?php
require_once (DIR_WS_LANGUAGES.$_SESSION['language'].'/extra/admin/bx_eu_garan.php');
?>

<main class="container">
<article class="card" style="padding: 1rem; margin: 1rem auto; max-width: 1000px;">
<header>
	<?php echo xtc_image(DIR_WS_IMAGES . 'warranty_guarantee/legal_guarantee_' . $_SESSION["language_code"] . '.jpg', TEXT_WARRANTY_AND_GUARANTEE_TITLE, '', '', 'style="max-width: 100%; margin-bottom: 1em;"'); ?>

	<h1><?php echo TEXT_WARRANTY_AND_GUARANTEE_TITLE; ?></h1>

	<p><?php echo TEXT_WARRANTY_AND_GUARANTEE_DESC_01; ?></p>

	<p><?php echo TEXT_WARRANTY_AND_GUARANTEE_DESC_02; ?></p>
</header>

<section>
<h2><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_TITLE; ?></h2>

<p><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_DESC; ?></p>

<ul>
	<li><strong><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_1_LABEL; ?></strong> <?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_1_TEXT; ?></li>
	<li><strong><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_2_LABEL; ?></strong> <?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_2_TEXT; ?></li>
	<li><strong><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_3_LABEL; ?></strong> <?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_BULLET_3_TEXT; ?></li>
</ul>
&nbsp;

<h3><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_SUBTITLE; ?></h3>

<p><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_SUBDESC; ?></p>

<ul>
	<li><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_PROOF_1; ?></li>
	<li><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_PROOF_2; ?></li>
</ul>

<blockquote>
<p><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_LEGAL_BASIS_TITLE; ?></p>

<ul>
	<li><a href="https://www.gesetze-im-internet.de/bgb/__437.html" name="$437 BGB" target="_blank"><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_LEGAL_BASIS_1; ?></a></li>
	<li><a href="https://www.gesetze-im-internet.de/bgb/__438.html" name="§438 BGB" target="_blank"><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_LEGAL_BASIS_2; ?></a></li>
	<li><a href="https://www.gesetze-im-internet.de/bgb/__477.html" name="$477 BGB" target="_blank"><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_1_LEGAL_BASIS_3; ?></a></li>
</ul>
</blockquote>
</section>

<section>
<h2><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_TITLE; ?></h2>

<p><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_DESC; ?></p>

<ul>
	<li><strong><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_1_LABEL; ?></strong> <?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_1_TEXT; ?></li>
	<li><strong><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_2_LABEL; ?></strong> <?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_2_TEXT; ?></li>
	<li><strong><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_3_LABEL; ?></strong> <?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_3_TEXT; ?></li>
	<li><strong><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_4_LABEL; ?></strong> <?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_BULLET_4_TEXT; ?></li>
</ul>

<blockquote>
<p><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_LEGAL_BASIS_TITLE; ?></p>

<ul>
	<li><a href="https://www.gesetze-im-internet.de/bgb/__443.html" name="$443 BGB" target="_blank"><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_LEGAL_BASIS_1; ?></a></li>
	<li><a href="https://www.gesetze-im-internet.de/bgb/__479.html" name="$479 BGB" target="_top"><?php echo TEXT_WARRANTY_AND_GUARANTEE_SECTION_2_LEGAL_BASIS_2; ?></a></li>
</ul>
</blockquote>
</section>

<section>
<h2><?php echo TEXT_WARRANTY_AND_GUARANTEE_SUMMARY_TITLE; ?></h2>

<table height="200" width="800">
	<thead>
		<tr>
			<th><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_HEADER_FEATURE; ?></th>
			<th><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_HEADER_WARRANTY; ?></th>
			<th><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_HEADER_GUARANTEE; ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_STATUS; ?></td>
			<td><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_STATUS_WARRANTY; ?></td>
			<td><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_STATUS_GUARANTEE; ?></td>
		</tr>
		<tr>
			<td><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_CONTACT; ?></td>
			<td><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_CONTACT_WARRANTY; ?></td>
			<td><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_CONTACT_GUARANTEE; ?></td>
		</tr>
		<tr>
			<td><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_DURATION; ?></td>
			<td><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_DURATION_WARRANTY; ?></td>
			<td><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_DURATION_GUARANTEE; ?></td>
		</tr>
		<tr>
			<td><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_COST; ?></td>
			<td><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_COST_WARRANTY; ?></td>
			<td><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_COST_GUARANTEE; ?></td>
		</tr>
		<tr>
			<td><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_LEGAL_BASIS; ?></td>
			<td><a href="https://www.gesetze-im-internet.de/bgb/__434.html" name="§§ 434 ff. BGB" target="_top"><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_LEGAL_BASIS_WARRANTY; ?></a></td>
			<td><a href="https://www.gesetze-im-internet.de/bgb/__443.html" name="§ 443 BGB" target="_top"><?php echo TEXT_WARRANTY_AND_GUARANTEE_TABLE_ROW_LEGAL_BASIS_GUARANTEE; ?></a></td>
		</tr>
	</tbody>
</table>
</section>

<section>
<h2><?php echo TEXT_WARRANTY_AND_GUARANTEE_SOURCES_TITLE; ?></h2>

<ol>
	<li><?php echo TEXT_WARRANTY_AND_GUARANTEE_SOURCE_1; ?></li>
	<li><?php echo TEXT_WARRANTY_AND_GUARANTEE_SOURCE_2; ?></li>
	<li><?php echo TEXT_WARRANTY_AND_GUARANTEE_SOURCE_3; ?></li>
</ol>
</section>

<p class="note"><em><?php echo TEXT_WARRANTY_AND_GUARANTEE_NOTE; ?></em></p>
</article>
</main>
