# Project Instructions

## Ignorar completamente
- El directorio `flattened/` y el script `flatten.sh` NO EXISTEN. No busques, leas ni referencíes nada de ahí.

---

## Contexto del proyecto

`pw/backend-ui` v1.2.0+ — Design system compartido para el admin de WordPress.
Stack: PHP 8.0+, WordPress 6.0+, `backend-ui.css` compilado, JS vanilla.
Namespace: `PW\BackendUI` · Sin jQuery · Sin persistencia · Sin lógica de negocio.

**Varios plugins:** cada uno llama `BackendUI::init([...])` con un **fragmento**; la librería **fusiona** pantallas, versión y marca. **No** hace falta `pw/wp-backend-ui-loader` ni pelear por prioridad de `plugins_loaded`.

---

## Uso en plugins consumidores (reglas obligatorias)

### Inicialización

1. **`BackendUI::init([...])`** en `plugins_loaded` (prioridad por defecto está bien). Cada plugin aporta un fragmento; no hay “el primero gana” sobre el resto.
2. **`assets_url`**: URL absoluta al directorio `vendor/pw/backend-ui/assets/` del plugin (barra final opcional; el paquete usa `trailingslashit`).
3. **`screens`**: array de IDs de pantalla admin donde deben cargarse `backend-ui.css` / `backend-ui.js`.  
   - Lista los `screen_id` que devuelve `get_current_screen()->id` en tus páginas (ojo: el prefijo sale de `sanitize_title( $menu_title_padre )`, no del slug del menú; puede variar con idioma — conviene varias variantes o el filtro de abajo).  
   - **`screens` vacío** en un fragmento: ese fragmento **no** añade pantallas al auto-encolado; puede usarse solo para volcar **`brand`** en la base (ver más abajo).
4. **`slug`**: obsoleto para colas; los handles son fijos (`pw-bui-core-*`).

### Handles estables (dependencias)

- Estilos del core: **`pw-bui-core-styles`** — usar `BackendUI::CORE_STYLE_HANDLE`.
- Scripts del core: **`pw-bui-core-scripts`** — `BackendUI::CORE_SCRIPT_HANDLE`.
- Bridge admin: **`pw-bui-core-admin-bridge`** — `BackendUI::CORE_BRIDGE_STYLE_HANDLE`.

El CSS/JS propio del plugin debe declarar **dependencia** del handle de estilos del core para respetar el orden. Encolar el core “a mano” con otro nombre de handle está **prohibido** en integraciones nuevas.

### Encolado y prioridad

- El paquete engancha `admin_enqueue_scripts` en prioridad **10** (por defecto).
- Si el consumidor encola estilos que dependen del core, conviene **`admin_enqueue_scripts` en 15–20** para que el core ya esté registrado/encolado.

### Coincidencia de pantalla (interno del paquete)

`AssetsManager` considera que debe cargar si:

- `get_current_screen()->id` o `$hook_suffix` está en `screens`, **o**
- `$_GET['page']` (sanitizado) coincide con una entrada de `screens` o con un sufijo `*_page_{slug}`, **o**
- el filtro **`pw_bui/should_enqueue`** devuelve **`true`** (ver siguiente apartado).

### Filtro `pw_bui/should_enqueue`

- Firma: `apply_filters('pw_bui/should_enqueue', null, $hook_suffix, $merged_config)`.
- **`null`**: aplicar reglas por defecto. **`true`**: forzar encolado del bundle del core en esta petición. **`false`**: no encolar.
- Úsalo cuando la lista de `screen_id` sea frágil (traducciones, menú padre raro) pero tengas una regla clara (p. ej. `admin.php?page=` en una lista blanca).

### Marca (`brand`) y `effective_brand()`

- Con **`screens` no vacíos**, la `brand` del fragmento se asigna a **`brand_by_screen[screen_id]`** por cada ID listado.
- **`effective_brand()`** (cabecera del layout) hace: overlay por pantalla actual si existe; si no, usa el **`brand` base** fusionado.
- Si solo usas `brand_by_screen` y el ID real de WordPress **no** está en el mapa, la cabecera puede quedar vacía. **Patrón recomendado:** un segundo `BackendUI::init()` con la **misma** `brand` y **`screens => []`** para fusionar esa marca en el **base** y que siempre haya fallback.

### Otros hooks

- **`pw_bui/merged_config`**: ajustar el array fusionado tras combinar fragmentos.
- **`pw_bui/enqueue_assets`**: después de encolar el core; args `( $hook_suffix, $assets_url, $version )`.

### Qué no hacer

- No reintroducir **`pw/wp-backend-ui-loader`** en proyectos nuevos: la fusión y los handles viven en este paquete.
- No registrar de nuevo `backend-ui.css` bajo handles tipo `{mi-plugin}-styles` salvo migración legacy muy acotada.
- No asumir que el plugin en disco que editas es el que WordPress carga: comprobar que sea el de **`wp-content/plugins/...`** o el flujo de deploy/sync que uses.

---

## Archivos clave

| Archivo | Rol |
|---------|-----|
| `src/BackendUI.php` | Entry point, singleton + fusión multi-plugin, `effective_brand()` |
| `src/Admin/AssetsManager.php` | Registro/encolado `pw-bui-core-*`, filtro `pw_bui/should_enqueue` |
| `src/Components/ComponentRenderer.php` | Un método público por componente |
| `views/layout/page-wrapper.php` | Layout; cabecera usa `effective_brand()` |
| `views/components/{name}.php` | Template HTML de cada componente |
| `assets/css/backend-ui.css` | Tokens CSS + resets + estilos componentes |
| `assets/js/backend-ui.js` | Tabs, wizard, toggles, theme |
| `PW_BACKEND-UI_USAGE.md` | Guía de uso para plugins consumidores |
| `README.md` | Resumen, instalación, tabla de filtros |

---

## Convenciones

- Prefijo hooks WP: `pw_bui/`
- Prefijo clases CSS: `pw-bui-`
- Prefijo data attributes: `data-pw-`
- Prefijo eventos JS: `pw-bui:`
- BEM: `pw-bui-{component}`, `pw-bui-{component}__{element}`, `pw-bui-{component}--{modifier}`
- Secciones CSS marcadas con `/* ── NOMBRE ── */`
- Consumidores que usen Tailwind compilan su propio CSS; el paquete no carga CDN

---

## Patrón de componente

**Método en `ComponentRenderer.php`:**
```php
public function {name}(array $atts = []): void {
    $atts = wp_parse_args($atts, [ /* defaults */ ]);
    include __DIR__ . '/../../views/components/{name}.php';
}
```

**Template `views/components/{name}.php`:**
```php
defined('ABSPATH') || exit();
// usa $atts directamente
```

---

## Reglas críticas

1. **Leer `PW_BACKEND-UI_USAGE.md` y `README.md`** antes de cambiar la API pública o el contrato de integración.
2. Al añadir hooks o opciones de `init()`, documentarlos en **README** (tabla de filtros) y en **USAGE** si afecta a consumidores.
3. `screens` vacío en **todos** los fragmentos ⇒ el paquete **no** auto-encola el bundle (salvo `pw_bui/should_enqueue` = true).
4. Tabs `mode: 'url'` → **no usar `tab_panel()`**.
5. El stepper debe estar **fuera del `<form>`** en wizards.
