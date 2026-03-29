# Plan: Correcciones WordPress.org — pw/backend-ui

Estado: COMPLETADO
Fecha: 2026-03-28

---

## Issue 1 — Inline `<script>` en page-wrapper.php [ALTA]

**Archivo:** `views/layout/page-wrapper.php` línea 21
**Problema:** Tag `<script>` crudo en template PHP (no usa WP API).
**Fix:**
1. En `AssetsManager::enqueue()`, agregar después del `wp_enqueue_script` principal:
   ```php
   wp_add_inline_script(
       $slug . '-scripts',
       "try{var __pwt=localStorage.getItem('pw-bui-theme');if(__pwt==='light'||__pwt==='dark'){var __pwa=document.getElementById('pw-backend-ui-app');if(__pwa){__pwa.setAttribute('data-pw-theme',__pwt);}}}catch(e){}",
       'before'
   );
   ```
2. Eliminar línea 21 de `page-wrapper.php` (el `<script>...</script>` completo).

**Resultado:** El código sigue funcionando — el footer script corre después de que el DOM existe.

---

## Issue 2 — Tailwind CDN enqueue [ALTA]

**Archivo:** `src/Admin/AssetsManager.php` líneas 42–49
**Problema:** `wp_enqueue_script('tailwind-cdn', 'https://cdn.tailwindcss.com', ...)` — URL de terceros en código distribuido.
**Fix:**
1. Eliminar el bloque `wp_enqueue_script('tailwind-cdn', ...)` completo (líneas 42–49 incluyendo comentario).

**Resultado:** ZIP limpio sin referencias a CDN externo. El CSS del package usa variables propias, no necesita Tailwind en runtime.

---

## Issue 3 — Atributos `style=""` en page-wrapper.php [MEDIA]

**Archivo:** `views/layout/page-wrapper.php`
**Problema:** Varios `style="..."` inline en el template.

### Estilos a mover a CSS

| Línea | Elemento | Clase nueva |
|-------|----------|-------------|
| 39 | `h1` en header (sin brand) | `.pw-bui-header__title` |
| 93 | `div` wrapper título+desc | `.pw-bui-page-title` |
| 94 | `h1` título principal | `.pw-bui-page-title__heading` |
| 98-99 | `p` descripción (en bloque título) | `.pw-bui-page-title__desc` |
| 104-106 | `p` descripción (sin título) | `.pw-bui-page-title__desc--standalone` |
| 138 | `main` layout | `.pw-bui-layout__main` (nueva clase CSS: min-width:0) |
| 145 | `aside` layout | `.pw-bui-layout__sidebar` (nueva clase CSS: min-width:0) |
| 147-148 | `p` label sidebar | `.pw-bui-sidebar__label` |

### Paso 1: Agregar clases en `assets/css/backend-ui.css`
Sección nueva `/* ── PAGE LAYOUT HELPERS ── */` después de la sección LAYOUT existente.

### Paso 2: Reemplazar `style=""` en `page-wrapper.php` con las clases nuevas.

---

## Orden de ejecución
1. [x] Issue 2 (CDN) — cambio más simple, menor riesgo
2. [x] Issue 1 (script) — mover a AssetsManager + limpiar template
3. [x] Issue 3 (styles) — agregar CSS + actualizar template

## Verificación final
- [x] No queda ningún `<script>` literal en views/
- [x] No queda `cdn.tailwindcss.com` en src/
- [x] No queda `style=""` en page-wrapper.php
- [x] Funcionalidad de tema (dark/light toggle) intacta (cubierta por initTheme() + wp_add_inline_script)
- [x] Funcionalidad de layout intacta (min-width:0 movido a clases CSS)
