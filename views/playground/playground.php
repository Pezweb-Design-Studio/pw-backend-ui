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
			echo '<p class="pw-bui-pg-section__desc">' . esc_html($desc) . "</p>";
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
		echo '<div style="display:grid;grid-template-columns:200px 1fr;border:1px solid var(--pw-color-border-default);border-radius:2px;overflow:hidden;">';
		echo '<nav class="pw-bui-sidenav" style="min-height:auto;position:static;border-right:none;">';
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
		echo "</nav>";
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
$ui->tab_panel([
	"slug" => "containers",
	"content" => function () use ($ui) {
		pw_pg_section(
			"Tokens de espaciado",
			"Escala de 4px. Usar siempre estos tokens para gaps, padding y margins entre elementos.",
		);
		echo '<table class="wp-list-table widefat fixed striped" style="width:auto;max-width:480px;">';
		echo "<thead><tr><th>Token</th><th>Valor</th><th>Uso típico</th></tr></thead><tbody>";
		$spacing = [
			["--pw-space-1", "4px", "Gaps internos, íconos"],
			["--pw-space-2", "8px", "Gap entre controles, row-actions"],
			["--pw-space-3", "12px", "Padding lateral de ítems de nav"],
			["--pw-space-4", "16px", "Card padding, form-gap"],
			["--pw-space-5", "20px", "Margin entre secciones dentro de un card"],
			["--pw-space-6", "24px", "Content padding, layout-gap"],
			["--pw-space-7", "28px", "Espacio entre bloques mayores"],
			["--pw-space-8", "32px", "Separación entre secciones de página"],
			["--pw-content-padding", "24px", "Padding del área de contenido principal"],
			["--pw-layout-gap", "24px", "Gap entre columnas del layout grid"],
			["--pw-card-padding", "16px", "Padding interior de cards"],
			["--pw-form-gap", "16px", "Gap vertical entre campos de formulario"],
		];
		foreach ($spacing as [$token, $val, $uso]) {
			echo "<tr>";
			echo '<td><code style="font-size:11px;color:var(--pw-color-fg-default);">' .
				esc_html($token) .
				"</code></td>";
			echo "<td>";
			echo '<span style="display:inline-block;width:' .
				esc_attr($val) .
				';height:10px;background:var(--pw-color-accent-fg);vertical-align:middle;margin-right:6px;"></span>';
			echo '<span style="font-size:11px;color:var(--pw-color-fg-muted);">' .
				esc_html($val) .
				"</span>";
			echo "</td>";
			echo '<td style="font-size:11px;color:var(--pw-color-fg-subtle);">' .
				esc_html($uso) .
				"</td>";
			echo "</tr>";
		}
		echo "</tbody></table>";
		pw_pg_section_end();

		pw_pg_section(
			"Aire entre elementos",
			"Reglas de espaciado recomendadas entre componentes tipográficos y contenedores.",
		);
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--pw-layout-gap);">';

		echo "<div>";
		echo '<p style="font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;color:var(--pw-color-fg-muted);margin:0 0 12px;">Título → párrafo → título</p>';
		$ui->heading(["text" => "Heading nivel 2", "level" => 2]);
		echo '<div style="margin-top:8px;">';
		$ui->paragraph([
			"text" =>
				"Párrafo que sigue a un heading. El margen entre heading y párrafo es 8px (var(--pw-space-2)).",
			"variant" => "muted",
		]);
		echo "</div>";
		echo '<div style="margin-top:24px;">';
		$ui->heading(["text" => "Siguiente bloque", "level" => 2]);
		echo "</div>";
		echo '<div style="margin-top:8px;">';
		$ui->paragraph([
			"text" =>
				"El espacio entre secciones de contenido es 24px (var(--pw-space-6) / --pw-content-padding).",
			"variant" => "muted",
		]);
		echo "</div>";
		echo "</div>";

		echo "<div>";
		echo '<p style="font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;color:var(--pw-color-fg-muted);margin:0 0 12px;">Imagen → caption → contenido</p>';
		echo '<div style="width:100%;height:80px;background:var(--pw-color-bg-emphasis);border:1px solid var(--pw-color-border-emphasis);display:flex;align-items:center;justify-content:center;">';
		echo '<span style="font-size:10px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">Imagen / Media</span>';
		echo "</div>";
		echo '<p style="font-size:11px;color:var(--pw-color-fg-subtle);margin:6px 0 0;">Caption: 6px arriba de la imagen (var(--pw-space-1) + 2px).</p>';
		echo '<div style="margin-top:16px;">';
		$ui->paragraph([
			"text" => "Párrafo que sigue al caption. Espacio: 16px (var(--pw-card-padding)).",
			"variant" => "muted",
		]);
		echo "</div>";
		echo "</div>";

		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Contenedor básico",
			"Un div con padding estándar y borde. Base de todos los contenedores del sistema.",
		);
		echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);">';
		$ui->paragraph([
			"text" =>
				"Contenedor con padding var(--pw-card-padding) = 16px y borde var(--pw-color-border-default).",
		]);
		echo "</div>";
		echo '<div style="margin-top:8px;border-left:2px solid var(--pw-color-accent-fg);padding:var(--pw-card-padding);background:var(--pw-color-bg-inset);">';
		$ui->paragraph([
			"text" =>
				"Variante: border-left de acento. Útil para callouts, advertencias o contexto secundario.",
			"variant" => "muted",
		]);
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Grid 2 columnas (1fr 1fr)",
			"Gap = var(--pw-layout-gap) = 24px. Usar para contenido de igual peso.",
		);
		echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--pw-layout-gap);">';
		foreach (["Columna A", "Columna B"] as $col) {
			echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);">';
			$ui->heading(["text" => $col, "level" => 4]);
			echo '<div style="margin-top:8px;">';
			$ui->paragraph([
				"text" => "Contenido de $col. Cada columna ocupa el mismo ancho.",
				"variant" => "muted",
			]);
			echo "</div></div>";
		}
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Grid 3 columnas (1fr 1fr 1fr)",
			"Gap = var(--pw-layout-gap). Útil para métricas, stats o cards de tamaño uniforme.",
		);
		echo '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:var(--pw-layout-gap);">';
		foreach (["Métrica A", "Métrica B", "Métrica C"] as $col) {
			echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);text-align:center;">';
			echo '<div style="font-size:24px;font-weight:300;color:var(--pw-color-fg-muted);line-height:1;">—</div>';
			echo '<div style="font-size:9px;text-transform:uppercase;letter-spacing:0.06em;color:var(--pw-color-fg-subtle);margin-top:4px;">' .
				esc_html($col) .
				"</div>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Grid asimétrico (2fr 1fr)",
			"Contenido principal ancho + sidebar angosto. Gap = var(--pw-layout-gap).",
		);
		echo '<div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--pw-layout-gap);">';
		echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);">';
		$ui->heading(["text" => "Área principal (2fr)", "level" => 4]);
		echo '<div style="margin-top:8px;">';
		$ui->paragraph([
			"text" => "El área de contenido principal ocupa dos tercios del ancho disponible.",
			"variant" => "muted",
		]);
		echo "</div></div>";
		echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-inset);">';
		$ui->heading(["text" => "Sidebar (1fr)", "level" => 4]);
		echo '<div style="margin-top:8px;">';
		$ui->paragraph([
			"text" => "Contextual, filtros o acciones secundarias.",
			"variant" => "muted",
		]);
		echo "</div></div>";
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Grid irregular (1fr 2fr 1fr)",
			"Columna central dominante. Útil para layouts editoriales o dashboards con foco central.",
		);
		echo '<div style="display:grid;grid-template-columns:1fr 2fr 1fr;gap:var(--pw-layout-gap);">';
		foreach (["Nav / Meta", "Contenido central", "Acciones"] as $col) {
			$bg =
				$col === "Contenido central"
					? "var(--pw-color-bg-subtle)"
					: "var(--pw-color-bg-inset)";
			echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:' .
				esc_attr($bg) .
				';">';
			$ui->paragraph(["text" => $col]);
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Grid 4 columnas (repeat(4, 1fr))",
			"Para ítems de catálogo, iconografía o grids de opciones compactas.",
		);
		echo '<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:var(--pw-space-4);">';
		foreach (range(1, 8) as $n) {
			echo '<div style="border:1px solid var(--pw-color-border-default);padding:var(--pw-space-4);background:var(--pw-color-bg-subtle);display:flex;align-items:center;justify-content:center;">';
			echo '<span style="font-size:10px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">Ítem ' .
				(int) $n .
				"</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Masonry — CSS columns",
			"Usando column-count + column-gap. Los ítems fluyen verticalmente, no requieren altura uniforme.",
		);
		echo '<div style="column-count:3;column-gap:var(--pw-layout-gap);">';
		$items = [100, 60, 140, 80, 120, 50, 90, 110];
		foreach ($items as $h) {
			echo '<div style="break-inside:avoid;margin-bottom:var(--pw-space-4);border:1px solid var(--pw-color-border-default);padding:var(--pw-card-padding);background:var(--pw-color-bg-subtle);height:' .
				(int) $h .
				'px;display:flex;align-items:center;">';
			echo '<span style="font-size:10px;color:var(--pw-color-fg-subtle);">h=' .
				(int) $h .
				"px</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Geometría irregular — grid-template-areas",
			"Áreas con nombres. Permite layouts tipo mosaico o editorial con control total.",
		);
		echo '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;grid-template-rows:120px 80px;gap:var(--pw-space-2);grid-template-areas:\'hero hero side\' \'meta body side\';">';
		$areas = [
			"hero" => "Hero (span 2 cols)",
			"side" => "Side (span 2 rows)",
			"meta" => "Meta",
			"body" => "Body",
		];
		foreach ($areas as $area => $label) {
			echo '<div style="grid-area:' .
				esc_attr($area) .
				';border:1px solid var(--pw-color-border-emphasis);background:var(--pw-color-bg-inset);display:flex;align-items:center;justify-content:center;padding:var(--pw-space-3);">';
			echo '<span style="font-size:10px;color:var(--pw-color-fg-subtle);text-transform:uppercase;letter-spacing:0.06em;">' .
				esc_html($label) .
				"</span>";
			echo "</div>";
		}
		echo "</div>";
		pw_pg_section_end();

		pw_pg_section(
			"Reglas de espaciado — inter-contenedor",
			"Cuánto aire dar entre bloques según su nivel jerárquico.",
		);
		echo '<table class="wp-list-table widefat fixed striped" style="width:auto;max-width:560px;">';
		echo "<thead><tr><th>Contexto</th><th>Token recomendado</th><th>Valor</th></tr></thead><tbody>";
		$rules = [
			["Entre secciones de página (h2 block)", "--pw-space-8", "32px"],
			["Entre cards / contenedores hermanos", "--pw-layout-gap", "24px"],
			["Entre heading y primer párrafo", "--pw-space-2", "8px"],
			["Entre párrafos consecutivos", "--pw-space-2", "8px"],
			["Entre imagen y caption", "6px (manual)", "6px"],
			["Entre caption y párrafo siguiente", "--pw-card-padding", "16px"],
			["Gap interno de un card", "--pw-card-padding", "16px"],
			["Entre label y control de formulario", "--pw-space-2", "8px"],
			["Entre campos de formulario", "--pw-form-gap", "16px"],
			["Entre ítems de grid compacto", "--pw-space-4", "16px"],
		];
		foreach ($rules as [$ctx, $token, $val]) {
			echo "<tr>";
			echo '<td style="font-size:11px;">' . esc_html($ctx) . "</td>";
			echo '<td><code style="font-size:10px;color:var(--pw-color-fg-default);">' .
				esc_html($token) .
				"</code></td>";
			echo '<td style="font-size:11px;color:var(--pw-color-fg-subtle);">' .
				esc_html($val) .
				"</td>";
			echo "</tr>";
		}
		echo "</tbody></table>";
		pw_pg_section_end();
	},
]);
