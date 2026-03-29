# Backend UI (`vendor/pw/backend-ui`) y revisión WordPress.org

Este archivo documenta **solo** los problemas que vienen del paquete Composer **`pw/backend-ui`**, que termina en `vendor/pw/backend-ui/` dentro de este plugin. Como eres el autor de ese paquete, puedes corregirlos allí, publicar un tag nuevo y actualizar la dependencia aquí (`composer update pw/backend-ui`).

## Por qué importa

WordPress.org revisa el **ZIP completo** del plugin, **incluido `vendor/`**. No hay excepción por “es una librería”: si un revisor o un grep automático encuentra patrones problemáticos en PHP o referencias a recursos externos, pueden pedir cambios o rechazar el envío.

Este plugin ya mitiga parte del tema del Tailwind CDN en [`src/Admin/AdminAssets.php`](src/Admin/AdminAssets.php) (`wp_dequeue_script` / `wp_deregister_script` del handle `tailwind-cdn` cuando existe CSS compilado propio). Eso puede evitar que el navegador cargue el CDN en la práctica, pero **el código del paquete sigue conteniendo** la URL y el `wp_enqueue_script`, lo cual sigue siendo señalable en revisión y desalineado con un `readme.txt` que diga que no se usa CDN.

---

## 1. Etiqueta `<script>` literal en una vista PHP (alta prioridad)

**Archivo (en el repo de Backend UI):** `views/layout/page-wrapper.php`  
**Línea aproximada:** 21 (tras el `<div id="pw-backend-ui-app" …>`)

**Qué hace hoy:** Un bloque inline que lee `localStorage` (`pw-bui-theme`) y ajusta `data-pw-theme` en el contenedor para evitar flash de tema incorrecto.

**Por qué lo señalan:** Las guías del directorio suelen exigir que el JavaScript se cargue vía API de WordPress (`wp_enqueue_script` +, si hace falta código inline, `wp_add_inline_script` en un handle ya registrado), no como `<script>...</script>` crudo impreso desde PHP.

**Dirección de arreglo recomendada:**

- Mover esa lógica al JS principal del paquete (p. ej. al inicio de `assets/js/backend-ui.js` o equivalente), ejecutándola en cuanto exista `#pw-backend-ui-app` en el DOM.
- Eliminar por completo la línea del `<script>...</script>` del `page-wrapper.php`.

Si por orden de carga necesitas que corra antes que el bundle, valorar un handle mínimo encolado en `<head>` con `wp_enqueue_script` + `wp_add_inline_script` desde `AssetsManager` (sigue siendo “API de WP”, no HTML crudo en la vista).

---

## 2. Registro del Tailwind Play CDN (prioridad alta para “grep limpio”)

**Archivo (en el repo de Backend UI):** `src/Admin/AssetsManager.php`  
**Líneas aproximadas:** 42–49

**Qué hace hoy:**

```php
wp_enqueue_script(
    'tailwind-cdn',
    'https://cdn.tailwindcss.com',
    ...
);
```

**Por qué lo señalan:**

- Aparece una **URL de terceros** en código distribuido; el `readme.txt` del plugin consumidor afirma uso de CSS empaquetado sin CDN público — conviene que el paquete no contradiga eso en el árbol por defecto.
- Aunque el consumidor haga dequeue, el **código fuente del ZIP** sigue mostrando el CDN.

**Direcciones de arreglo (elige una):**

1. **Recomendada:** No encolar el CDN por defecto. Los plugins que aún quieran Tailwind en runtime pueden optar por un flag de configuración (`enqueue_tailwind_cdn` => true) o documentar un snippet para consumidores avanzados.
2. Mantener el CDN solo si el readme de **cada** plugin que lo use documenta explícitamente ese servicio (qué es, cuándo carga, enlaces a términos/privacidad del proveedor del CDN). Para WordPress.org suele ser más simple **no** depender del CDN en el paquete por defecto.

El comentario en la misma clase dice que el design system usa variables CSS y que el CDN no es obligatorio — alinear el código con ese comentario elimina fricción en revisión.

---

## 3. Atributos `style="..."` en el mismo `page-wrapper.php` (prioridad media)

**Archivo:** `views/layout/page-wrapper.php` (varias secciones: cabecera, títulos, layout).

**Qué es:** Presentación en línea vía atributo HTML, no etiquetas `<style>`.

**Riesgo:** No siempre es bloqueante, pero algunos revisores piden mover estilos a hojas encoladas (`backend-ui.css`) o a clases utilitarias para mantener políticas de “sin estilos inline” de forma consistente.

**Dirección de arreglo:** Clases en `css/backend-ui.css` (o build equivalente) y eliminar los `style=""` de la plantilla donde sea posible.

---

## Después de cambiar Backend UI en tu repo

1. Subir versión semver en `composer.json` del paquete y crear **tag** en el VCS del paquete.
2. En **este** plugin: actualizar la restricción/referencia en [`composer.json`](composer.json) y ejecutar `composer update pw/backend-ui`.
3. Regenerar el build Lite / ZIP de WordPress.org y, si existe, pasar el script de verificación del artefacto (cuando lo tengas).

## Referencia rápida de rutas en el árbol instalado

| Ruta en este proyecto | Origen |
|----------------------|--------|
| `vendor/pw/backend-ui/views/layout/page-wrapper.php` | Vista layout |
| `vendor/pw/backend-ui/src/Admin/AssetsManager.php` | Encolado admin |

El origen “canónico” es el repositorio Git de `pw/backend-ui` referenciado en Composer (`repositories` → `https://github.com/hizoka3/pw-backend-ui` en este proyecto).
