<?php
// views/components/stats-bar.php

/**
 * @var array $atts  From ComponentRenderer::stats_bar().
 */

defined("ABSPATH") || exit();

$items = $atts["items"] ?? [];
if (!is_array($items) || $items === []) {
	return;
}

$wrap_cls = trim("pw-bui-stats-bar " . ($atts["class"] ?? ""));
?>

<?php if (!empty($atts["wrapper_class"])): ?>
<div class="<?php echo esc_attr($atts["wrapper_class"]); ?>">
<?php endif; ?>

<div class="<?php echo esc_attr($wrap_cls); ?>">
<?php foreach ($items as $item): ?>
    <?php
    if (!is_array($item)) {
    	continue;
    }
    $label = (string) ($item["label"] ?? "");
    $value = (string) ($item["value"] ?? "");
    $breakdown = $item["breakdown"] ?? "";
    ?>
    <div class="pw-bui-stat">
        <?php if ($label !== ""): ?>
            <span class="pw-bui-stat__label"><?php echo esc_html($label); ?></span>
        <?php endif; ?>
        <?php if ($value !== ""): ?>
            <span class="pw-bui-stat__value"><?php echo esc_html($value); ?></span>
        <?php endif; ?>
        <?php if ($breakdown !== ""): ?>
            <div class="pw-bui-stat__breakdown"><?php echo wp_kses_post($breakdown); ?></div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
</div>

<?php if (!empty($atts["wrapper_class"])): ?>
</div>
<?php endif; ?>
