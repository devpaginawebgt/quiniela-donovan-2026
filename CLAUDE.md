# Contexto del Proyecto — Quiniela Donovan

## Stack

- **Backend**: Laravel 12, PHP ^8.1 (esqueleto legacy de Laravel 10 — conserva `app/Http/Kernel.php`, `App\Providers\EventServiceProvider`, etc.)
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

## Feature — Bracket Mundial 2026

### Modelo de datos

- **Tabla**: `bracket_games` (modelo `App\Models\BracketGame`)
- **Campos clave**:
  - `journey_id` — FK a `jornadas`. En este bracket: 4 = 32vos, 5 = 8vos, 6 = 4tos, 7 = semis, **8 = tercer lugar**, **9 = final**.
  - `bracket_position` — posición ordinal dentro de la jornada (define el orden de llenado y los pareos).
  - `match_id` — FK a `partidos` (se setea cuando se registra el partido real).
  - `team_one_id` / `team_two_id` — equipos en los slots (se llenan por feeder o por evento).
  - `result_id` — FK a `resultados_partidos`.
  - `status` — `0` vacío, `1` con equipos/partido asignado, `2` con resultado cargado.
  - `local_game_id` / `visitor_game_id` — FK autoreferencial: bracket game "padre" que alimenta cada slot.
  - `local_source` / `visitor_source` — `'perdedor'` cuando el slot se alimenta del **perdedor** del feeder (caso tercer lugar). `null`/otro valor => **ganador**.
  - `local_slot_label` / `visitor_slot_label` — etiqueta manual ej. `'1A'`, `'2B'` (solo 32vos, donde aún no hay feeder).

### Seeder

- `database/seeders/BracketGameSeeder.php` crea los 16 + 8 + 4 + 2 + 1 (tercer lugar) + 1 (final) = **32 bracket games**.
- Los feeders (`local_game_id`, `visitor_game_id`) se enlazan automáticamente entre jornadas consecutivas.
- **Tercer lugar** (`journey_id=8`, `bracket_position=1`) se alimenta de las dos semis con `local_source='perdedor'` y `visitor_source='perdedor'`.
- **Final** (`journey_id=9`) se alimenta de las dos semis con sources vacíos (=> ganadores).

### Eventos y listeners

Registrados en `app/Providers/EventServiceProvider.php` (auto-discovery **desactivada** por el esqueleto legacy, mapeo manual):

| Evento | Listener | Efecto |
|---|---|---|
| `App\Events\MatchCreated` | `App\Listeners\AddBracketGame` | Llama `BracketGameService::addBracketGame($partido)` |
| `App\Events\ResultCreated` | `App\Listeners\AddBracketGameResult` | Llama `BracketGameService::addBracketGameResult($resultado)` |

- Ambos listeners corren **síncronos** (no implementan `ShouldQueue`) → no se necesita `queue:work`.
- **Dispatch**: usar `MatchCreated::dispatch($partido)` / `ResultCreated::dispatch($resultado)`. `new MatchCreated(...)` solo instancia, **no** emite.

### BracketGameService — comportamiento

Ubicación: `app/Http/Services/BracketGameService.php`.

**`addBracketGame(Partido $partido)`**
1. Ignora jornadas 1–3 (fase de grupos).
2. Guard anti-duplicado: si ya existe un bracket con ese `match_id`, sale.
3. Valida que `$partido->equipos` (relación `EquipoPartido`) exista.
4. Busca el primer `BracketGame` de esa jornada con `status=0` ordenado por `bracket_position` ASC → actualiza con `match_id`, `team_one_id`, `team_two_id` y `status=1`.
5. Errores → `notify()` (log + mail).

**`addBracketGameResult(ResultadoPartido $resultado)`**
1. Valida `$resultado->partido` y que no sea jornada 1–3.
2. Busca `BracketGame` con `match_id` y `status=1` → actualiza con `result_id` y `status=2`. Si falla, `return` (no propaga).
3. **Propaga al siguiente nivel**:
   - Calcula `$loser_id` desde `$resultado->equiposPartido` (el equipo que no es `equipo_ganador_id`).
   - Busca **todos** los children con `local_game_id = $bracketGame->id` OR `visitor_game_id = $bracketGame->id` (pueden ser 2: final + tercer lugar cuando el padre es una semi).
   - Por cada child, para cada lado (local/visitor) que apunte al padre: si `*_source === 'perdedor'` inserta `$loser_id`, si no inserta `$winner_id`.

**`notify($subject, $body)`** — helper privado: `Log::warning(...)` + `Mail::to(config('quiniela.system_notifications_email'))->send(new SystemNotification(...))`.

### Vistas del bracket

- Embed: ruta `/embed/bracket` → `BracketController::show` agrupa los games por `journey_id` y renderiza `resources/views/embed/bracket.blade.php`.
- Componentes por ronda en `resources/views/components/bracket/`: `round-of-32`, `round-of-16`, `quarterfinals`, `semifinals`, `final` (que incluye tercer lugar), `match-card`.
- Los conectores entre rondas colorean `border-light/80` cuando el partido tiene `status === 2`, o `border-complementary-light/40` en otro caso (el horizontal usa `$anyFinished = $topFinished || $botFinished`).
- La card de la final tiene un efecto `.bracket-final-glow` (conic-gradient rotativo con `@property --bracket-final-angle`) definido en `app.css`.

### Config

- `config/quiniela.php` expone `system_notifications_email` vía `env('SYSTEM_NOTIFICATIONS_EMAIL')`. Uso: `config('quiniela.system_notifications_email')`.
- Mailable: `App\Mail\SystemNotification` acepta `customSubject` y `body` (vista `emails.system-notification`). Nota: la propiedad se llama `customSubject` (no `subject`) porque `Mailable` ya reserva `$subject`.
