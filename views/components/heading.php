<?php
// views/components/heading.php

/**
 * Heading component (h1-h6) — PW Design System.
 *
 * @var array $atts  Heading attributes from ComponentRenderer::heading().
 */

defined("ABSPATH") || exit();

$variant = (string) ($atts["variant"] ?? "");
if ($variant === "eyebrow") {
	$tag = "p";
	$classes = trim(
		"pw-bui-heading pw-bui-heading--eyebrow " . ($atts["class"] ?? ""),
	);
} else {
	$level = max(1, min(6, (int) ($atts["level"] ?? 2)));
	$tag = "h" . $level;
	$classes = implode(
		" ",
		array_filter([
			"pw-bui-heading",
			"pw-bui-heading--" . $level,
			$atts["class"] ?? "",
		]),
	);
}
?>
<?php if (!empty($atts["wrapper_class"])): ?><div class="<?php echo esc_attr($atts["wrapper_class"]); ?>"><?php endif; ?>
<<?php echo $tag; ?> class="<?php echo esc_attr($classes); ?>"><?php echo esc_html(
	$atts["text"] ?? "",
); ?></<?php echo $tag; ?>>
<?php if (!empty($atts["wrapper_class"])): ?></div><?php endif; ?>
