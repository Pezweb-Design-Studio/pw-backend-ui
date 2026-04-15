<?php
// views/layout/page-wrapper.php
// PATCH v1.2.1: soporte tabs_mode en render_page() → pasa mode al componente tabs()

/**
 * Main page wrapper layout — PW Design System.
 *
 * @var array                       $page  Page config array.
 * @var \PW\BackendUI\BackendUI     $bui   BackendUI instance.
 */

defined("ABSPATH") || exit();

$brand = $bui->config("brand");
$has_sidebar = !empty($page["sidebar"]);
$has_sidenav = !empty($page["sidenav"]);
?>


<div id="pw-backend-ui-app" data-pw-theme="dark">

    <?php
// ── HEADER ───────────────────────────────────────────────
?>
    <header class="pw-bui-header">
        <div class="pw-bui-header__inner">

            <?php /* ── LEFT: Logo / Meta ─────────────────────── */ ?>
            <div class="pw-bui-header__meta">
                <div class="pw-bui-logo">
                    <?php
                    $display_name    = $brand["plugin_name"] ?? $brand["name"] ?? "";
                    $display_version = $brand["version"] ?? $bui->config("version") ?? "";
                    ?>
                    <?php if (!empty($display_name)): ?>
                        <span class="pw-bui-logo__name"><?php echo esc_html($display_name); ?></span>
                    <?php endif; ?>
                    <div class="pw-bui-logo__sub">
                        <span class="pw-bui-logo__mark" aria-hidden="true"></span>
                        <?php if (!empty($display_version)): ?>
                            <span class="pw-bui-logo__version">v.<?php echo esc_html($display_version); ?></span>
                        <?php endif; ?>
                        <a href="https://pezweb.com" class="pw-bui-logo__site" target="_blank" rel="noopener">pezweb.com</a>
                    </div>
                </div>
            </div>

            <?php /* ── CENTER: Header Nav (mirrors sidenav items) ─ */ ?>
            <nav class="pw-bui-header__nav" aria-label="<?php esc_attr_e('Navegación principal', 'pw-backend-ui'); ?>">
                <?php
                $header_nav_items = [];
                if (!empty($page["sidenav"]) && is_array($page["sidenav"]) && isset($page["sidenav"]["items"])) {
                    $header_nav_items = $page["sidenav"]["items"];
                } elseif (!empty($page["header_nav"]) && is_array($page["header_nav"])) {
                    $header_nav_items = $page["header_nav"];
                }
                foreach ($header_nav_items as $nav_item):
                    if (isset($nav_item["separator"]) || isset($nav_item["group"])) {
                        continue;
                    }
                    $is_active = !empty($nav_item["active"]);
                    $item_class = "pw-bui-header__nav-item" . ($is_active ? " pw-bui-header__nav-item--active" : "");
                    $tag = !empty($nav_item["href"]) ? "a" : "button";
                    $href_attr = !empty($nav_item["href"]) ? ' href="' . esc_url($nav_item["href"]) . '"' : "";
                    $type_attr = $tag === "button" ? ' type="button"' : "";
                    $data_attr = !empty($nav_item["data"]) ? ' data-pw-sidenav="' . esc_attr($nav_item["data"]) . '"' : "";
                    $aria_attr = $is_active ? ' aria-current="page"' : "";
                    ?>
                    <<?php echo $tag; ?><?php echo $href_attr . $type_attr . $data_attr . $aria_attr; ?> class="<?php echo esc_attr($item_class); ?>">
                        <?php echo esc_html($nav_item["label"]); ?>
                    </<?php echo $tag; ?>>
                <?php endforeach; ?>
            </nav>

            <?php /* ── RIGHT: Action buttons ──────────────────── */ ?>
            <div class="pw-bui-header__actions">
                <?php do_action("pw_bui/header_actions", $page); ?>

                <button
                    type="button"
                    class="pw-bui-btn pw-bui-btn--secondary pw-bui-theme-toggle"
                    aria-label="<?php esc_attr_e('Cambiar tema', 'pw-backend-ui'); ?>"
                    title="<?php esc_attr_e('Cambiar tema claro / oscuro', 'pw-backend-ui'); ?>"
                >
                    <svg class="pw-bui-icon-moon" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M9.598 1.591a.749.749 0 0 1 .785-.175 7.001 7.001 0 1 1-8.967 8.967.75.75 0 0 1 .961-.96 5.5 5.5 0 0 0 7.046-7.046.75.75 0 0 1 .175-.786Z"/>
                    </svg>
                    <svg class="pw-bui-icon-sun" width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm.25-9.25v-1.5a.25.25 0 0 0-.5 0v1.5a.25.25 0 0 0 .5 0Zm0 10v1.5a.25.25 0 0 0-.5 0v-1.5a.25.25 0 0 0 .5 0ZM2.75 8a.25.25 0 0 0 0-.5h-1.5a.25.25 0 0 0 0 .5ZM14 7.75a.25.25 0 0 0 0-.5h-1.5a.25.25 0 0 0 0 .5ZM4.11 4.64a.25.25 0 0 0 .35-.35l-1.06-1.06a.25.25 0 0 0-.35.35Zm7.79 7.79a.25.25 0 0 0 .35-.35l-1.06-1.06a.25.25 0 0 0-.35.35Zm.35-9.21a.25.25 0 0 0-.35-.35L10.83 4.03a.25.25 0 0 0 .35.35Zm-7.79 7.79a.25.25 0 0 0-.35-.35L3.11 11.88a.25.25 0 0 0 .35.35Z"/>
                    </svg>
                </button>
            </div>

        </div>

        <?php /* ── TABS (underline nav, si aplica) ────────────── */ ?>
        <?php if (!empty($page["tabs"])): ?>
            <div class="pw-bui-tabs-nav">
                <?php $bui->ui()->tabs([
                	"tabs" => $page["tabs"],
                	"mode" => $page["tabs_mode"] ?? "js",
                ]); ?>
            </div>
        <?php endif; ?>
    </header>

    <?php
// ── MAIN ───────────────────────────────────────────────────
?>
    <div class="pw-bui-main">

        <?php if (!empty($page["breadcrumbs"])): ?>
            <?php $bui->ui()->breadcrumbs(["items" => $page["breadcrumbs"]]); ?>
        <?php endif; ?>

        <?php if (!empty($page["title"]) && !empty($brand["name"])): ?>
            <div class="pw-bui-page-title">
                <h1 class="pw-bui-page-title__heading">
                    <?php echo esc_html($page["title"]); ?>
                </h1>
                <?php if (!empty($page["description"])): ?>
                    <p class="pw-bui-page-title__desc">
                        <?php echo esc_html($page["description"]); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php elseif (!empty($page["description"])): ?>
            <p class="pw-bui-page-title__desc--standalone">
                <?php echo esc_html($page["description"]); ?>
            </p>
        <?php endif; ?>

        <?php if ($has_sidenav): ?>
            <div class="pw-bui-layout pw-bui-layout--with-sidenav">

                <nav class="pw-bui-sidenav" aria-label="Navegación secundaria">
                    <?php if (is_callable($page["sidenav"])) {
                    	call_user_func($page["sidenav"], $bui);
                    } elseif (
                    	is_array($page["sidenav"]) &&
                    	isset($page["sidenav"]["items"])
                    ) {
                    	$bui->ui()->side_nav([
                    		"items" => $page["sidenav"]["items"],
                    	]);
                    } ?>
                </nav>

                <div class="pw-bui-sidenav-content">
                    <?php if (is_callable($page["content"])) {
                    	call_user_func($page["content"], $bui);
                    } ?>
                </div>

            </div>

        <?php else: ?>
            <div class="pw-bui-layout <?php echo $has_sidebar
            	? "pw-bui-layout--with-sidebar"
            	: ""; ?>">

                <main class="pw-bui-layout__main">
                    <?php if (is_callable($page["content"])) {
                    	call_user_func($page["content"], $bui);
                    } ?>
                </main>

                <?php if ($has_sidebar): ?>
                    <aside class="pw-bui-layout__sidebar">
                        <?php if (!empty($page["sidebar"]["title"])): ?>
                            <p class="pw-bui-sidebar__label">
                                <?php echo esc_html(
                                	$page["sidebar"]["title"],
                                ); ?>
                            </p>
                        <?php endif; ?>
                        <?php if (
                        	is_callable($page["sidebar"]["content"] ?? null)
                        ) {
                        	call_user_func($page["sidebar"]["content"], $bui);
                        } ?>
                    </aside>
                <?php endif; ?>

            </div>
        <?php endif; ?>

    </div>

    <?php
// ── FOOTER ───────────────────────────────────────────────
?>
    <?php if (!empty($page["footer"])): ?>
        <footer class="pw-bui-footer">
            <div>
                <?php if (is_callable($page["footer"]["left"] ?? null)) {
                	call_user_func($page["footer"]["left"], $bui);
                } ?>
            </div>
            <div>
                <?php if (is_callable($page["footer"]["right"] ?? null)) {
                	call_user_func($page["footer"]["right"], $bui);
                } ?>
            </div>
        </footer>
    <?php endif; ?>

</div>
