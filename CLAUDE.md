# Project Instructions

## Project context

**Package:** `pw/backend-ui` — Sistema de diseño compartido para el admin de WordPress.
**Versión activa:** 1.4.0 (dev-main)
**Namespace:** `PW\BackendUI`
**Stack:** PHP 8.0+, WordPress 6.0+, Tailwind CSS CDN, JS vanilla, sin build process.

Todos los plugins PW consumen este package para mantener consistencia visual. Carga Tailwind CSS CDN automáticamente en las screens configuradas.

---

## Estructura del proyecto

```
pw-backend-ui/
├── src/
│   ├── BackendUI.php                    Entry point, singleton
│   ├── Admin/AssetsManager.php          Enqueue de Tailwind CDN + CSS + JS
│   ├── Components/ComponentRenderer.php Métodos render para cada componente UI
│   └── Contracts/PageConfigInterface.php Interface opcional para config de página
├── views/
│   ├── layout/page-wrapper.php          Layout completo: header, tabs, body, sidebar, footer
│   └── components/                      Un archivo .php por componente
├── assets/
│   ├── css/backend-ui.css               Tokens CSS + resets WP admin + estilos componentes
│   └── js/backend-ui.js                 Tabs, toggles, dismiss notices, wizard, theme toggle
├── PW_BACKEND-UI_CONTRACT.md            API pública completa (leer antes de cambios de API)
└── composer.json
```

---

## Convenciones de código

- **Comentario de ruta relativa** en el header de cada archivo PHP, JS y CSS.
- **Namespace raíz:** `PW\BackendUI`
- **Prefijo de hooks WP:** `pw_bui/`
- **Prefijo de handles JS/CSS:** `pw-backend-ui` (o `$config['slug']`)
- **Prefijo de clases CSS custom:** `pw-bui-`
- **Prefijo de data attributes:** `data-pw-`
- **Prefijo de eventos JS custom:** `pw-bui:`
- **Tailwind:** sin prefijo, usar clases estándar (`flex`, `gap-4`, `mt-2`, etc.)
- **`@apply` no disponible** — CDN sin PostCSS, usar clases `pw-bui-*` en CSS puro.

---

## Convenciones de componentes

Cada componente tiene dos partes:

1. **Método en `ComponentRenderer.php`:**
   ```php
   public function {name}(array $atts = []): void {
       $atts = wp_parse_args($atts, [ /* defaults */ ]);
       include __DIR__ . '/../../views/components/{name}.php';
   }
   ```

2. **Template en `views/components/{name}.php`:**
   ```php
   defined('ABSPATH') || exit();
   // usa variables de $atts directamente
   ```

- BEM: `pw-bui-{component}`, `pw-bui-{component}__{element}`, `pw-bui-{component}--{modifier}`
- Secciones CSS marcadas con `/* ── NOMBRE ── */`

**Al agregar un componente nuevo:**
1. Crear vista en `views/components/{name}.php`
2. Agregar método público en `ComponentRenderer.php`
3. Actualizar `PW_BACKEND-UI_CONTRACT.md`
4. Actualizar `ESTADO_pw-backend-ui.txt`

---

## Reglas críticas para Claude

- **Leer `PW_BACKEND-UI_CONTRACT.md`** antes de cualquier cambio que toque la API pública de `BackendUI` o `ComponentRenderer`.
- **Actualizar `PW_BACKEND-UI_CONTRACT.md`** en cada cambio de API o nuevo componente.
- El package **NO** persiste datos, **NO** registra páginas de admin, **NO** tiene lógica de negocio.
- `screens` vacío = assets **no** se cargan en ninguna pantalla (opt-in explícito).
- El stepper debe estar **fuera del `<form>`** en wizards.
- Tabs en `mode: 'url'` **no usan `tab_panel()`**.

---

## Componentes implementados (26)

**Formulario:** `input`, `date_input`, `textarea`, `select`, `checkbox`, `toggle`, `radio`, `radio_group`, `segmented_control`
**Contenido:** `card`, `notice`, `badge`, `separator`
**Tipografía:** `heading`, `paragraph`, `link`
**Feedback:** `spinner`, `progress_bar`, `skeleton`, `tooltip`
**Navegación:** `tabs`, `tab_panel`, `breadcrumbs`, `pagination`, `side_nav`, `stepper`

---

## Hooks expuestos

| Hook | Tipo | Descripción |
|------|------|-------------|
| `pw_bui/page_config` | filter | Modificar config de página antes de renderizar |
| `pw_bui/enqueue_assets` | action | Encolar assets adicionales |
| `pw_bui/header_right` | action | Inyectar contenido a la derecha del header |

## Eventos JS

| Evento | Descripción |
|--------|-------------|
| `pw-bui:ready` | JS inicializado |
| `pw-bui:theme-changed` | Cambio de tema (`detail: { theme }`) |
| `pw-bui:tab-changed` | Cambio de tab en mode `'js'` (`detail: { slug }`) |
| `pw-bui:toggle-changed` | Cambio de toggle (`detail: { name, checked, value }`) |
| `pw-bui:segment-changed` | Cambio en segmented control (`detail: { name, value }`) |
| `pw-bui:wizard-step-changed` | Paso de wizard (`detail: { from, to, index }`) |

---

## Pendiente / Próximos pasos

- Componente `modal/dialog`
- Componente `table` (listados con sort/paginación propios)
- Componente `file upload`
- Documentar override de vistas desde el plugin consumidor
