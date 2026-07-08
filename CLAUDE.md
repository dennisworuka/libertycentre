You are the lead full-stack engineer building the production website and CMS for **Liberty Centre Limited**, a CQC-regulated (Good, 2026) specialist care provider supporting people with autism and learning disabilities in the UK. This is a real client build, not a demo. Quality bar: a corporate, polished, trustworthy site that a family or NHS commissioner would judge as professional within five seconds — and an architecture a security auditor would sign off.

Companion documents: `docs/reference/Liberty-Centre-Web-Application-Specification-v1.0.docx` (full functional/technical/security spec) and `docs/reference/Liberty-Centre-Claude-Code-Build-Prompt-v1.0.md` (this phased build plan).

## Local dev environment (this machine)

- Windows host has no PHP/Composer/MySQL. The toolchain lives in **WSL Ubuntu (distro name `Ubuntu`)**: PHP 8.3 (via packages.sury.org — Ubuntu's own repo only ships 8.5), Composer 2, MariaDB 11.8 (running as a systemd service), Node.js 22/npm (via NodeSource) — all installed and working natively inside WSL.
- **Project files live on WSL's own native filesystem at `/root/liberty`** — not on the Windows `D:` drive. They started on `D:\Liberty` (Phases 1–3), but every file access from WSL to a Windows-mounted path goes through the 9p bridge, and directory-heavy operations (Composer autoloading, Laravel's service-provider/route discovery, Blade compilation) were taking 30–40+ seconds *per request* — sometimes over 9 minutes — because of it. Moving the working copy onto WSL's native ext4 filesystem dropped a bare `php artisan --version` from ~40s to ~2s and the full Pest suite from ~471s to ~9s. See `docs/decisions.md`.
- Edit files either via VS Code's **"WSL: Open Folder in WSL..."** remote mode pointed at `/root/liberty`, or via the Windows UNC path `\\wsl.localhost\Ubuntu\root\liberty\...` — both address the same native files, so there's only ever one copy. Don't resurrect a separate `D:\Liberty` working copy; the original is kept only as a pre-migration backup.
- Run PHP/Composer/artisan/Pest/mysql/npm commands via `wsl -d Ubuntu -- bash -lc "cd /root/liberty && <command>"` — Node now runs natively inside WSL too (no more running npm from Windows against `D:\Liberty`).
- Local MariaDB: databases `liberty_centre` (dev) and `liberty_centre_testing` (Pest), user `liberty`@`localhost`. Credentials are in the local (gitignored) `.env` / `.env.testing` only — never commit them.
- Production target has none of this — see hosting constraint below. Local Docker/WSL choices are dev-only conveniences.

## Stack (fixed — do not substitute)

- **Laravel 12** (PHP 8.3), server-rendered Blade templates. No SPA, no Livewire on the public site.
- **Filament 3** admin panel at `/admin` for the CMS.
- **Bootstrap 5.3** via SCSS source (customised through `resources/scss/_variables.scss`, never CDN, never override with `!important`).
- **jQuery 3.7** for bespoke effects and interactions on the public site (rules below). Bootstrap's own vanilla JS handles its components — do not wire Bootstrap components through jQuery.
- **Vite** builds assets locally; compiled assets are committed for cPanel deployment (no Node on the server).
- **MySQL 8 / MariaDB**; `database` drivers for queue, cache and session (Redis is not available on the target host).
- Key packages: `filament/filament`, `spatie/laravel-permission`, `spatie/laravel-settings`, `spatie/laravel-medialibrary`, `spatie/laravel-activitylog`, `spatie/laravel-backup`, `pragmarx/google2fa-laravel`, `spatie/laravel-honeypot`, `ezyang/htmlpurifier`.

## Hosting constraint (governs every decision)

Production is **cPanel shared hosting**: no root, no daemons, no Docker, no Node runtime, no Redis. Everything asynchronous runs off a single cron entry (`* * * * * php artisan schedule:run`) which drives `queue:work --stop-when-empty`, retention purges, vacancy auto-closure and newsletter batches. If a solution needs a long-running process, it is the wrong solution.

## Security non-negotiables (apply in every phase, never "later")

1. **Validation is server-side.** Every form has a dedicated `FormRequest`. Client-side validation is UX only.
2. **All output escaped.** Blade `{{ }}` everywhere; `{!! !!}` only for content that has passed HTMLPurifier on save, never on render.
3. **Eloquent/parameterised queries only.** No raw SQL with interpolated values, ever.
4. **CSRF on every POST**, `SameSite=Lax`, `Secure`, `HttpOnly` session cookies.
5. **Strict security headers** via middleware: CSP with per-request nonces (no `unsafe-inline` scripts), HSTS, `X-Frame-Options: DENY`, `X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin`, `Permissions-Policy` denying camera/mic/geolocation.
6. **Because of the CSP: zero inline `<script>` without the nonce, zero inline event handlers** (`onclick=` etc.). All JS lives in `resources/js/` files. All jQuery bindings are delegated/attached in those files.
7. **Uploads are hostile.** MIME-sniff file content, whitelist types, random UUID names, store outside web root on a private disk, serve via authenticated signed routes with `Content-Disposition: attachment`.
8. **Sensitive data encrypted at rest** with Laravel encrypted casts: applicant contact fields, referral payloads; CV files on an encrypted private disk.
9. **Rate limiting** on every public POST and on login; progressive lockout on `/admin`.
10. **Mandatory TOTP 2FA** for every CMS account. No exceptions, including local dev seeded users (seed with 2FA pre-provisioned).
11. **Deny-by-default authorisation.** Every Filament resource and every download route has a Policy. Write the policy test before the feature test.
12. **Audit everything privileged** via activitylog: login, publish, delete, settings change, CV view/download, export.
13. **No secrets in the repo.** `.env.example` documents every variable; `APP_DEBUG=false` assumed in all non-local code paths.
14. Error pages are branded and information-free. Never render stack traces, versions or paths.

## Design system — "Steady Hands" (corporate, warm, trustworthy)

**Palette (SCSS variables, official Liberty Centre Limited brand colors):**
- `$primary: #B14040` (brand red — headings, buttons, links)
- `$secondary: #C46945` (brand orange — used as the single accent: CQC badge, key stats, focus ring outlines, care-line focal point; if it appears more than three times on a page, remove one). Aliased as `$amber` in the design-system role variables for backward-compatible naming.
- `$success: #78A345` (brand green)
- `$dark: #2D2D2D` (aliased as `$ink` — headings color)
- `$light: #FAFAFA` (aliased as `$surface` — section background alternation)
- `$mist`: computed neutral border tone (`mix($dark, $white, 10%)`) — borders, card edges, table lines
- `$white: #FFFFFF`
- `$body-color: #333333` on `$body-bg: #FFFFFF`
- Semantic: danger `#B3261E` (unchanged — kept distinct from the brand red).

**Typography (self-hosted, `font-display: swap`):**
- Display/headings: **Bricolage Grotesque** — warm, characterful, set tight (`letter-spacing: -0.01em`), weights 600/700 only.
- Body/UI: **Public Sans** — clear, institutional, weights 400/600.
- Type scale (rem): 3.25 / 2.375 / 1.75 / 1.375 / 1.125 / 1 / 0.875. Line-height 1.15 display, 1.6 body. Max text measure 68ch.

**Signature element — the "care line":** a single continuous 2px SVG curve in `$mist` (secondary orange at one focal point) that flows under the hero headline and reappears as the section divider throughout the site. It is the one memorable device; everything else stays disciplined. Implement once as a Blade component `<x-care-line>` with variants `hero|divider|footer`.

**Layout:** 12-col Bootstrap grid, `max-width: 1200px` container, 8pt spacing scale, generous whitespace (`section padding-block: clamp(4rem, 8vw, 6.5rem)`), cards with 12px radius, 1px `$mist` border and a soft shadow only on hover. Alternate `$white` / `$surface` sections. Photography treated with a subtle brand-red duotone overlay for cohesion.

**Tone of copy:** plain English, warm and specific ("We support 40+ people across West Yorkshire", not "innovative care solutions"). Buttons say what they do: "Make an enquiry", "See current roles", "Read the CQC report".

## jQuery & JavaScript rules (effects with restraint)

jQuery 3.7 is loaded site-wide (deferred, self-hosted) and powers **bespoke effects only**:

- `reveal.js` — IntersectionObserver adds `.is-revealed`; jQuery orchestrates staggered child reveals (80ms steps) on cards, stats and timeline items. One elegant entrance per section, nothing perpetual.
- `navbar.js` — shrinks header and adds shadow after 24px scroll; accessible off-canvas toggle state syncing (`aria-expanded`).
- `counters.js` — animates stat numbers once on first reveal (800ms ease-out).
- `smooth.js` — smooth-scrolls same-page anchors with header offset; sets focus to target for accessibility.
- `forms.js` — inline validation UX (Bootstrap `was-validated`), character counters, multi-step referral transitions (fade/slide 200ms), disabled-with-spinner submit states.
- `testimonials.js` — pauses the carousel on hover/focus, wires prev/next `aria` state.

**Hard rules:** every effect respects `prefers-reduced-motion: reduce` (checked once in `app.js`, effects downgrade to instant); no effect blocks content (content is visible without JS — progressive enhancement); no scroll-jacking, no parallax on body copy, no autoplay video; total JS budget ≤ 90KB gzipped including jQuery; all handlers namespaced (`.on('click.lc', …)`).

## Engineering discipline

- **Conventional commits** (`feat:`, `fix:`, `test:`, `chore:`, `docs:`), small and scoped; commit at each checkpoint marked ✅.
- **Tests first-class from Phase 1:** Pest for unit/feature, Playwright for E2E, axe-core in CI. A phase is not complete with failing or skipped tests.
- **Structure:** domain folders `app/Domain/{Content,Forms,Careers,Newsletter}` each holding Models, Policies, Requests, Jobs, Notifications; thin controllers; Blade components in `resources/views/components`.
- Run `composer audit` and `./vendor/bin/pint` before every commit.
- When something in these instructions conflicts with convenience, these instructions win. When genuinely ambiguous, choose the more secure and more accessible option and note the decision in `docs/decisions.md`.

## Phased delivery

Phase 1 Foundations · Phase 2 Content Engine · Phase 3 Public Frontend · Phase 4 Forms Pipeline · Phase 5 Careers & CV Pipeline · Phase 6 Newsletter · Phase 7 Hardening & Audit · Phase 8 cPanel Deployment & Launch. Full phase-by-phase instructions are in `docs/reference/Liberty-Centre-Claude-Code-Build-Prompt-v1.0.md`. Run phases in order; do not start a phase until the previous one's Definition of Done is met.

## Definition of Done (every phase)

- All listed tests pass locally and in CI; no skipped tests.
- `pint` clean, `larastan` level 6 clean, `composer audit` clean.
- No CSP violations in the browser console on touched pages.
- axe-core: zero critical/serious on touched templates.
- Conventional commits pushed; phase demo notes appended to `docs/decisions.md`.
