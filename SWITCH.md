# `pw-bui-switch` — Componente Switch

Componente de toggle de estado basado en `<input type="checkbox">` nativo. Pertenece al package `pw-backend-ui`. Reemplaza el patrón `imec-switch` del plugin `imec-capacita`.

---

## API

```php
$ui->switch([
    'name'     => 'empresa_activa',  // string — input name (requerido)
    'label'    => 'Estado',          // string — texto de label (opcional)
    'checked'  => true,              // bool   — estado inicial
    'value'    => '1',               // string — value cuando checked (default: '1')
    'variant'  => 'default',         // 'default' | 'status'
    'help'     => '',                // string — texto de ayuda (opcional)
    'disabled'     => false,         // bool
    'class'        => '',            // string — clases extra en el wrap
    'data_attrs'   => [],            // array  — key→value → data-* en el <input>
    'status_label' => '',            // string — texto inicial en <span class="pw-bui-switch__status">
]);
```

**Variantes:**
- `default`: off = gris (`--pw-color-bg-emphasis`), on = rojo PW (`--pw-color-accent-fg`)
- `status`:  off = rojo semántico (`--pw-color-danger-fg`), on = verde (`--pw-color-success-fg`)

---

## Archivos del componente

| Archivo | Rol |
|---|---|
| `views/components/switch.php` | Template HTML |
| `src/Components/ComponentRenderer.php` → `switch()` | Método público del renderer |
| `assets/css/backend-ui.css` → `/* ── SWITCH ── */` | Estilos (línea ~941) |
| `flattened/backend-ui.css` → `/* ── SWITCH ── */` | Espejo del CSS |

---

## HTML generado

```html
<div class="pw-bui-form-group">
  <div class="pw-bui-switch-wrap [class]">
    <div>
      <!-- label y help opcionales -->
      <label for="pw-switch-{name}" class="pw-bui-label">…</label>
      <p class="pw-bui-form-help">…</p>
    </div>
    <div class="pw-bui-switch__control">
      <!-- solo si status_label !== "" — va ANTES del slider -->
      <span class="pw-bui-switch__status">Activa</span>
      <label class="pw-bui-switch pw-bui-switch--{variant}" for="pw-switch-{name}">
        <input type="checkbox" id="pw-switch-{name}" name="{name}" value="{value}"
               class="pw-bui-switch__input" [checked] [disabled] [data-*]>
        <span class="pw-bui-switch__slider" aria-hidden="true"></span>
      </label>
    </div>
  </div>
</div>
```

ID generado: `"pw-switch-" . sanitize_title($name)`

---

## Uso con AJAX (patrón tabla WP)

El componente no incluye JS. Para toggle AJAX en una `WP_List_Table`:

```php
// En column_estado():
$ui->switch([
    'name'         => 'estado_' . $item->id,
    'checked'      => $item->activo,
    'variant'      => 'status',
    'class'        => 'js-toggle-estado',
    'data_attrs'   => ['id' => $item->id],
    'status_label' => $item->activo ? 'Activa' : 'Inactiva',
]);
```

```js
// JS del plugin — escuchar change en el input:
document.querySelectorAll('.js-toggle-estado .pw-bui-switch__input').forEach(input => {
    input.addEventListener('change', function () {
        this.disabled = true;
        fetch(myPlugin.ajaxurl, {
            method: 'POST',
            body: new URLSearchParams({ action: 'my_toggle', nonce: myPlugin.nonce, id: this.dataset.id })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const lbl = this.closest('.pw-bui-switch-wrap').querySelector('.pw-bui-switch__status');
                if (lbl) lbl.textContent = data.data.activo ? 'Activa' : 'Inactiva';
            } else {
                this.checked = !this.checked;
            }
        })
        .catch(() => { this.checked = !this.checked; })
        .finally(() => { this.disabled = false; });
    });
});
```

**Handler PHP:**
```php
add_action('wp_ajax_my_toggle', function () {
    check_ajax_referer('my_nonce', 'nonce');
    $id = absint($_POST['id'] ?? 0);
    // … toggle post_status publish/draft …
    wp_send_json_success(['activo' => $nuevo_estado]);
});
```

---

## Diferencia con `toggle` (componente existente)

| | `toggle` | `switch` |
|---|---|---|
| Elemento | `<button role="switch">` | `<input type="checkbox">` |
| JS requerido | Sí (actualiza hidden input) | No (nativo) |
| Uso típico | Settings de formulario | Estado en tabla |
| Variante status | No | Sí (rojo ↔ verde) |
