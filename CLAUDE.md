# Contexto del Proyecto — Quiniela Donovan

## Stack

- **Backend**: Laravel 10, PHP
- **Plantillas**: Blade
- **Bundler**: Vite 7

## Frontend — Diseño

- **Tailwind CSS v4** — NO existe `tailwind.config.js`. La configuración del tema está en `resources/css/app.css` mediante el bloque `@theme`.
- **Importante**: Usar sintaxis de Tailwind v4. Las clases de `@theme` se usan directamente como utilidades (ej. `bg-primary`, `text-secondary`).

### Colores del tema (`@theme` en `app.css`)

| Token | Valor | Uso |
|---|---|---|
| `primary` | `#2b336b` | Azul oscuro principal |
| `secondary` | `#FFDD00` | Amarillo — botones CTA, activos |
| `dark` | `#101820` | Texto oscuro, fondos muy oscuros |
| `light` | `#FFFFFF` | Texto claro, fondos claros |
| `complementary-primary` | `#1F2A44` | Fondos de paneles/cards |
| `complementary-secondary` | `#84754E` | Acento dorado |
| `complementary-dark` | `#63666A` | Grises medios |
| `complementary-light` | `#D9D9D6` | Texto secundario, bordes suaves |

**Fuente**: Arial / ui-sans-serif (definida en `--font-sans`)

## Frontend — Componentes UI

- **Flowbite v4** está instalado y configurado.
  - Plugin CSS: `@plugin "flowbite/plugin"` en `app.css`
  - JS: `import 'flowbite'` en `resources/js/app.js`
  - **Preferir componentes de Flowbite** para: modales, dropdowns, tabs, tooltips, badges, alerts, popovers, spinners, etc.
  - Documentación: https://flowbite.com/docs/

## Frontend — JavaScript

- **NO usar `var`**. Usar `const` por defecto y `let` solo cuando el valor cambie.

## Frontend — HTTP

- **Axios** disponible globalmente como `window.axios`
- Configurado en `resources/js/bootstrap.js` con:
  - Header `X-Requested-With: XMLHttpRequest`
  - Token CSRF automático desde `<meta name="csrf-token">`

## Convenciones de Vistas

- **Layout base autenticado**: `resources/views/layouts/app.blade.php`
  - Usa `{{ $slot }}` para el contenido
  - Incluye navbar inferior (`components/navigation`)
  - Fondo con imagen responsiva: `main-bg.png` (móvil) / `bg-main-web.png` (lg+)
- **Componentes Blade**: `resources/views/components/`
- **Módulos/páginas**: `resources/views/modulos/`
- **Auth**: `resources/views/auth/`

## Frontend — Iconos

- **Usar iconos de Iconify** vía `@iconify/tailwind4` (plugin ya configurado en `app.css`).
  - Sintaxis: `<span class="icon-[set--nombre] w-5 h-5"></span>`
  - Sets instalados: `material-symbols`, `fa-solid`, `fa-regular`
- **NO usar SVGs inline ni Font Awesome standalone**. Siempre preferir Iconify.
- Si se necesitan más iconos, instalar el set correspondiente de Iconify como devDependency: `npm install -D @iconify-json/<set-name>`

## Imágenes y Assets

- Logos: `public/images/logos/`
- Imágenes decorativas/fondos: `public/images/decoracion/`
