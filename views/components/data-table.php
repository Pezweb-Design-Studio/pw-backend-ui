<?php
// views/components/data-table.php

/**
 * @var array $atts  From ComponentRenderer::data_table().
 */

defined("ABSPATH") || exit();

$headers = $atts["headers"] ?? [];
$rows = $atts["rows"] ?? [];
if (!is_array($headers)) {
	$headers = [];
}
if (!is_array($rows)) {
	$rows = [];
}

$tbl = "pw-bui-data-table";
if (!empty($atts["full_width_headers"])) {
	$tbl .= " pw-bui-data-table--full";
}
$tbl = trim($tbl . " " . ($atts["class"] ?? ""));
?>

<?php if (!empty($atts["wrapper_class"])): ?>
<div class="<?php echo esc_attr($atts["wrapper_class"]); ?>">
<?php endif; ?>

<table class="<?php echo esc_attr($tbl); ?>">
    <?php if ($headers !== []): ?>
    <thead>
        <tr>
            <?php foreach ($headers as $h): ?>
                <th scope="col"><?php echo esc_html((string) $h); ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <?php endif; ?>
    <tbody>
        <?php foreach ($rows as $row): ?>
            <?php if (!is_array($row)) {
            	continue;
            } ?>
            <tr>
                <?php foreach ($row as $cell): ?>
                    <td><?php echo esc_html((string) $cell); ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if (!empty($atts["wrapper_class"])): ?>
</div>
<?php endif; ?>
