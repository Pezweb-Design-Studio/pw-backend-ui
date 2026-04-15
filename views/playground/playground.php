<?php
// views/playground/playground.php
// PW UI Playground — showcase de todos los componentes.
// @var \PW\BackendUI\BackendUI $bui

defined("ABSPATH") || exit();
$ui = $bui->ui();

if (!function_exists("pw_pg_section")):
	function pw_pg_section(string $title, string $desc = ""): void
	{
		echo '<div class="pw-bui-pg-section">';
		echo '<h3 class="pw-bui-pg-section__title">' . esc_html($title) . "</h3>";
		if ($desc) {
			echo '<p class="pw-bui-pg-section__desc">' . wp_kses_post($desc) . "</p>";
		}
	}
	function pw_pg_section_end(): void
	{
		echo "</div>";
	}
	function pw_pg_row(string $lbl = ""): void
	{
		if ($lbl) {
			echo '<p class="pw-bui-section-label">' . esc_html($lbl) . "</p>";
		}
		echo '<div class="pw-bui-pg-row">';
	}
	function pw_pg_row_end(): void
	{
		echo "</div>";
	}
endif;

// ── TAB 1: BOTONES & BADGES ──────────────────────────────────────────────────
$ui->tab_panel([
	"slug" => "buttons",
	"active" => true,
	"content" => function () use ($ui) {
		pw_pg_section("Botones — Variantes");
		pw_pg_row();
		foreach (
			["primary", "secondary", "outline", "ghost", "danger", "invisible"]
			as $v
		) {
			$ui->button(["label" => ucfirst($v), "variant" => $v]);
		}
		pw_pg_row_end();
		pw_pg_section_end();

		pw_pg_section("Botones — Tamaños");
		pw_pg_row();
		foreach (
			["sm" => "Small", "md" => "Medium", "lg" => "Large"]
			as $s => $l
		) {
			$ui->button(["label" => $l, "size" => $s]);
		}
		pw_pg_row_end();
		pw_pg_section_end();

		pw_pg_section("Con icono & disabled");
		$chk =
			'<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"/></svg>';
		$plus =
			'<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M7.75 2a.75.75 0 0 1 .75.75V7h4.25a.75.75 0 0 1 0 1.5H8.5v4.25a.75.75 0 0 1-1.5 0V8.5H2.75a.75.75 0 0 1 0-1.5H7V2.75A.75.75 0 0 1 7.75 2Z"/></svg>';
		pw_pg_row();
		$ui->button([
			"label" => "Guardar",
			"variant" => "primary",
			"icon" => $chk,
		]);
		$ui->button([
			"label" => "Agregar",
			"variant" => "outline",
			"icon" => $plus,
		]);
		$ui->button(["label" => "Disabled primary", "disabled" => true]);
		$ui->button([
			"label" => "Disabled danger",
			"variant" => "danger",
			"disabled" => true,
		]);
		pw_pg_row_end();
		pw_pg_section_end();

		pw_pg_section("Badges / Labels");
		pw_pg_row("Tamaño md");
		foreach (
			["default", "primary", "success", "warning", "danger", "info"]
			as $v
		) {
			$ui->badge(["label" => ucfirst($v), "variant" => $v]);
		}
		pw_pg_row_end();
		pw_pg_row("Tamaño sm");
		foreach (["default", "success", "danger", "info"] as $v) {
			$ui->badge([
				"label" => ucfirst($v),
				"variant" => $v,
				"size" => "sm",
			]);
		}
		pw_pg_row_end();
		pw_pg_section_end();
	},
]);

// ── TAB 2: FORMULARIOS ───────────────────────────────────────────────────────
$ui->tab_panel([
	"slug" => "forms",
	"content" => function () use ($ui) {
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">';
		echo "<div>";
		pw_pg_section("Inputs");
		$ui->input([
			"name" => "t1",
			"label" => "Normal",
			"placeholder" => "Escribe algo...",
		]);
		$ui->input([
			"name" => "t2",
			"label" => "Requerido",
			"required" => true,
		]);
		$ui->input([
			"name" => "t3",
			"label" => "Con error",
			"value" => "invalid",
			"error" => "Campo obligatorio.",
		]);
		$ui->input([
			"name" => "t4",
			"label" => "Con ayuda",
			"help" => "Se mostrará en el header.",
		]);
		$ui->input([
			"name" => "t5",
			"label" => "Disabled",
			"value" => "no editable",
			"disabled" => true,
		]);
		pw_pg_section_end();
		pw_pg_section("Tipos especiales");
		$ui->input([
			"name" => "em",
			"label" => "Email",
			"type" => "email",
			"placeholder" => "usuario@ejemplo.com",
		]);
		$ui->input([
			"name" => "nm",
			"label" => "Número",
			"type" => "number",
			"min" => "0",
			"max" => "100",
		]);
		$ui->input([
			"name" => "ur",
			"label" => "URL",
			"type" => "url",
			"placeholder" => "https://",
		]);
		$ui->date_input([
			"name" => "dt",
			"label" => "Fecha",
			"help" => "Formato AAAA-MM-DD",
		]);
		$ui->input([
			"name" => "fl1",
			"label" => "Archivo",
			"type" => "file",
			"help" => "Estilo Work OS (botón + nombre de archivo).",
		]);
		$ui->input([
			"name" => "rg1",
			"label" => "Rango",
			"type" => "range",
			"min" => "0",
			"max" => "100",
			"value" => "40",
		]);
		$ui->input([
			"name" => "cl1",
			"label" => "Color",
			"type" => "color",
			"value" => "#dd0000",
		]);
		pw_pg_section_end();
		echo "</div><div>";
		pw_pg_section("Textarea & Select");
		$ui->textarea([
			"name" => "ta1",
			"label" => "Descripción",
			"placeholder" => "Escribe...",
			"rows" => 3,
		]);
		$ui->textarea([
			"name" => "ta2",
			"label" => "Con error",
			"error" => "No puede estar vacío.",
		]);
		$ui->select([
			"name" => "sl1",
			"label" => "País",
			"options" => ["cl" => "Chile", "ar" => "Argentina", "pe" => "Perú"],
			"help" => "Tu país de origen.",
		]);
		$ui->select([
			"name" => "sl2",
			"label" => "Select con error",
			"options" => ["1h" => "1 hora", "24h" => "24 horas"],
			"error" => "Selecciona una opción.",
		]);
		pw_pg_section_end();
		pw_pg_section("Checkbox & Toggle");
		$ui->checkbox([
			"name" => "c1",
			"label" => "Acepto los términos y condiciones",
		]);
		$ui->checkbox([
			"name" => "c2",
			"label" => "Notificaciones por email",
			"checked" => true,
		]);
		$ui->checkbox([
			"name" => "c3",
			"label" => "Deshabilitado",
			"disabled" => true,
		]);
		$ui->toggle([
			"name" => "tg1",
			"label" => "Modo mantenimiento",
			"help" => "Oculta el sitio al público.",
		]);
		$ui->toggle([
			"name" => "tg2",
			"label" => "Caché activado",
			"checked" => true,
		]);
		$ui->toggle([
			"name" => "tg3",
			"label" => "Deshabilitado",
			"disabled" => true,
		]);
		pw_pg_section_end();
		echo "</div></div>";
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:8px;">';
		echo "<div>";
		pw_pg_section("Radio Group");
		$ui->radio_group([
			"name" => "plan",
			"label" => "Plan de suscripción",
			"value" => "pro",
			"options" => [
				[
					"value" => "free",
					"label" => "Gratis",
					"help" => "Hasta 3 proyectos.",
				],
				[
					"value" => "pro",
					"label" => "Pro",
					"help" => "Proyectos ilimitados.",
				],
				[
					"value" => "ent",
					"label" => "Enterprise",
					"help" => "SLA + soporte.",
					"disabled" => true,
				],
			],
		]);
		pw_pg_section_end();
		echo "</div><div>";
		pw_pg_section("Segmented Control");
		$ui->segmented_control([
			"name" => "vm",
			"label" => "Modo de vista",
			"value" => "grid",
			"options" => [
				["value" => "list", "label" => "Lista"],
				["value" => "grid", "label" => "Cuadrícula"],
				["value" => "map", "label" => "Mapa", "disabled" => true],
			],
		]);
		$ui->segmented_control([
			"name" => "per",
			"label" => "Período",
			"value" => "30d",
			"options" => [
				["value" => "7d", "label" => "7 días"],
				["value" => "30d", "label" => "30 días"],
				["value" => "90d", "label" => "90 días"],
				["value" => "1y", "label" => "1 año", "disabled" => true],
			],
		]);
		pw_pg_section_end();
		echo "</div></div>";
	},
]);

// ── TAB 3: FEEDBACK ──────────────────────────────────────────────────────────
$ui->tab_panel([
	"slug" => "feedback",
	"content" => function () use ($ui) {
		pw_pg_section("Notices / Banners");
		$ui->notice([
			"type" => "info",
			"message" => "Notificación informativa con más contexto.",
		]);
		$ui->notice([
			"type" => "success",
			"message" => "Cambios guardados correctamente.",
		]);
		$ui->notice([
			"type" => "warning",
			"message" => "Algunos campos no se pudieron validar.",
		]);
		$ui->notice([
			"type" => "danger",
			"message" => "Error crítico. Revisa la configuración del servidor.",
		]);
		pw_pg_section_end();
		pw_pg_section("Notices con título & dismissible");
		$ui->notice([
			"type" => "info",
			"title" => "Actualización disponible",
			"message" => "Nueva versión disponible.",
			"dismissible" => true,
		]);
		$ui->notice([
			"type" => "success",
			"title" => "¡Listo!",
			"message" => "El proceso se completó.",
			"dismissible" => true,
		]);
		$ui->notice([
			"type" => "danger",
			"title" => "Permiso denegado",
			"message" => "No tienes permisos.",
			"dismissible" => true,
		]);
		pw_pg_section_end();
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">';
		echo "<div>";
		pw_pg_section("Spinner");
		pw_pg_row();
		$ui->spinner(["size" => "sm"]);
		$ui->spinner(["size" => "md"]);
		$ui->spinner(["size" => "lg"]);
		pw_pg_row_end();
		pw_pg_section_end();
		echo "</div><div>";
		pw_pg_section("Progress Bar");
		$ui->progress_bar([
			"value" => 25,
			"label" => "Cargando archivos",
			"show_value" => true,
		]);
		$ui->progress_bar([
			"value" => 60,
			"variant" => "success",
			"label" => "Tareas completadas",
			"show_value" => true,
		]);
		$ui->progress_bar([
			"value" => 80,
			"variant" => "warning",
			"size" => "md",
			"label" => "Espacio en disco",
			"show_value" => true,
		]);
		$ui->progress_bar([
			"value" => 95,
			"variant" => "danger",
			"size" => "lg",
			"label" => "Uso de memoria",
			"show_value" => true,
		]);
		pw_pg_section_end();
		echo "</div></div>";
		pw_pg_section("Skeleton (loading placeholders)");
		$ui->card([
			"title" => "Cargando...",
			"content" => function () use ($ui) {
				$ui->skeleton(["type" => "title", "width" => "40%"]);
				$ui->skeleton(["type" => "text", "lines" => 3]);
				echo '<div style="display:flex;gap:12px;margin-top:12px;">';
				$ui->skeleton(["type" => "avatar", "width" => "40px"]);
				echo '<div style="flex:1;">';
				$ui->skeleton(["type" => "text", "width" => "60%"]);
				$ui->skeleton(["type" => "text", "width" => "40%"]);
				echo "</div></div>";
			},
		]);
		pw_pg_section_end();
		pw_pg_section("Tooltip");
		pw_pg_row();
		$ui->tooltip([
			"text" => "Guardar todos los cambios",
			"trigger_html" =>
				'<button class="pw-bui-btn pw-bui-btn--primary pw-bui-btn--md">Hover → tooltip arriba</button>',
		]);
		$ui->tooltip([
			"text" => "Eliminar permanentemente",
			"position" => "bottom",
			"trigger_html" =>
				'<button class="pw-bui-btn pw-bui-btn--danger pw-bui-btn--md">Hover → tooltip abajo</button>',
		]);
		pw_pg_row_end();
		pw_pg_section_end();
	},
]);

// ── TAB 4: NAVEGACIÓN ────────────────────────────────────────────────────────
$ui->tab_panel([
	"slug" => "navigation",
	"content" => function () use ($ui) {
		pw_pg_section("Accordion — básico");
		$ui->accordion([
			"items" => [
				[
					"title"   => "Instalación",
					"content" =>
						"Descarga el plugin y cópialo en wp-content/plugins. Actívalo desde el panel de Plugins de WordPress.",
					"open"    => true,
				],
				[
					"title"   => "Configuración inicial",
					"content" =>
						"Ve a Ajustes → PW Config y completa los campos requeridos antes de comenzar a usar la integración.",
				],
				[
					"title"   => "Soporte y documentación",
					"content" =>
						"Consulta la documentación en docs.pezweb.com o abre un ticket de soporte si necesitas ayuda.",
				],
				[
					"title"    => "Item deshabilitado",
					"content"  => "Este panel no puede abrirse.",
					"disabled" => true,
				],
			],
		]);
		pw_pg_section_end();
		pw_pg_section("Accordion — múltiple abierto simultáneo");
		$ui->accordion([
			"allow_multiple" => true,
			"items" => [
				[
					"title"   => "Panel A",
					"content" =>
						"Contenido del panel A. Puede estar abierto a la vez que B.",
					"open"    => true,
				],
				[
					"title"   => "Panel B",
					"content" => "Contenido del panel B.",
					"open"    => true,
				],
				[
					"title"   => "Panel C",
					"content" => "Contenido del panel C. Cerrado por defecto.",
				],
			],
		]);
		pw_pg_section_end();

		pw_pg_section("Breadcrumbs");
		$ui->breadcrumbs([
			"items" => [
				["label" => "Inicio", "href" => "#"],
				["label" => "Configuración", "href" => "#"],
				["label" => "PW Playground"],
			],
		]);
		pw_pg_section_end();

		pw_pg_section("Side Nav (navegación lateral tipo WP Settings)");
		echo '<div style="display:grid;grid-template-columns:200px 1fr;align-items:stretch;border:1px solid var(--pw-color-border-default);">';
		echo '<div style="min-height:0;">';
		$ui->side_nav([
			"items" => [
				["label" => "Conexión", "href" => "#", "active" => true],
				["label" => "Enlazar Proyectos", "href" => "#"],
				["separator" => true],
				["group" => "Avanzado"],
				["label" => "Logs", "href" => "#"],
				["label" => "Webhooks", "href" => "#"],
			],
		]);
		echo "</div>";
		echo '<div class="pw-bui-sidenav-content">';
		$ui->heading(["text" => "Panel de contenido", "level" => 3]);
		$ui->paragraph([
			"text" =>
				'El side_nav funciona como nav lateral. Se activa automáticamente al usar la clave "sidenav" en render_page().',
			"variant" => "muted",
		]);
		echo "</div>";
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section("Tabs anidados");
		$ui->card([
			"title" => "Contenido tabulado",
			"content" => function () use ($ui) {
				$ui->tabs([
					"tabs" => [
						[
							"slug" => "sa",
							"label" => "Resumen",
							"active" => true,
						],
						["slug" => "sb", "label" => "Detalles", "count" => 3],
						["slug" => "sc", "label" => "Historial"],
					],
				]);
				echo '<div style="padding-top:16px;">';
				$ui->tab_panel([
					"slug" => "sa",
					"active" => true,
					"content" => function () use ($ui) {
						$ui->paragraph([
							"text" =>
								"Panel Resumen. Los tabs soportan badge de contador.",
						]);
					},
				]);
				$ui->tab_panel([
					"slug" => "sb",
					"content" => function () use ($ui) {
						$ui->paragraph(["text" => "Panel Detalles (3 items)."]);
					},
				]);
				$ui->tab_panel([
					"slug" => "sc",
					"content" => function () use ($ui) {
						$ui->paragraph(["text" => "Panel Historial."]);
					},
				]);
				echo "</div>";
			},
		]);
		pw_pg_section_end();
		pw_pg_section("Paginación");
		$ui->pagination(["current" => 3, "total" => 12, "base_url" => "#"]);
		echo "<br>";
		$ui->pagination(["current" => 1, "total" => 5, "base_url" => "#"]);
		echo "<br>";
		$ui->pagination(["current" => 100, "total" => 100, "base_url" => "#"]);
		pw_pg_section_end();

		pw_pg_section("List table (markup WP_List_Table)");
		echo '<p style="font-size:12px;color:var(--pw-color-fg-muted);margin:0 0 12px;">' .
			esc_html(
				"Tabla y tablenav con las clases que genera WordPress; los tokens del tema se aplican dentro de #pw-backend-ui-app.",
			) .
			"</p>";
		echo '<div class="tablenav top">';
		echo '<div class="alignleft actions bulkactions">';
		echo '<label for="pg-bulk-action" class="screen-reader-text">' .
			esc_html("Acción en lote") .
			"</label>";
		echo '<select name="action" id="pg-bulk-action">';
		echo '<option value="-1">' . esc_html("Acciones en lote") . "</option>";
		echo '<option value="trash">' . esc_html("Mover a la papelera") . "</option>";
		echo "</select>";
		echo '<input type="submit" class="button action" value="' .
			esc_attr("Aplicar") .
			'" disabled />';
		echo "</div>";
		echo '<p class="search-box">';
		echo '<label for="pg-list-search"><span class="screen-reader-text">' .
			esc_html("Buscar") .
			"</span></label>";
		echo '<input type="search" id="pg-list-search" name="s" value="" placeholder="' .
			esc_attr("Buscar ítems…") .
			'" />';
		echo '<input type="submit" id="pg-search-submit" class="button" value="' .
			esc_attr("Buscar ítems") .
			'" />';
		echo "</p>";
		echo '<br class="clear" />';
		echo "</div>";
		echo '<table class="wp-list-table widefat fixed striped">';
		echo "<thead><tr>";
		echo '<td id="cb" class="manage-column column-cb check-column"><input type="checkbox" disabled /></td>';
		echo '<th scope="col" class="manage-column column-title column-primary sortable desc">';
		echo '<a href="#"><span>' .
			esc_html("Título") .
			"</span><span class=\"sorting-indicators\"><span class=\"sorting-indicator asc\" aria-hidden=\"true\"></span><span class=\"sorting-indicator desc\" aria-hidden=\"true\"></span></span></a>";
		echo "</th>";
		echo '<th scope="col" class="manage-column">' .
			esc_html("Autor") .
			"</th>";
		echo '<th scope="col" class="manage-column sorted asc">';
		echo '<a href="#"><span>' .
			esc_html("Fecha") .
			"</span><span class=\"sorting-indicators\"><span class=\"sorting-indicator asc\" aria-hidden=\"true\"></span><span class=\"sorting-indicator desc\" aria-hidden=\"true\"></span></span></a>";
		echo "</th>";
		echo "</tr></thead><tbody>";
		$pg_rows = [
			[
				"title" => "Entrada de ejemplo",
				"author" => "María",
				"date" => "2026-04-01",
			],
			[
				"title" => "Otro ítem con acciones de fila",
				"author" => "Carlos",
				"date" => "2026-03-28",
			],
			[
				"title" => "Borrador pendiente",
				"author" => "María",
				"date" => "—",
			],
		];
		foreach ($pg_rows as $i => $row) {
			echo "<tr>";
			echo '<th scope="row" class="check-column"><input type="checkbox" disabled /></th>';
			echo '<td class="title column-title has-row-actions column-primary">';
			echo "<strong><a href=\"#\">" . esc_html($row["title"]) . "</a></strong>";
			echo '<div class="row-actions"><span class="edit"><a href="#">' .
				esc_html("Editar") .
				'</a> | </span><span class="trash"><a href="#" class="submitdelete">' .
				esc_html("Papelera") .
				"</a></span></div>";
			echo "</td>";
			echo "<td>" . esc_html($row["author"]) . "</td>";
			echo "<td>" . esc_html($row["date"]) . "</td>";
			echo "</tr>";
		}
		echo "</tbody><tfoot><tr>";
		echo '<td class="manage-column column-cb check-column"><input type="checkbox" disabled /></td>';
		echo "<th class=\"manage-column column-primary\">" .
			esc_html("Título") .
			"</th>";
		echo "<th class=\"manage-column\">" . esc_html("Autor") . "</th>";
		echo "<th class=\"manage-column\">" . esc_html("Fecha") . "</th>";
		echo "</tr></tfoot></table>";
		echo '<div class="tablenav bottom">';
		echo '<div class="tablenav-pages">';
		echo '<span class="displaying-num">' .
			esc_html(sprintf("%d ítems", count($pg_rows))) .
			"</span>";
		echo '<span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>';
		echo '<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>';
		echo '<span class="paging-input"><label for="pg-current-page" class="screen-reader-text">' .
			esc_html("Página actual") .
			'</label><input class="current-page" id="pg-current-page" type="text" name="paged" value="1" size="1" aria-describedby="table-paging" disabled /><span class="tablenav-paging-text"> ' .
			esc_html("de") .
			' <span class="total-pages">1</span></span></span>';
		echo '<span class="tablenav-pages-navspan" aria-hidden="true">›</span>';
		echo '<span class="tablenav-pages-navspan" aria-hidden="true">»</span></span>';
		echo "</div></div>";
		pw_pg_section_end();
	},
]);

// ── TAB 5: TIPOGRAFÍA & LAYOUT ───────────────────────────────────────────────
$ui->tab_panel([
	"slug" => "layout",
	"content" => function () use ($ui) {
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">';
		echo "<div>";
		pw_pg_section("Headings");
		for ($l = 1; $l <= 6; $l++) {
			$ui->heading(["text" => "Heading $l — h$l", "level" => $l]);
		}
		$ui->heading([
			"text" => "Eyebrow — sección (Work OS)",
			"variant" => "eyebrow",
		]);
		$ui->section_label(["text" => "Section label (section_label)"]);
		pw_pg_section_end();
		pw_pg_section("Stats bar & data table");
		$ui->stats_bar([
			"items" => [
				[
					"label" => "Neto",
					"value" => "$120.000",
					"breakdown" =>
						"<span>Subtotal <strong>$100.000</strong></span><span>IVA <strong>$20.000</strong></span>",
				],
				["label" => "Facturas", "value" => "12"],
			],
		]);
		$ui->data_table([
			"headers" => ["Campo", "Valor"],
			"rows" => [
				["Cliente", "Acme SA"],
				["Estado", "Activo"],
			],
		]);
		pw_pg_section_end();
		pw_pg_section("Paragraphs");
		$ui->paragraph([
			"text" => "Default — texto principal con buena legibilidad.",
		]);
		$ui->paragraph([
			"text" => "Muted — texto secundario para descripciones.",
			"variant" => "muted",
		]);
		$ui->paragraph([
			"text" => "Small — etiquetas, hints, notas al pie.",
			"variant" => "small",
		]);
		pw_pg_section_end();
		pw_pg_section("Links");
		pw_pg_row();
		$ui->link(["label" => "Default", "href" => "#"]);
		$ui->link(["label" => "Muted", "href" => "#", "variant" => "muted"]);
		$ui->link(["label" => "Danger", "href" => "#", "variant" => "danger"]);
		$ui->link([
			"label" => "External",
			"href" => "#",
			"target" => "_blank",
		]);
		pw_pg_row_end();
		pw_pg_section_end();
		echo "</div><div>";
		pw_pg_section("Cards");
		$ui->card([
			"title" => "Con header y footer",
			"description" => "Subtítulo descriptivo.",
			"content" => function () use ($ui) {
				$ui->paragraph(["text" => "Contenido con padding estándar."]);
			},
			"footer" => function () use ($ui) {
				$ui->button(["label" => "Acción", "size" => "sm"]);
				$ui->button([
					"label" => "Cancelar",
					"variant" => "ghost",
					"size" => "sm",
				]);
			},
		]);
		echo '<div style="margin-top:12px;">';
		$ui->card([
			"title" => "Card flush (sin padding)",
			"padded" => false,
			"content" => function () {
				foreach (["Ítem uno", "Ítem dos", "Ítem tres"] as $i => $item) {
					$b =
						$i > 0
							? "border-top:1px solid var(--pw-color-border-default);"
							: "";
					echo '<div style="padding:10px 16px;font-size:13px;color:var(--pw-color-fg-default);' .
						$b .
						'">' .
						esc_html($item) .
						"</div>";
				}
			},
		]);
		echo "</div>";
		pw_pg_section_end();
		pw_pg_section("Separator");
		$ui->paragraph(["text" => "Contenido arriba del separador."]);
		$ui->separator();
		$ui->paragraph(["text" => "Contenido debajo del separador."]);
		pw_pg_section_end();
		echo "</div></div>";
	},
]);

// ── TAB 6: CONTENEDORES & ESPACIADO ─────────────────────────────────────────

if (!function_exists("pw_pg_arrow")):
	function pw_pg_arrow(string $dir, int $size = 10): string
	{
		static $paths = [
			"right"        => "M1 5H9 M6 2L9 5L6 8",
			"left"         => "M9 5H1 M4 2L1 5L4 8",
			"up"           => "M5 9V1 M2 4L5 1L8 4",
			"down"         => "M5 1V9 M2 6L5 9L8 6",
			"top-right"    => "M2 8L8 2 M4 2L8 2L8 6",
			"top-left"     => "M8 8L2 2 M6 2L2 2L2 6",
			"bottom-right" => "M2 2L8 8 M4 8L8 8L8 4",
			"bottom-left"  => "M8 2L2 8 M6 8L2 8L2 4",
		];
		$d = $paths[$dir] ?? $paths["right"];
		return sprintf(
			'<svg xmlns="http://www.w3.org/2000/svg" width="%1$d" height="%1$d" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" style="display:inline-block;vertical-align:middle;" aria-hidden="true"><path d="%2$s"/></svg>',
			$size,
			esc_attr($d)
		);
	}
endif;

if (!function_exists("pw_pg_icon")):
	/**
	 * Render a UI icon SVG — same design language as pw_pg_arrow().
	 * 1px stroke, square linecap, miter join, currentColor.
	 */
	function pw_pg_icon(string $name, int $size = 14): string
	{
		static $paths = [
			"close"    => "M2 2L8 8 M8 2L2 8",
			"check"    => "M1 5L3.5 7.5L9 2",
			"plus"     => "M5 1V9 M1 5H9",
			"minus"    => "M2 5H8",
			"trash"    => "M2 3.5H8 M4 3.5V2H6V3.5 M3 3.5V9H7V3.5",
			"download" => "M5 1V7 M3 5L5 7L7 5 M2 9H8",
			"upload"   => "M5 9V3 M3 5L5 3L7 5 M2 1H8",
			"settings" => "M1 3H9 M1 7H9 M3 2V4 M7 6V8",
			"lock"     => "M3 5H7V9H3Z M4 5V3H6V5",
			"filter"   => "M1 2H9L6.5 5V9L3.5 8.5V5Z",
			"sort"     => "M3 1V7 M1 5L3 7L5 5 M7 9V3 M5 5L7 3L9 5",
			"trend-up" => "M1 8L3.5 5.5L6 7L9 2",
			"trend-dn" => "M1 2L3.5 4.5L6 3L9 8",
			"info"     => "M5 1A4 4 0 1 0 5 9A4 4 0 1 0 5 1Z M4.5 3.5H5.5 M5 5V8",
			"copy"     => "M3.5 2H8V7H3.5Z M2 3.5V9H6.5V7",
			"tag"      => "M2 2H5.5L9 5.5L5.5 9L2 5.5Z M3.5 3.5H4",
			"external" => "M4 2H1V9H8V6 M5.5 1H9V4.5 M9 1L4 6",
		];
		$d = $paths[$name] ?? "";
		if (!$d) {
			return "";
		}
		return sprintf(
			'<svg xmlns="http://www.w3.org/2000/svg" width="%1$d" height="%1$d" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" style="display:inline-block;vertical-align:middle;" aria-hidden="true"><path d="%2$s"/></svg>',
			$size,
			esc_attr($d),
		);
	}
endif;

$ui->tab_panel([
	"slug"    => "containers",
	"content" => function () use ($ui) {

		// ── 1. ICON LIBRARY ───────────────────────────────────────────────────
		pw_pg_section(
			"Librería de iconos — flechas",
			"1px stroke, sin redondeo. Hereda color: currentColor. Añadir más íconos aquí conforme crezca el sistema.",
		);
		$arrow_dirs = [
			"right"        => "Derecha",
			"left"         => "Izquierda",
			"up"           => "Arriba",
			"down"         => "Abajo",
			"top-right"    => "Sup. derecha",
			"top-left"     => "Sup. izquierda",
			"bottom-right" => "Inf. derecha",
			"bottom-left"  => "Inf. izquierda",
		];
		pw_pg_row();
		foreach ($arrow_dirs as $dir => $label) {
			echo '<span style="display:inline-flex;flex-direction:column;align-items:center;gap:4px;padding:8px;border:1px solid var(--pw-color-border-default);min-width:64px;">';
			echo '<span style="color:var(--pw-color-fg-default);">' . pw_pg_arrow($dir, 14) . "</span>";
			echo '<span style="font-size:7px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">' .
				esc_html($label) .
				"</span>";
			echo "</span>";
		}
		pw_pg_row_end();
		echo '<p style="font-size:11px;color:var(--pw-color-fg-subtle);margin-top:8px;">Uso: <code style="font-size:10px;color:var(--pw-color-fg-default);">pw_pg_arrow(\'right\', 12)</code> &nbsp;·&nbsp; <code style="font-size:10px;color:var(--pw-color-fg-default);">pw_pg_icon(\'check\', 14)</code></p>';

		$ui_icon_names = [
			"close",
			"check",
			"plus",
			"minus",
			"trash",
			"download",
			"upload",
			"settings",
			"lock",
			"filter",
			"sort",
			"trend-up",
			"trend-dn",
			"info",
			"copy",
			"tag",
			"external",
		];
		pw_pg_row("UI icons");
		foreach ($ui_icon_names as $ic) {
			echo '<span style="display:inline-flex;flex-direction:column;align-items:center;gap:4px;padding:8px;border:1px solid var(--pw-color-border-default);min-width:54px;">';
			echo '<span style="color:var(--pw-color-fg-default);">' . pw_pg_icon($ic, 14) . "</span>";
			echo '<span style="font-size:7px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">' .
				esc_html($ic) .
				"</span>";
			echo "</span>";
		}
		pw_pg_row_end();
		pw_pg_section_end();

		// ── 2. SPACING TOKENS ─────────────────────────────────────────────────
		pw_pg_section(
			"Tokens de espaciado",
			"Escala de 4px. Usar siempre estos tokens — nunca valores arbitrarios.",
		);
		echo '<table class="wp-list-table widefat fixed striped" style="width:auto;max-width:480px;">';
		echo "<thead><tr><th>Token</th><th>Valor</th><th>Uso típico</th></tr></thead><tbody>";
		$spacing_tokens = [
			["--pw-space-1",         "4px",  "Separación entre íconos, gap interno"],
			["--pw-space-2",         "8px",  "Gap entre controles, label a input"],
			["--pw-space-3",         "12px", "Padding lateral de ítems nav"],
			["--pw-space-4",         "16px", "Card padding, form-gap"],
			["--pw-space-5",         "20px", "Espacio entre bloques dentro de card"],
			["--pw-space-6",         "24px", "Content padding, layout-gap"],
			["--pw-space-8",         "32px", "Separación entre secciones de página"],
			["--pw-content-padding", "24px", "Padding del área de contenido principal"],
			["--pw-layout-gap",      "24px", "Gap entre columnas del grid"],
			["--pw-card-padding",    "16px", "Padding interior de cards"],
			["--pw-form-gap",        "16px", "Gap vertical entre campos de formulario"],
		];
		foreach ($spacing_tokens as [$tok, $val, $uso]) {
			echo "<tr>";
			echo '<td><code style="font-size:11px;color:var(--pw-color-fg-default);">' . esc_html($tok) . "</code></td>";
			echo "<td>";
			echo '<span style="display:inline-block;width:' . esc_attr($val) .
				';height:9px;background:var(--pw-color-accent-fg);vertical-align:middle;margin-right:6px;"></span>';
			echo '<span style="font-size:11px;color:var(--pw-color-fg-muted);">' . esc_html($val) . "</span>";
			echo "</td>";
			echo '<td style="font-size:11px;color:var(--pw-color-fg-subtle);">' . esc_html($uso) . "</td>";
			echo "</tr>";
		}
		echo "</tbody></table>";
		pw_pg_section_end();

		// ── 3. SPACING RULES ───────────────────────────────────────────────────
		pw_pg_section("Reglas de espaciado entre elementos");
		echo '<table class="wp-list-table widefat fixed striped" style="width:auto;max-width:580px;">';
		echo "<thead><tr><th>Contexto</th><th>Token</th><th>Valor</th></tr></thead><tbody>";
		$spacing_rules = [
			["Heading " . pw_pg_arrow("down", 9) . " Párrafo",                   "--pw-space-2",    "8px"],
			["Párrafo " . pw_pg_arrow("down", 9) . " Párrafo",                   "--pw-space-2",    "8px"],
			["Imagen " . pw_pg_arrow("down", 9) . " Caption",                    "6px (manual)",   "6px"],
			["Caption " . pw_pg_arrow("down", 9) . " Siguiente párrafo",         "--pw-card-padding", "16px"],
			["Card " . pw_pg_arrow("right", 9) . " Card (gap horizontal)",       "--pw-layout-gap", "24px"],
			["Sección " . pw_pg_arrow("down", 9) . " Sección",                   "--pw-space-8",   "32px"],
			["Label " . pw_pg_arrow("down", 9) . " Control de formulario",        "--pw-space-2",    "8px"],
			["Campo " . pw_pg_arrow("down", 9) . " Campo",                        "--pw-form-gap",  "16px"],
			["Contenedor " . pw_pg_arrow("right", 9) . " Contenedor hermano",    "--pw-layout-gap", "24px"],
		];
		foreach ($spacing_rules as [$ctx, $tok, $val]) {
			echo "<tr>";
			echo '<td style="font-size:11px;">' . $ctx . "</td>";
			echo '<td><code style="font-size:10px;color:var(--pw-color-fg-default);">' . esc_html($tok) . "</code></td>";
			echo '<td style="font-size:11px;color:var(--pw-color-fg-subtle);">' . esc_html($val) . "</td>";
			echo "</tr>";
		}
		echo "</tbody></table>";
		pw_pg_section_end();

		// ── 4. CONTENEDOR BÁSICO + ANIDADO ────────────────────────────────────
		pw_pg_section(
			"Contenedor básico y profundidad anidada",
			"Cada nivel usa un tono más oscuro; referencia para cualquier contenedor del sistema.",
		);
		echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);">';
		$ui->paragraph(["text" => "Nivel 0 — raíz. bg-subtle / border-default."]);
		echo '<div style="margin-top:var(--pw-card-padding);border:1px solid var(--pw-color-border-muted);padding:var(--pw-card-padding);background:var(--pw-color-bg-inset);">';
		$ui->paragraph(["text" => "Nivel 1 — anidado. bg-inset / border-muted.", "variant" => "muted"]);
		echo '<div style="margin-top:var(--pw-card-padding);border:1px solid var(--pw-color-border-muted);padding:var(--pw-card-padding);background:var(--pw-color-bg-emphasis);">';
		$ui->paragraph(["text" => "Nivel 2 — bg-emphasis / border-muted.", "variant" => "muted"]);
		echo '<div style="margin-top:var(--pw-card-padding);border:1px solid var(--pw-color-border-emphasis);padding:var(--pw-card-padding);background:var(--pw-color-bg-overlay);">';
		$ui->paragraph(["text" => "Nivel 3 — hoja. bg-overlay / border-emphasis.", "variant" => "muted"]);
		echo "</div></div></div></div>";
		pw_pg_section_end();

		// ── 5. FULL-BLEED VERTICAL DIVIDER / MENU NAV ─────────────────────────
		pw_pg_section(
			"Línea vertical full-bleed — patrón menu/nav",
			"El sidenav usa únicamente border-right como divisor. Sin contenedor exterior. Aplicable a cualquier layout de nav lateral.",
		);
		echo '<div style="display:grid;grid-template-columns:180px 1fr;align-items:stretch;min-height:160px;border:1px solid var(--pw-color-border-default);">';
		echo '<div style="border-right:1px solid var(--pw-color-border-default);padding:8px 0;">';
		$nav_items = ["Dashboard", "Plugins", "Ajustes", "Usuarios"];
		foreach ($nav_items as $i => $item) {
			$active = $i === 0
				? "background:var(--pw-color-bg-emphasis);color:var(--pw-color-fg-default);"
				: "color:var(--pw-color-fg-muted);";
			echo '<div style="padding:6px 12px;font-size:10px;text-transform:uppercase;letter-spacing:0.06em;cursor:pointer;' .
				$active .
				'">' .
				esc_html($item) .
				"</div>";
		}
		echo "</div>";
		echo '<div style="padding:var(--pw-card-padding);">';
		$ui->heading(["text" => "Contenido del panel", "level" => 4]);
		echo '<div style="margin-top:8px;">';
		$ui->paragraph([
			"text" =>
				"Un único border-right separa nav de contenido. La línea sangra hasta el fondo del grid, sin marcos adicionales.",
			"variant" => "muted",
		]);
		echo "</div></div></div>";
		pw_pg_section_end();

		// ── 6. OFF-CANVAS ─────────────────────────────────────────────────────
		pw_pg_section(
			"Off-canvas — panel deslizante",
			"Panel oculto que entra desde la izquierda con un botón. Base para menús móviles, filtros laterales y drawers.",
		);
		echo '<div id="pw-pg-oc-wrap" style="position:relative;overflow:hidden;border:1px solid var(--pw-color-border-default);min-height:180px;background:var(--pw-color-bg-default);">';
		echo '<div id="pw-pg-oc-panel" style="position:absolute;top:0;left:-220px;width:220px;height:100%;background:var(--pw-color-bg-subtle);border-right:1px solid var(--pw-color-border-default);transition:left 0.2s ease;z-index:5;padding:8px 0;">';
		foreach (["Inicio", "Catálogo", "Pedidos", "Configuración"] as $item) {
			echo '<div style="padding:7px 16px;font-size:10px;text-transform:uppercase;letter-spacing:0.06em;color:var(--pw-color-fg-muted);">' .
				esc_html($item) .
				"</div>";
		}
		echo "</div>";
		echo '<div id="pw-pg-oc-main" style="padding:var(--pw-card-padding);transition:margin-left 0.2s ease;">';
		echo '<button type="button" onclick="(function(){var p=document.getElementById(\'pw-pg-oc-panel\'),m=document.getElementById(\'pw-pg-oc-main\'),o=(p.style.left===\'0px\'||p.style.left===\'0\');p.style.left=o?\'-220px\':\'0px\';m.style.marginLeft=o?\'0\':\'220px\';})()" style="font-family:inherit;font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;padding:0 12px;height:28px;border:1px solid var(--pw-color-border-emphasis);background:var(--pw-color-bg-emphasis);color:var(--pw-color-fg-default);cursor:pointer;">';
		echo pw_pg_arrow("right", 9) . " &nbsp;Toggle panel</button>";
		echo '<div style="margin-top:16px;">';
		$ui->paragraph([
			"text" =>
				"El panel se desliza desde fuera del viewport. Útil para menús móviles, drawers de filtros y configuración contextual.",
			"variant" => "muted",
		]);
		echo "</div></div></div>";
		pw_pg_section_end();

		// ── 7. APP SHELL (HOLY GRAIL) ──────────────────────────────────────────
		pw_pg_section(
			"App shell — header / nav / main / footer",
			"Layout completo de aplicación. La zona central usa grid 3 columnas: nav lateral, contenido principal, sidebar derecho.",
		);
		echo '<div style="border:1px solid var(--pw-color-border-default);display:flex;flex-direction:column;min-height:220px;background:var(--pw-color-bg-default);">';
		echo '<div style="border-bottom:1px solid var(--pw-color-border-default);padding:8px 16px;background:var(--pw-color-bg-inset);font-size:10px;text-transform:uppercase;letter-spacing:0.08em;color:var(--pw-color-fg-subtle);">Header</div>';
		echo '<div style="display:grid;grid-template-columns:140px 1fr 120px;flex:1;min-height:0;align-items:stretch;">';
		echo '<div style="border-right:1px solid var(--pw-color-border-default);padding:8px 0;">';
		foreach (["Sección A", "Sección B", "Sección C"] as $s) {
			echo '<div style="padding:5px 12px;font-size:9px;text-transform:uppercase;letter-spacing:0.06em;color:var(--pw-color-fg-subtle);">' .
				esc_html($s) .
				"</div>";
		}
		echo "</div>";
		echo '<div style="padding:var(--pw-card-padding);">';
		$ui->paragraph(["text" => "Contenido principal. flex:1 llena el espacio disponible entre nav y sidebar."]);
		echo "</div>";
		echo '<div style="border-left:1px solid var(--pw-color-border-default);padding:8px 10px;font-size:9px;color:var(--pw-color-fg-subtle);">';
		$ui->paragraph(["text" => "Sidebar", "variant" => "muted"]);
		echo "</div>";
		echo "</div>";
		echo '<div style="border-top:1px solid var(--pw-color-border-default);padding:6px 16px;background:var(--pw-color-bg-inset);font-size:10px;text-transform:uppercase;letter-spacing:0.08em;color:var(--pw-color-fg-subtle);">Footer</div>';
		echo "</div>";
		pw_pg_section_end();

		// ── 8. SPLIT PANES ────────────────────────────────────────────────────
		pw_pg_section(
			"Split panes — vista maestra / detalle",
			"Dos paneles de igual altura separados por una línea. Patrón lista-detalle, diff viewer, comparativa.",
		);
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;align-items:stretch;border:1px solid var(--pw-color-border-default);min-height:160px;">';
		echo '<div style="border-right:1px solid var(--pw-color-border-default);">';
		echo '<div style="padding:var(--pw-card-padding) var(--pw-card-padding) 0;">';
		$ui->heading(["text" => "Panel izquierdo", "level" => 4]);
		echo "</div>";
		echo '<div style="margin-top:8px;">';
		foreach (["Entrada A", "Entrada B", "Entrada C"] as $e) {
			echo '<div style="padding:6px var(--pw-card-padding);border-bottom:1px solid var(--pw-color-border-muted);font-size:11px;color:var(--pw-color-fg-muted);">' .
				esc_html($e) .
				"</div>";
		}
		echo '<div style="padding:var(--pw-card-padding);"></div>';
		echo "</div></div>";
		echo '<div style="padding:var(--pw-card-padding);">';
		$ui->heading(["text" => "Detalle", "level" => 4]);
		echo '<div style="margin-top:8px;">';
		$ui->paragraph([
			"text" =>
				"Selecciona un ítem para ver el detalle. Los dos paneles comparten altura determinada por el contenido más alto.",
			"variant" => "muted",
		]);
		echo "</div></div></div>";
		pw_pg_section_end();

		// ── 9. GRID 2 COLUMNAS ────────────────────────────────────────────────
		pw_pg_section("Grid 2 columnas (1fr 1fr)", "Gap uniforme var(--pw-layout-gap) = 24px.");
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--pw-layout-gap);">';
		foreach (["Columna A", "Columna B"] as $col) {
			echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);">';
			$ui->heading(["text" => $col, "level" => 4]);
			echo '<div style="margin-top:8px;">';
			$ui->paragraph([
				"text" => "Peso igual. Formularios en dos columnas, comparativas.",
				"variant" => "muted",
			]);
			echo "</div></div>";
		}
		echo "</div>";
		pw_pg_section_end();

		// ── 10. GRID MÉTRICAS 3-col ───────────────────────────────────────────
		pw_pg_section(
			"Grid métricas — 3 columnas",
			"Label " . pw_pg_arrow("down", 9) . " Número " . pw_pg_arrow("down", 9) . " Substats. Esquina decorativa: solo bordes, sin fondo.",
		);
		$metrics_data = [
			["Neto", "$120.000", "Subtotal $100.000 · IVA $20.000"],
			["Activos", "47",       "3 pendientes · 2 vencidos"],
			["Cobertura", "94%",    "Último 30 días"],
		];
		echo '<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:var(--pw-layout-gap);">';
		foreach ($metrics_data as [$lbl, $val, $sub]) {
			echo '<div style="position:relative;border:1px solid var(--pw-color-border-default);background:var(--pw-color-bg-subtle);overflow:hidden;display:flex;flex-direction:column;">';
			echo '<div style="position:absolute;top:0;right:0;width:7px;height:7px;border-left:1px solid var(--pw-color-border-default);border-bottom:1px solid var(--pw-color-border-default);"></div>';
			echo '<div style="padding:8px 12px;font-size:9px;text-transform:uppercase;letter-spacing:0.06em;color:var(--pw-color-fg-subtle);border-bottom:1px solid var(--pw-color-border-muted);">' .
				esc_html($lbl) .
				"</div>";
			echo '<div style="flex:1;display:flex;align-items:center;padding:10px 12px;font-size:22px;font-weight:300;color:var(--pw-color-fg-muted);line-height:1;">' .
				esc_html($val) .
				"</div>";
			echo '<div style="padding:8px 12px;font-size:10px;color:var(--pw-color-fg-subtle);border-top:1px solid var(--pw-color-border-muted);">' .
				esc_html($sub) .
				"</div>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		// ── 11. GRID 4 COLUMNAS ───────────────────────────────────────────────
		pw_pg_section(
			"Grid 4 columnas (repeat(4, 1fr))",
			"Gap uniforme var(--pw-layout-gap). Catálogos, opciones, iconografía.",
		);
		echo '<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:var(--pw-layout-gap);">';
		foreach (range(1, 8) as $n) {
			echo '<div style="position:relative;border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);display:flex;align-items:center;justify-content:center;overflow:hidden;">';
			echo '<div style="position:absolute;top:0;right:0;width:7px;height:7px;border-left:1px solid var(--pw-color-border-default);border-bottom:1px solid var(--pw-color-border-default);"></div>';
			echo '<span style="font-size:10px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">Ítem ' .
				(int) $n .
				"</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		// ── 12. GRID ASIMÉTRICO 2fr 1fr ───────────────────────────────────────
		pw_pg_section(
			"Grid asimétrico (2fr 1fr)",
			"Contenido principal " . pw_pg_arrow("right", 9) . " sidebar. Gap uniforme var(--pw-layout-gap).",
		);
		echo '<div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--pw-layout-gap);">';
		echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);">';
		$ui->heading(["text" => "Área principal (2fr)", "level" => 4]);
		echo '<div style="margin-top:8px;">';
		$ui->paragraph([
			"text" => "Dos tercios del ancho. Contenido principal, formularios, tablas.",
			"variant" => "muted",
		]);
		echo "</div></div>";
		echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-inset);">';
		$ui->heading(["text" => "Sidebar (1fr)", "level" => 4]);
		echo '<div style="margin-top:8px;">';
		$ui->paragraph(["text" => "Filtros, meta, acciones secundarias.", "variant" => "muted"]);
		echo "</div></div></div>";
		pw_pg_section_end();

		// ── 13. GRID IRREGULAR 1fr 2fr 1fr ────────────────────────────────────
		pw_pg_section(
			"Grid irregular (1fr 2fr 1fr)",
			"Centro dominante — editorial, dashboards con foco central.",
		);
		echo '<div style="display:grid;grid-template-columns:1fr 2fr 1fr;gap:var(--pw-layout-gap);">';
		foreach (["Nav / Meta (1fr)", "Contenido central (2fr)", "Acciones (1fr)"] as $col) {
			$bg = strpos($col, "central") !== false ? "var(--pw-color-bg-subtle)" : "var(--pw-color-bg-inset)";
			echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:' .
				esc_attr($bg) .
				';">';
			$ui->paragraph(["text" => $col]);
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		// ── 14. GEOMETRÍA A ────────────────────────────────────────────────────
		pw_pg_section(
			"Geometría A — hero + side + meta/body",
			"grid-template-areas. Hero span 2 cols; side span 2 rows. Gap var(--pw-layout-gap).",
		);
		echo '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;grid-template-rows:120px 80px;gap:var(--pw-layout-gap);grid-template-areas:\'hero hero side\' \'meta body side\';">';
		foreach (
			["hero" => "Hero (2 cols)", "side" => "Side (2 rows)", "meta" => "Meta", "body" => "Body"]
			as $area => $label
		) {
			echo '<div style="grid-area:' .
				esc_attr($area) .
				';border:1px solid var(--pw-color-border-default);background:var(--pw-color-bg-inset);display:flex;align-items:center;justify-content:center;">';
			echo '<span style="font-size:9px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">' .
				esc_html($label) .
				"</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		// ── 15. GEOMETRÍA B ────────────────────────────────────────────────────
		pw_pg_section(
			"Geometría B — banner full-width + main (span) + auxiliares",
			"",
		);
		echo '<div style="display:grid;grid-template-columns:3fr 1fr;grid-template-rows:50px 90px 90px;gap:var(--pw-layout-gap);grid-template-areas:\'banner banner\' \'main aux1\' \'main aux2\';">';
		foreach (
			[
				"banner" => "Banner (full width)",
				"main"   => "Main (2 rows)",
				"aux1"   => "Aux 1",
				"aux2"   => "Aux 2",
			]
			as $area => $label
		) {
			echo '<div style="grid-area:' .
				esc_attr($area) .
				';border:1px solid var(--pw-color-border-default);background:var(--pw-color-bg-inset);display:flex;align-items:center;justify-content:center;">';
			echo '<span style="font-size:9px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">' .
				esc_html($label) .
				"</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		// ── 16. GEOMETRÍA C ────────────────────────────────────────────────────
		pw_pg_section("Geometría C — mosaico editorial 4 zonas", "");
		echo '<div style="display:grid;grid-template-columns:1fr 1fr 2fr;grid-template-rows:80px 120px 80px;gap:var(--pw-layout-gap);grid-template-areas:\'a b feature\' \'c b feature\' \'d d feature\';">';
		foreach (
			[
				"a"       => "A",
				"b"       => "B (2 rows)",
				"feature" => "Feature (3 rows)",
				"c"       => "C",
				"d"       => "D (ancho abajo)",
			]
			as $area => $label
		) {
			echo '<div style="grid-area:' .
				esc_attr($area) .
				';border:1px solid var(--pw-color-border-default);background:var(--pw-color-bg-inset);display:flex;align-items:center;justify-content:center;">';
			echo '<span style="font-size:9px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">' .
				esc_html($label) .
				"</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		// ── 17. GEOMETRÍA D — DASHBOARD ─────────────────────────────────────────
		pw_pg_section(
			"Geometría D — dashboard de 5 zonas",
			"Barra de estado + 2 métricas + tabla + panel lateral.",
		);
		echo '<div style="display:grid;grid-template-columns:1fr 1fr 280px;grid-template-rows:40px minmax(72px,auto) 1fr;gap:var(--pw-layout-gap);grid-template-areas:\'status status aside\' \'m1 m2 aside\' \'table table aside\';min-height:280px;">';
		foreach (
			[
				"status" => "Status bar",
				"m1"     => "Métrica 1",
				"m2"     => "Métrica 2",
				"table"  => "Tabla principal",
				"aside"  => "Panel lateral (span 3 rows)",
			]
			as $area => $label
		) {
			$bg = in_array($area, ["m1", "m2"], true)
				? "var(--pw-color-bg-emphasis)"
				: "var(--pw-color-bg-inset)";
			echo '<div style="grid-area:' .
				esc_attr($area) .
				';border:1px solid var(--pw-color-border-default);background:' .
				esc_attr($bg) .
				';display:flex;align-items:center;justify-content:center;padding:8px;">';
			echo '<span style="font-size:9px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">' .
				esc_html($label) .
				"</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		// ── 18. GRID TABLA IRREGULAR ──────────────────────────────────────────
		pw_pg_section(
			"Grid irregular para tablas",
			"Data grid con CSS grid. Celdas con span. Gap 1px con fondo como separador.",
		);
		$tcols = "2fr 1fr 1fr 80px";
		echo '<div style="display:grid;grid-template-columns:' . esc_attr($tcols) . ';gap:1px;background:var(--pw-color-border-default);">';
		foreach (["Nombre", "Estado", "Fecha", "Acción"] as $h) {
			echo '<div style="background:var(--pw-color-bg-inset);padding:7px 12px;font-size:9px;text-transform:uppercase;letter-spacing:0.08em;color:var(--pw-color-fg-subtle);">' .
				esc_html($h) .
				"</div>";
		}
		$trows = [
			["Entrada de ejemplo", "Publicado",  "2026-04-01", "Ver"],
			["Ítem con título largo aquí", "Borrador", "2026-03-28", "Editar"],
			["Tercera entrada",   "Papelera",   "—",          "—"],
		];
		foreach ($trows as $row) {
			foreach ($row as $cell) {
				echo '<div style="background:var(--pw-color-bg-subtle);padding:7px 12px;font-size:11px;color:var(--pw-color-fg-muted);">' .
					esc_html($cell) .
					"</div>";
			}
		}
		echo '<div style="grid-column:span 3;background:var(--pw-color-bg-emphasis);padding:7px 12px;font-size:10px;color:var(--pw-color-fg-subtle);font-style:italic;">Celda span 3 — nota, total o agrupación de sección</div>';
		echo '<div style="background:var(--pw-color-bg-emphasis);padding:7px 12px;"></div>';
		echo "</div>";
		pw_pg_section_end();

		// ── 19. MASONRY ───────────────────────────────────────────────────────
		pw_pg_section(
			"Masonry — CSS columns",
			"column-count + column-gap. Alturas heterogéneas, flujo natural.",
		);
		echo '<div style="column-count:3;column-gap:var(--pw-layout-gap);">';
		foreach ([100, 60, 140, 80, 120, 50, 90, 110, 70] as $h) {
			echo '<div style="break-inside:avoid;margin-bottom:var(--pw-layout-gap);border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);height:' .
				(int) $h .
				'px;display:flex;align-items:center;">';
			echo '<span style="font-size:9px;color:var(--pw-color-fg-subtle);">h=' . (int) $h . "px</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		// ── 20. CONTENEDOR OVERFLOW / SCROLL ─────────────────────────────────
		pw_pg_section(
			"Contenedor con scroll interno",
			"max-height fijo + overflow-y:scroll. Encabezado sticky dentro del contenedor.",
		);
		echo '<div style="border:1px solid var(--pw-color-border-default);">';
		echo '<div style="position:sticky;top:0;padding:8px 16px;background:var(--pw-color-bg-emphasis);border-bottom:1px solid var(--pw-color-border-default);font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--pw-color-fg-subtle);">Encabezado sticky</div>';
		echo '<div class="pw-bui-scroll" style="max-height:160px;">';
		for ($i = 1; $i <= 10; $i++) {
			$b = $i > 1 ? "border-top:1px solid var(--pw-color-border-muted);" : "";
			echo '<div style="padding:8px 16px;font-size:11px;color:var(--pw-color-fg-muted);' .
				$b .
				'">Fila ' .
				(int) $i .
				" — contenido de fila con altura estándar</div>";
		}
		echo "</div></div>";
		pw_pg_section_end();

		// ── 21. FLOATING / LAYERED PANEL ─────────────────────────────────────
		pw_pg_section(
			"Panel flotante / layered",
			"Posicionamiento absoluto. Base para dropdowns, menus, tooltips ricos y command palettes.",
		);
		echo '<div style="position:relative;border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-default);min-height:140px;">';
		$ui->paragraph(["text" => "Contenido base. El panel flotante se posiciona sobre él."]);
		echo '<div style="position:absolute;top:40px;left:32px;width:200px;border:1px solid var(--pw-color-border-emphasis);background:var(--pw-color-bg-subtle);box-shadow:0 4px 12px rgba(0,0,0,0.4);z-index:1;">';
		echo '<div style="padding:6px 12px;border-bottom:1px solid var(--pw-color-border-muted);font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--pw-color-fg-subtle);">Acciones</div>';
		foreach (["Editar", "Duplicar", "Archivar"] as $action) {
			echo '<div style="padding:6px 12px;font-size:11px;color:var(--pw-color-fg-muted);">' . esc_html($action) . "</div>";
		}
		echo "</div></div>";
		pw_pg_section_end();

		// ── 22. PANEL CON MÉTRICAS Y ACCIONES GRID ───────────────────────────────
		pw_pg_section(
			"Panel con métricas y botones de acción grid",
			"Métricas con botones full-bleed integrados al pie del contenedor. Acciones visualmente unidas — sin separación de interfaz fuerte.",
		);
		echo '<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:var(--pw-layout-gap);">';
		$action_panels = [
			["Ingresos", "$48.200", "Ver detalle", "Exportar", ""],
			["Pedidos", "127", "Procesar", "Archivar", "orange"],
			["Usuarios", "1.340", "Nuevo", "Filtrar", ""],
		];
		foreach ($action_panels as $row) {
			list($label, $value, $act1, $act2, $variant) = $row;
			$btn2_class =
				$variant === "orange"
					? "pw-bui-action-grid pw-bui-action-grid--orange"
					: "pw-bui-action-grid";
			echo '<div style="position:relative;border:1px solid var(--pw-color-border-default);background:var(--pw-color-bg-subtle);overflow:hidden;display:flex;flex-direction:column;">';
			echo '<div style="position:absolute;top:0;right:0;width:7px;height:7px;border-left:1px solid var(--pw-color-border-default);border-bottom:1px solid var(--pw-color-border-default);"></div>';
			echo '<div style="padding:8px 12px;font-size:9px;text-transform:uppercase;letter-spacing:0.06em;color:var(--pw-color-fg-subtle);border-bottom:1px solid var(--pw-color-border-muted);">' .
				esc_html($label) .
				"</div>";
			echo '<div style="flex:1;display:flex;align-items:center;padding:10px 12px;font-size:22px;font-weight:300;color:var(--pw-color-fg-muted);line-height:1;">' .
				esc_html($value) .
				"</div>";
			echo '<div style="display:grid;grid-template-columns:1fr 1fr;border-top:1px solid var(--pw-color-border-default);">';
			echo '<button type="button" class="pw-bui-action-grid">' . esc_html($act1) . "</button>";
			echo '<button type="button" class="' .
				esc_attr($btn2_class) .
				'" style="border-left:1px solid var(--pw-color-border-default);">' .
				esc_html($act2) .
				"</button>";
			echo "</div>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		// ── 23. ACCIONES BADGE INLINE + PANEL ACCIÓN ─────────────────────────────
		pw_pg_section(
			"Acciones tipo badge + panel de acción unificado",
			"Badge-like para acciones de fila (guardar, procesar, marcar). Panel con acción grid al pie — unificados al contenedor.",
		);
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--pw-layout-gap);">';
		echo '<div style="border:1px solid var(--pw-color-border-default);">';
		echo '<div style="padding:7px 12px;font-size:9px;text-transform:uppercase;letter-spacing:0.08em;color:var(--pw-color-fg-subtle);background:var(--pw-color-bg-inset);border-bottom:1px solid var(--pw-color-border-default);">Lote de pedidos</div>';
		$badge_rows = [
			["Pedido #1240", "Pendiente", "Procesar", "orange"],
			["Pedido #1241", "En proceso", "Completar", ""],
			["Pedido #1242", "Completado", "Archivar", ""],
			["Pedido #1243", "En espera", "Cancelar", "danger"],
		];
		foreach ($badge_rows as $br) {
			list($name, $status, $action, $variant) = $br;
			if ($variant === "orange") {
				$act_class = "pw-bui-action pw-bui-action--orange";
			} elseif ($variant === "danger") {
				$act_class = "pw-bui-action pw-bui-action--danger";
			} else {
				$act_class = "pw-bui-action";
			}
			echo '<div style="display:flex;align-items:center;justify-content:space-between;padding:7px 12px;border-bottom:1px solid var(--pw-color-border-muted);">';
			echo '<span style="font-size:11px;color:var(--pw-color-fg-muted);">' . esc_html($name) . "</span>";
			echo '<div style="display:flex;align-items:center;gap:8px;">';
			echo '<span style="font-size:8px;text-transform:uppercase;letter-spacing:0.08em;color:var(--pw-color-fg-subtle);">' .
				esc_html($status) .
				"</span>";
			echo '<button type="button" class="' . esc_attr($act_class) . '">' . esc_html($action) . "</button>";
			echo "</div></div>";
		}
		echo "</div>";
		echo '<div style="border:1px solid var(--pw-color-border-default);display:flex;flex-direction:column;">';
		echo '<div style="padding:7px 12px;font-size:9px;text-transform:uppercase;letter-spacing:0.08em;color:var(--pw-color-fg-subtle);background:var(--pw-color-bg-inset);border-bottom:1px solid var(--pw-color-border-default);">Resumen del lote</div>';
		echo '<div style="padding:var(--pw-card-padding);flex:1;">';
		$ui->paragraph(["text" => "4 ítems en cola. 1 requiere acción inmediata.", "variant" => "muted"]);
		echo '<div style="margin-top:12px;display:flex;flex-direction:column;gap:6px;">';
		foreach (["Pendientes" => "2", "En proceso" => "1", "Completados" => "1"] as $k => $v) {
			echo '<div style="display:flex;justify-content:space-between;font-size:10px;">';
			echo '<span style="color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">' .
				esc_html($k) .
				"</span>";
			echo '<span style="color:var(--pw-color-fg-muted);font-weight:600;">' . esc_html($v) . "</span>";
			echo "</div>";
		}
		echo "</div></div>";
		echo '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;">';
		echo '<button type="button" class="pw-bui-action-grid">Guardar</button>';
		echo '<button type="button" class="pw-bui-action-grid pw-bui-action-grid--orange" style="border-left:1px solid var(--pw-color-border-default);">Procesar</button>';
		echo '<button type="button" class="pw-bui-action-grid" style="border-left:1px solid var(--pw-color-border-default);">Cancelar</button>';
		echo "</div>";
		echo "</div>";
		echo "</div>";
		pw_pg_section_end();

		// ── 24. GEOMETRÍA E — EDITORIAL IRREGULAR + PADDING SIMÉTRICO ────────────
		pw_pg_section(
			"Geometría E — editorial irregular, padding simétrico interno",
			"Asimetría en el grid exterior, simetría estricta dentro de cada celda. Gap uniforme var(--pw-layout-gap). Layout editorial bien comportado.",
		);
		echo '<div style="display:grid;grid-template-columns:2fr 1fr 1fr;grid-template-rows:auto auto 44px;gap:var(--pw-layout-gap);grid-template-areas:\'main main side\' \'main main sub\' \'foot foot foot\';">';
		echo '<div style="grid-area:main;border:1px solid var(--pw-color-border-default);background:var(--pw-color-bg-subtle);display:flex;flex-direction:column;">';
		echo '<div style="padding:var(--pw-card-padding);border-bottom:1px solid var(--pw-color-border-default);">';
		$ui->heading(["text" => "Área principal — 2×2", "level" => 4]);
		echo "</div>";
		echo '<div style="padding:var(--pw-card-padding);flex:1;">';
		$ui->paragraph([
			"text" =>
				"Contenido feature: tabla, formulario extendido o editor. Ocupa el espacio dominante del layout. Padding simétrico en todos sus lados.",
			"variant" => "muted",
		]);
		echo "</div>";
		echo '<button type="button" class="pw-bui-action-grid pw-bui-action-grid--orange">Guardar cambios ' .
			pw_pg_arrow("right", 8) .
			"</button>";
		echo "</div>";
		echo '<div style="grid-area:side;border:1px solid var(--pw-color-border-default);background:var(--pw-color-bg-inset);padding:var(--pw-card-padding);">';
		$ui->heading(["text" => "Panel lateral", "level" => 4]);
		echo '<div style="margin-top:8px;">';
		$ui->paragraph(["text" => "Meta, filtros, acciones secundarias.", "variant" => "muted"]);
		echo "</div></div>";
		echo '<div style="grid-area:sub;border:1px solid var(--pw-color-border-default);background:var(--pw-color-bg-emphasis);padding:var(--pw-card-padding);display:flex;flex-direction:column;justify-content:center;">';
		echo '<div style="font-size:9px;text-transform:uppercase;letter-spacing:0.06em;color:var(--pw-color-fg-subtle);">Estado</div>';
		echo '<div style="font-size:18px;font-weight:300;color:var(--pw-color-fg-muted);margin-top:4px;">Activo</div>';
		echo "</div>";
		echo '<div style="grid-area:foot;border:1px solid var(--pw-color-border-default);background:var(--pw-color-bg-inset);display:flex;align-items:center;justify-content:space-between;padding:0 var(--pw-card-padding);">';
		echo '<span style="font-size:9px;text-transform:uppercase;letter-spacing:0.08em;color:var(--pw-color-fg-subtle);">Barra inferior — paginación · acciones globales</span>';
		echo '<button type="button" class="pw-bui-action">' . pw_pg_arrow("right", 8) . "&nbsp;Siguiente</button>";
		echo "</div>";
		echo "</div>";
		pw_pg_section_end();

		// ── 25. MEDIA PLACEHOLDERS ────────────────────────────────────────────
		pw_pg_section(
			"Media Placeholders",
			"Contenedores para imágenes, video, sliders y avatares: rayado diagonal + variantes de ratio.",
		);
		pw_pg_row("Imagen — ratios");
		echo '<div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:var(--pw-layout-gap);width:100%;">';
		foreach (
			[
				["pw-bui-placeholder--16-9", "16:9"],
				["pw-bui-placeholder--square", "1:1"],
				["pw-bui-placeholder--4-3", "4:3"],
			] as [$cls, $lbl]
		) {
			echo '<div class="pw-bui-placeholder ' . esc_attr($cls) . '">';
			echo '<div class="pw-bui-placeholder__icon">' .
				pw_pg_icon("external", 14) .
				'<span class="pw-bui-placeholder__label">' .
				esc_html($lbl) .
				"</span></div>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_row_end();
		pw_pg_row("Video + thumb + avatar + slider");
		echo '<div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--pw-layout-gap);width:100%;">';
		echo '<div class="pw-bui-placeholder pw-bui-placeholder--16-9 pw-bui-placeholder--video">';
		echo '<div class="pw-bui-placeholder__icon"><span class="pw-bui-placeholder__label">Video</span></div>';
		echo "</div>";
		echo '<div style="display:flex;flex-direction:column;gap:10px;">';
		echo '<div style="display:flex;gap:8px;align-items:center;">';
		echo '<div class="pw-bui-placeholder pw-bui-placeholder--thumb"></div>';
		echo '<div class="pw-bui-placeholder pw-bui-placeholder--thumb"></div>';
		echo '<div class="pw-bui-placeholder pw-bui-placeholder--avatar"></div>';
		echo "</div>";
		echo '<div class="pw-bui-slider-placeholder">';
		echo '<div class="pw-bui-slider-placeholder__nav pw-bui-slider-placeholder__nav--prev">' .
			pw_pg_arrow("left", 8) .
			"</div>";
		echo '<div class="pw-bui-slider-placeholder__nav pw-bui-slider-placeholder__nav--next">' .
			pw_pg_arrow("right", 8) .
			"</div>";
		echo '<div class="pw-bui-slider-placeholder__dots">';
		echo '<div class="pw-bui-slider-placeholder__dot pw-bui-slider-placeholder__dot--active"></div>';
		echo '<div class="pw-bui-slider-placeholder__dot"></div>';
		echo '<div class="pw-bui-slider-placeholder__dot"></div>';
		echo "</div></div></div></div>";
		pw_pg_row_end();
		pw_pg_section_end();

		// ── 26. TERMINAL CONTAINER ────────────────────────────────────────────
		pw_pg_section(
			"Terminal / Console",
			"Contenedor de consola — logs, resultados de proceso, datos estructurados en monospace.",
		);
		pw_pg_row();
		echo '<div class="pw-bui-terminal" style="width:100%;max-width:520px;">';
		echo '<div class="pw-bui-terminal__bar"><span class="pw-bui-terminal__dot"></span><span class="pw-bui-terminal__dot"></span><span class="pw-bui-terminal__dot"></span><span class="pw-bui-terminal__title">pw-ofertas — sync</span></div>';
		echo '<div class="pw-bui-terminal__body">';
		echo '<span class="pw-bui-terminal__line"><span class="pw-bui-terminal__prompt">&gt;</span><span class="pw-bui-terminal__cmd">sync:campaigns --env=prod</span></span>';
		echo '<span class="pw-bui-terminal__line"><span class="pw-bui-terminal__out">Iniciando sincronización...</span></span>';
		echo '<span class="pw-bui-terminal__line"><span class="pw-bui-terminal__key">campaigns  </span><span class="pw-bui-terminal__ok">✓ 12 activas</span></span>';
		echo '<span class="pw-bui-terminal__line"><span class="pw-bui-terminal__key">cache      </span><span class="pw-bui-terminal__warn">⚠ expirado — reconstruyendo</span></span>';
		echo '<span class="pw-bui-terminal__line"><span class="pw-bui-terminal__key">index      </span><span class="pw-bui-terminal__ok">✓ reconstruido en 84ms</span></span>';
		echo '<span class="pw-bui-terminal__line"><span class="pw-bui-terminal__dim">——————————————————————————————</span></span>';
		echo '<span class="pw-bui-terminal__line"><span class="pw-bui-terminal__out">Completado en 1.2s</span><span class="pw-bui-terminal__cursor"></span></span>';
		echo "</div></div>";
		pw_pg_row_end();
		pw_pg_section_end();

		// ── 27. REPEATER TABLE ────────────────────────────────────────────────
		pw_pg_section(
			"Repeater — tabla de entrada de datos",
			"Para listas editables: condiciones, metadatos, campos clave-valor.",
		);
		pw_pg_row("key → value + acción");
		echo '<div class="pw-bui-repeater pw-bui-repeater--kv-act" style="width:100%;">';
		echo '<div class="pw-bui-repeater__head"><div class="pw-bui-repeater__head-cell">Clave</div><div class="pw-bui-repeater__head-cell">Valor</div><div class="pw-bui-repeater__head-cell"></div></div>';
		foreach ([["min_qty", "3"], ["category_id", "ropa"], ["user_role", "subscriber"]] as [$k, $v]) {
			echo '<div class="pw-bui-repeater__row">';
			echo '<div class="pw-bui-repeater__cell" style="color:var(--pw-color-fg-muted);">' . esc_html($k) . "</div>";
			echo '<div class="pw-bui-repeater__cell">' . esc_html($v) . "</div>";
			echo '<div class="pw-bui-repeater__cell pw-bui-repeater__cell--actions"><button type="button" class="pw-bui-action pw-bui-action--muted" style="padding:0 5px;height:18px;">' .
				pw_pg_icon("trash", 8) .
				"</button></div>";
			echo "</div>";
		}
		echo '<div class="pw-bui-repeater__footer"><button type="button" class="pw-bui-repeater__add">' .
			pw_pg_icon("plus", 8) .
			" Añadir fila</button></div>";
		echo "</div>";
		pw_pg_row_end();
		pw_pg_section_end();

		// ── 28. PANEL GRID ────────────────────────────────────────────────────
		pw_pg_section(
			"Panel Grid",
			"Contenedor CSS Grid irregular con presets de layout. Ideal para dashboards y vistas de detalle.",
		);

		echo '<div style="display:flex;flex-direction:column;gap:20px;">';

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Layout 2-1-1 (detail + two side cells)</p>';
		echo '<div class="pw-bui-panel-grid pw-bui-panel-grid--2-1-1">';
		echo '<div class="pw-bui-panel-grid__cell">';
		echo '<p class="pw-bui-section-label">Main Info</p>';
		echo '<p class="pw-bui-paragraph">Celda principal con más espacio para contenido de detalle. Puede contener formularios, listas o texto largo.</p>';
		echo "</div>";
		echo '<div class="pw-bui-panel-grid__cell">';
		echo '<p class="pw-bui-section-label">Metric A</p>';
		echo '<p style="font-size:24px;font-weight:700;color:var(--pw-color-fg-default);">1,284</p>';
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);">últimas 24h</p>';
		echo "</div>";
		echo '<div class="pw-bui-panel-grid__cell">';
		echo '<p class="pw-bui-section-label">Metric B</p>';
		echo '<p style="font-size:24px;font-weight:700;color:var(--pw-color-fg-default);">94.3%</p>';
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);">eficiencia</p>';
		echo "</div>";
		echo "</div>";
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Layout 1-1-1 (three equal columns)</p>';
		echo '<div class="pw-bui-panel-grid pw-bui-panel-grid--3">';
		foreach (["Alpha", "Beta", "Gamma"] as $label) {
			echo '<div class="pw-bui-panel-grid__cell">';
			echo '<p class="pw-bui-section-label">' . esc_html($label) . "</p>";
			echo '<p class="pw-bui-paragraph" style="margin:0;">Contenido de celda uniforme. Los tres paneles comparten el mismo ancho y padding.</p>';
			echo "</div>";
		}
		echo "</div>";
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Layout 1-2-1 (narrow — wide — narrow)</p>';
		echo '<div class="pw-bui-panel-grid pw-bui-panel-grid--1-2-1">';
		echo '<div class="pw-bui-panel-grid__cell">';
		echo '<p class="pw-bui-section-label">Filtros</p>';
		echo '<p class="pw-bui-paragraph" style="margin:0;">Panel estrecho lateral izquierdo.</p>';
		echo "</div>";
		echo '<div class="pw-bui-panel-grid__cell">';
		echo '<p class="pw-bui-section-label">Contenido principal</p>';
		echo '<p class="pw-bui-paragraph" style="margin:0;">Celda central ampliada. Recibe el doble de espacio que las columnas laterales. Ideal para tablas o editores.</p>';
		echo "</div>";
		echo '<div class="pw-bui-panel-grid__cell">';
		echo '<p class="pw-bui-section-label">Acciones</p>';
		echo '<p class="pw-bui-paragraph" style="margin:0;">Panel estrecho lateral derecho.</p>';
		echo "</div>";
		echo "</div>";
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Layout 2-1 (two columns)</p>';
		echo '<div class="pw-bui-panel-grid pw-bui-panel-grid--2-1">';
		echo '<div class="pw-bui-panel-grid__cell">';
		echo '<p class="pw-bui-section-label">Columna principal</p>';
		echo '<p class="pw-bui-paragraph" style="margin:0;">Ocupa dos tercios del ancho disponible.</p>';
		echo "</div>";
		echo '<div class="pw-bui-panel-grid__cell">';
		echo '<p class="pw-bui-section-label">Columna lateral</p>';
		echo '<p class="pw-bui-paragraph" style="margin:0;">Un tercio del ancho.</p>';
		echo "</div>";
		echo "</div>";
		echo "</div>";

		echo "</div>";

		pw_pg_section_end();

		// ── 29. ACTION PANEL + BADGE VARIANTS ─────────────────────────────────
		pw_pg_section(
			"Action Panel & Badge Variants",
			"Panel estructurado para grupos de acciones con header, body y footer opcionales. Incluye los nuevos tintes de badge.",
		);

		echo '<div style="display:flex;flex-direction:column;gap:24px;">';

		echo "<div>";
		echo '<p class="pw-bui-section-label" style="margin-bottom:10px;">Badge variants</p>';
		echo '<div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">';
		$badges = [
			["label" => "default",  "class" => ""],
			["label" => "orange",   "class" => " pw-bui-badge--orange"],
			["label" => "warning",  "class" => " pw-bui-badge--warning"],
			["label" => "success",  "class" => " pw-bui-badge--success"],
			["label" => "info",     "class" => " pw-bui-badge--info"],
			["label" => "danger",   "class" => " pw-bui-badge--danger"],
			["label" => "muted",    "class" => " pw-bui-badge--muted"],
		];
		foreach ($badges as $b) {
			echo '<span class="pw-bui-badge' . esc_attr($b["class"]) . '">' . esc_html($b["label"]) . "</span>";
		}
		echo "</div>";
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Default action panel</p>';
		echo '<div class="pw-bui-action-panel">';
		echo '<div class="pw-bui-action-panel__header">';
		echo '<span class="pw-bui-badge pw-bui-badge--info">Info</span>';
		echo '<p style="margin:0;font-size:10px;font-weight:500;color:var(--pw-color-fg);">Título del panel</p>';
		echo "</div>";
		echo '<div class="pw-bui-action-panel__body">';
		echo '<p class="pw-bui-paragraph" style="margin:0;">Contenido principal del action panel. Puede incluir texto descriptivo, formularios inline o cualquier componente del sistema.</p>';
		echo "</div>";
		echo '<div class="pw-bui-action-panel__footer">';
		echo '<button type="button" class="pw-bui-btn pw-bui-btn--primary">Confirmar</button>';
		echo '<button type="button" class="pw-bui-btn pw-bui-btn--ghost">Cancelar</button>';
		echo "</div>";
		echo "</div>";
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Variant --success</p>';
		echo '<div class="pw-bui-action-panel pw-bui-action-panel--success">';
		echo '<div class="pw-bui-action-panel__header">';
		echo '<span class="pw-bui-badge pw-bui-badge--success">Activo</span>';
		echo '<p style="margin:0;font-size:10px;font-weight:500;color:var(--pw-color-fg);">Campaña publicada</p>';
		echo "</div>";
		echo '<div class="pw-bui-action-panel__body">';
		echo '<p class="pw-bui-paragraph" style="margin:0;">La campaña está activa y procesando pedidos. Puedes pausarla en cualquier momento sin perder la configuración.</p>';
		echo "</div>";
		echo "</div>";
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Variant --warning</p>';
		echo '<div class="pw-bui-action-panel pw-bui-action-panel--warning">';
		echo '<div class="pw-bui-action-panel__header">';
		echo '<span class="pw-bui-badge pw-bui-badge--warning">Atención</span>';
		echo '<p style="margin:0;font-size:10px;font-weight:500;color:var(--pw-color-fg);">Stock bajo</p>';
		echo "</div>";
		echo '<div class="pw-bui-action-panel__body">';
		echo '<p class="pw-bui-paragraph" style="margin:0;">Quedan menos de 10 unidades en inventario. Considera aumentar el stock o ajustar la condición de liquidación.</p>';
		echo "</div>";
		echo '<div class="pw-bui-action-panel__footer">';
		echo '<button type="button" class="pw-bui-btn pw-bui-btn--secondary">Ver inventario</button>';
		echo "</div>";
		echo "</div>";
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Variant --muted (compact, no body)</p>';
		echo '<div class="pw-bui-action-panel pw-bui-action-panel--muted">';
		echo '<div class="pw-bui-action-panel__header">';
		echo '<span class="pw-bui-badge pw-bui-badge--muted">Inactivo</span>';
		echo '<p style="margin:0;font-size:10px;font-weight:500;color:var(--pw-color-fg-muted);">Sin actividad reciente en este bloque.</p>';
		echo "</div>";
		echo "</div>";
		echo "</div>";

		echo "</div>";

		pw_pg_section_end();

		// ── 30. SMART SLIDERS ───────────────────────────────────────────────────
		pw_pg_section(
			"Smart Sliders",
			"Control de rango con track, fill, thumb y etiquetas de valor. Variantes de color según contexto semántico.",
		);

		echo '<div style="display:flex;flex-direction:column;gap:20px;max-width:480px;">';

		echo '<div class="pw-bui-smart-slider">';
		echo '<div class="pw-bui-smart-slider__header">';
		echo '<span class="pw-bui-smart-slider__label">Descuento máximo</span>';
		echo '<span class="pw-bui-smart-slider__value">60%</span>';
		echo "</div>";
		echo '<div class="pw-bui-smart-slider__track" style="--slider-fill:60%;">';
		echo '<div class="pw-bui-smart-slider__fill"></div>';
		echo '<div class="pw-bui-smart-slider__thumb"></div>';
		echo '<div class="pw-bui-smart-slider__steps">';
		for ($i = 0; $i <= 10; $i++) {
			echo '<span class="pw-bui-smart-slider__step"></span>';
		}
		echo "</div>";
		echo "</div>";
		echo '<div class="pw-bui-smart-slider__footer">';
		echo '<span class="pw-bui-smart-slider__min">0%</span>';
		echo '<span class="pw-bui-smart-slider__max">100%</span>';
		echo "</div>";
		echo "</div>";

		echo '<div class="pw-bui-smart-slider pw-bui-smart-slider--success">';
		echo '<div class="pw-bui-smart-slider__header">';
		echo '<span class="pw-bui-smart-slider__label">Umbral de conversión</span>';
		echo '<span class="pw-bui-smart-slider__value">82%</span>';
		echo "</div>";
		echo '<div class="pw-bui-smart-slider__track" style="--slider-fill:82%;">';
		echo '<div class="pw-bui-smart-slider__fill"></div>';
		echo '<div class="pw-bui-smart-slider__thumb"></div>';
		echo "</div>";
		echo '<div class="pw-bui-smart-slider__footer">';
		echo '<span class="pw-bui-smart-slider__min">0</span>';
		echo '<span class="pw-bui-smart-slider__max">100</span>';
		echo "</div>";
		echo "</div>";

		echo '<div class="pw-bui-smart-slider pw-bui-smart-slider--warning">';
		echo '<div class="pw-bui-smart-slider__header">';
		echo '<span class="pw-bui-smart-slider__label">Prioridad de campaña</span>';
		echo '<span class="pw-bui-smart-slider__value">35 / 100</span>';
		echo "</div>";
		echo '<div class="pw-bui-smart-slider__track" style="--slider-fill:35%;">';
		echo '<div class="pw-bui-smart-slider__fill"></div>';
		echo '<div class="pw-bui-smart-slider__thumb"></div>';
		echo '<div class="pw-bui-smart-slider__steps">';
		for ($i = 0; $i <= 4; $i++) {
			echo '<span class="pw-bui-smart-slider__step"></span>';
		}
		echo "</div>";
		echo "</div>";
		echo '<div class="pw-bui-smart-slider__footer">';
		echo '<span class="pw-bui-smart-slider__min">0</span>';
		echo '<span class="pw-bui-smart-slider__max">100</span>';
		echo "</div>";
		echo "</div>";

		echo '<div class="pw-bui-smart-slider pw-bui-smart-slider--danger">';
		echo '<div class="pw-bui-smart-slider__header">';
		echo '<span class="pw-bui-smart-slider__label">Stock mínimo (alerta)</span>';
		echo '<span class="pw-bui-smart-slider__value">18 uds.</span>';
		echo "</div>";
		echo '<div class="pw-bui-smart-slider__track" style="--slider-fill:18%;">';
		echo '<div class="pw-bui-smart-slider__fill"></div>';
		echo '<div class="pw-bui-smart-slider__thumb"></div>';
		echo "</div>";
		echo '<div class="pw-bui-smart-slider__footer">';
		echo '<span class="pw-bui-smart-slider__min">0</span>';
		echo '<span class="pw-bui-smart-slider__max">100</span>';
		echo "</div>";
		echo "</div>";

		echo "</div>";

		pw_pg_section_end();

		// ── 31. MODAL ───────────────────────────────────────────────────────────
		pw_pg_section(
			"Modal",
			"Diálogo superpuesto con variantes de posición: centrado, fullscreen, drawers top/bottom/left/right, y contained dentro de un contenedor posicionado.",
		);

		echo '<div style="display:flex;flex-direction:column;gap:24px;">';

		$render_modal = function (string $title, string $body_text, string $extra_class = "", string $extra_style = "") {
			$classes = "pw-bui-modal" . ($extra_class !== "" ? " " . $extra_class : "");
			echo '<div class="' . esc_attr($classes) . '"' . ($extra_style !== "" ? ' style="' . esc_attr($extra_style) . '"' : "") . ">";
			echo '<div class="pw-bui-modal__header">';
			echo '<p class="pw-bui-modal__title">' . esc_html($title) . "</p>";
			echo '<button type="button" class="pw-bui-modal__close" aria-label="Cerrar">✕</button>';
			echo "</div>";
			echo '<div class="pw-bui-modal__body">';
			echo '<p class="pw-bui-paragraph" style="margin:0;">' . esc_html($body_text) . "</p>";
			echo "</div>";
			echo '<div class="pw-bui-modal__footer">';
			echo '<button type="button" class="pw-bui-btn pw-bui-btn--ghost">Cancelar</button>';
			echo '<button type="button" class="pw-bui-btn pw-bui-btn--primary">Confirmar</button>';
			echo "</div>";
			echo "</div>";
		};

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Centered (default)</p>';
		$render_modal(
			"Confirmar acción",
			"Esta acción no se puede deshacer. ¿Deseas continuar con el proceso de eliminación del recurso seleccionado?",
		);
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Contained — vive dentro de un contenedor relativo</p>';
		echo '<div class="pw-bui-modal--contained-wrap" style="height:200px;border:1px solid var(--pw-color-border-default);">';
		$render_modal(
			"Modal contenido",
			"Aparece centrado dentro del contenedor padre, no en el viewport.",
			"pw-bui-modal--contained",
		);
		echo "</div>";
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Top drawer (preview in-flow)</p>';
		$render_modal(
			"Notificación global",
			"Aparece en el borde superior. Útil para alertas o confirmaciones de acción rápida.",
			"",
			"position:relative;width:100%;max-width:100%;max-height:none;border-left:none;border-right:none;border-top:none;",
		);
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Bottom drawer (preview in-flow)</p>';
		$render_modal(
			"Acciones de selección",
			"Muestra opciones contextuales ancladas al borde inferior de la pantalla.",
			"",
			"position:relative;width:100%;max-width:100%;max-height:none;border-left:none;border-right:none;border-bottom:none;",
		);
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Right panel</p>';
		echo '<div style="display:flex;gap:0;border:1px solid var(--pw-color-border-default);height:180px;">';
		echo '<div style="flex:1;padding:16px;background:var(--pw-color-bg-default);display:flex;align-items:center;justify-content:center;">';
		echo '<p class="pw-bui-paragraph" style="margin:0;color:var(--pw-color-fg-subtle);font-size:11px;">Contenido principal</p>';
		echo "</div>";
		$render_modal(
			"Panel derecho",
			"Sidebar deslizable desde la derecha. Útil para configuración detallada o vista de detalle.",
			"",
			"position:relative;width:280px;max-width:280px;height:100%;max-height:100%;border-top:none;border-right:none;border-bottom:none;",
		);
		echo "</div>";
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Left panel</p>';
		echo '<div style="display:flex;gap:0;border:1px solid var(--pw-color-border-default);height:180px;">';
		$render_modal(
			"Panel izquierdo",
			"Navegación o filtros deslizables desde la izquierda.",
			"",
			"position:relative;width:280px;max-width:280px;height:100%;max-height:100%;border-top:none;border-left:none;border-bottom:none;",
		);
		echo '<div style="flex:1;padding:16px;background:var(--pw-color-bg-default);display:flex;align-items:center;justify-content:center;">';
		echo '<p class="pw-bui-paragraph" style="margin:0;color:var(--pw-color-fg-subtle);font-size:11px;">Contenido principal</p>';
		echo "</div>";
		echo "</div>";
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-muted);margin-bottom:8px;">Fullscreen — .pw-bui-modal--fullscreen</p>';
		echo '<div class="pw-bui-modal" style="width:100%;max-width:100%;">';
		echo '<div class="pw-bui-modal__header" style="background:var(--pw-color-bg-inset);">';
		echo '<p class="pw-bui-modal__title">Editor de campaña — pantalla completa</p>';
		echo '<button type="button" class="pw-bui-modal__close" aria-label="Cerrar">✕</button>';
		echo "</div>";
		echo '<div class="pw-bui-modal__body" style="min-height:80px;">';
		echo '<p class="pw-bui-paragraph" style="margin:0;color:var(--pw-color-fg-subtle);">Ocupa 100vw × 100vh. Ideal para editores de contenido o vistas de gestión complejas.</p>';
		echo "</div>";
		echo '<div class="pw-bui-modal__footer">';
		echo '<button type="button" class="pw-bui-btn pw-bui-btn--ghost">Descartar</button>';
		echo '<button type="button" class="pw-bui-btn pw-bui-btn--primary">Guardar cambios</button>';
		echo "</div>";
		echo "</div>";
		echo "</div>";

		echo "</div>";

		pw_pg_section_end();
	},
]);
