# Liberty Centre Limited — Claude Code Build Prompt v1.0

**Companion to:** Web Application Specification v1.0 (July 2026)
**Stack:** Laravel 12 · Filament 3 · Bootstrap 5.3 · jQuery 3.7 · MySQL 8 · cPanel target
**Workflow:** VS Code + Claude Code, phased delivery, conventional commits, tests from Phase 1

---

## How to use this document

1. Open the project folder in VS Code and start Claude Code.
2. Paste the **MASTER CONTEXT** below as your first message in every new session (or save it as `CLAUDE.md` in the repo root — recommended).
3. Run the phases **in order**. Paste one phase prompt, let Claude Code complete it, review the diff, run the tests, then commit before moving on.
4. Never skip the acceptance checks at the end of each phase. If any check fails, tell Claude Code exactly which check failed and paste the error output.

---

# MASTER CONTEXT — save as `CLAUDE.md`

You are the lead full-stack engineer building the production website and CMS for **Liberty Centre Limited**, a CQC-regulated (Good, 2026) specialist care provider supporting people with autism and learning disabilities in the UK. This is a real client build, not a demo. Quality bar: a corporate, polished, trustworthy site that a family or NHS commissioner would judge as professional within five seconds — and an architecture a security auditor would sign off.

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

The visual identity must feel like an established, quietly confident care organisation — not a tech startup, not a template. Implement it exactly:

**Palette (SCSS variables, WCAG-checked):**
- `$primary: #156864` (Liberty teal — headings, buttons, links)
- `$ink: #12211F` (near-black text)
- `$surface: #F6FAF9` (section background alternation)
- `$mist: #DCEBE8` (borders, card edges, table lines)
- `$amber: #D9A441` (single accent — used ONLY for the CQC badge, key stats and focus ring outlines; if amber appears more than three times on a page, remove one)
- `$white: #FFFFFF`
- Semantic: success `#2E7D32`, danger `#B3261E`, both AA on white.

**Typography (self-hosted, `font-display: swap`):**
- Display/headings: **Bricolage Grotesque** — warm, characterful, set tight (`letter-spacing: -0.01em`), weights 600/700 only.
- Body/UI: **Public Sans** — clear, institutional, weights 400/600.
- Type scale (rem): 3.25 / 2.375 / 1.75 / 1.375 / 1.125 / 1 / 0.875. Line-height 1.15 display, 1.6 body. Max text measure 68ch.

**Signature element — the "care line":** a single continuous 2px SVG curve in `$mist` (amber at one focal point) that flows under the hero headline and reappears as the section divider throughout the site. It is the one memorable device; everything else stays disciplined. Implement once as a Blade component `<x-care-line>` with variants `hero|divider|footer`.

**Layout:** 12-col Bootstrap grid, `max-width: 1200px` container, 8pt spacing scale, generous whitespace (`section padding-block: clamp(4rem, 8vw, 6.5rem)`), cards with 12px radius, 1px `$mist` border and a soft shadow only on hover. Alternate `$white` / `$surface` sections. Photography treated with a subtle teal duotone overlay for cohesion.

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

- **Conventional commits** (`feat:`, `fix:`, `test:`, `chore:`, `docs:`), small and scoped; commit at each checkpoint I mark ✅.
- **Tests first-class from Phase 1:** Pest for unit/feature, Playwright for E2E, axe-core in CI. A phase is not complete with failing or skipped tests.
- **Structure:** domain folders `app/Domain/{Content,Forms,Careers,Newsletter}` each holding Models, Policies, Requests, Jobs, Notifications; thin controllers; Blade components in `resources/views/components`.
- Run `composer audit` and `./vendor/bin/pint` before every commit.
- When something in these instructions conflicts with convenience, these instructions win. When genuinely ambiguous, choose the more secure and more accessible option and note the decision in `docs/decisions.md`.

---

# PHASE 1 — Foundations, Auth, RBAC & Settings

**Paste this after the master context:**

Build the project foundations.

1. `laravel new` scaffold (Laravel 12, PHP 8.3). Configure `database` drivers for queue/cache/session; `.env.example` fully documented. Add Pint, Pest, Larastan (level 6) and a GitHub Actions workflow running pint-check, larastan, `composer audit` and the Pest suite on every PR.
2. Install and configure Filament 3 at `/admin`. Brand the panel with the Steady Hands palette and the Liberty logo placeholder.
3. Implement the security-headers middleware from the non-negotiables: CSP with per-request nonce exposed as `@nonce` Blade directive, HSTS (max-age 15552000), frame/content-type/referrer/permissions headers. Feature-test that every header is present on `/` and `/admin/login`.
4. Auth hardening: mandatory TOTP 2FA on Filament login (google2fa), recovery codes generated once and shown once; login rate limiting (5/min/IP) plus per-account progressive lockout; session idle timeout 30 min on `/admin`; session regeneration on login. Admin path configurable via `ADMIN_PATH` env.
5. RBAC with spatie/laravel-permission: roles `super_admin`, `editor`, `recruiter`, `newsletter_manager`, `viewer` with the permission matrix from the specification (Section 6.1). Seeder creates one super admin (credentials from env) with 2FA provisioned. Gate Filament navigation and every future resource through policies — create a `BasePolicy` establishing deny-by-default.
6. Activity log configured: log auth events, and a reusable trait `LogsAdminActivity` for models.
7. Settings module (spatie/laravel-settings) with the eight groups from spec Section 6.2 (Organisation, Contact, CQC, Notifications, Social & SEO, Announcement, Compliance, Maintenance). Build the Filament Settings pages grouped accordingly; `Compliance` includes editable retention periods (integers, months) used by later purge jobs. Maintenance mode toggle uses Laravel's secret-bypass mechanism.
8. Vite pipeline: SCSS entry importing customised Bootstrap 5.3 (`_variables.scss` implementing the palette/typography/radius/spacing from the design system), `app.js` entry loading jQuery 3.7 (self-hosted), the reduced-motion check, and empty module stubs for `reveal/navbar/counters/smooth/forms/testimonials`. Self-host Bricolage Grotesque + Public Sans with `font-display: swap`.

**Tests (must pass):** headers present; 2FA required (login without TOTP fails); lockout after 5 attempts; each role's Filament access matches the matrix; settings persist and cache-bust; viewer cannot modify settings.
✅ Commit series: `chore: scaffold laravel 12 + tooling`, `feat: security headers with csp nonce`, `feat: filament auth with mandatory 2fa`, `feat: rbac roles and base policy`, `feat: grouped site settings module`, `chore: vite + bootstrap 5.3 design tokens`.

---

# PHASE 2 — Content Engine (CMS Collections)

Build the content domain in `app/Domain/Content`.

1. Models + migrations + Filament resources: `Page`, `Service`, `Post` (news), `Testimonial`, `TeamMember`, `NavigationItem`, `Redirect`. All publishable models share a `Publishable` trait (`draft/published/scheduled` status, `published_at`, scope `published()`), a `revisions` table (snapshot JSON on every save, restorable from Filament), and auto-slugs (unique, locked after first publish — changing a locked slug auto-creates a 301 `Redirect`).
2. Block-based bodies: a Filament Builder field with blocks `heading`, `rich_text`, `image`, `feature_list`, `steps`, `faq`, `quote`, `cta`, `two_column`. Rich text runs through HTMLPurifier (allow-list config committed) in a model mutator — sanitise on save.
3. Media library (spatie/medialibrary): alt text is a required custom property (Filament form blocks publish if empty); conversions to WebP at 480/960/1440 widths; served with immutable cache headers.
4. `Testimonial` has a required `consent_on_file` boolean; a model-level guard blocks publishing without it and the Filament action explains why.
5. Navigation builder (nested, two levels) powering header/footer menus; `Redirect` resource with hit counter; middleware applies redirects before 404.
6. Seeders: realistic placeholder content — 5 services (Autism support, Learning disability support, Supported living, Respite & short breaks, Community outreach), 6 news posts across 3 categories, 4 testimonials, 5 team members, nav structure. Copy follows the "plain, warm, specific" tone rules.

**Tests:** slug lock + redirect creation; purifier strips `<script>` and event attributes but keeps allowed markup; unpublished content invisible to `published()`; testimonial publish blocked without consent; revision restore round-trip; editor can publish, viewer cannot.
✅ Commits: `feat: publishable content models with revisions`, `feat: block builder with purified rich text`, `feat: media library with mandatory alt text`, `feat: navigation and redirect manager`, `chore: placeholder content seeders`.

---

# PHASE 3 — Public Frontend (Corporate Design Build)

Build every public template with Blade + Bootstrap 5.3 + the jQuery effect modules. Follow the Steady Hands system exactly; this phase decides whether the site looks corporate and attractive, so treat spacing and typography as precision work.

1. **Base layout** `layouts/app.blade.php`: skip link, semantic landmarks, meta/OG/Twitter partial fed by per-page SEO fields with settings fallbacks, JSON-LD component, nonce-bearing script tags, footer with four columns + newsletter form stub + legal bar + CQC badge (links to official report URL from settings, `rel="noopener"`).
2. **Header**: logo, nav from NavigationItem, phone `tel:` link, "Make an enquiry" button; sticky with `navbar.js` shrink behaviour; below `lg` an off-canvas menu — focus-trapped, `Esc` closes, `aria-expanded` synced.
3. **Components**: `<x-care-line variant>`, `<x-section>`, `<x-card.service>`, `<x-card.post>`, `<x-stat>`, `<x-cqc-badge>`, `<x-testimonial-carousel>` (Bootstrap carousel, pause on hover/focus via `testimonials.js`, visible controls, `aria-live="polite"`), `<x-faq-accordion>`, `<x-cta-band>`, `<x-breadcrumbs>` (with BreadcrumbList JSON-LD).
4. **Templates**: Home (hero with care-line, trust bar with animated `<x-stat>` counters, services grid, approach strip, testimonials, latest news, careers band with live vacancy count placeholder, newsletter CTA), About, Our Approach, Services hub + Service detail (block renderer + Service JSON-LD), CQC & Quality (per-question ratings table from settings), News hub (category filter + pagination) + Article (Article JSON-LD, related posts), Referrals (copy only this phase), Contact (details/map placeholder), Newsletter page, the five policy pages rendered from `Page`, Safeguarding, and branded 404/403/500/503.
5. **Cookie consent**: no non-essential scripts before consent; equal-prominence Accept/Reject + granular analytics toggle; preference stored 6 months; re-openable from footer; map embed and analytics load only after consent. CSP-compatible (module JS, no inline).
6. Wire `reveal.js`, `counters.js`, `smooth.js` per the jQuery rules — staggered card reveals on Home/Services/News, counters on the trust bar, smooth anchors on policy pages. Verify with `prefers-reduced-motion` emulation that all animation collapses to instant.
7. `sitemap.xml` (auto from published content), `robots.txt`, RSS at `/news/feed`.

**Acceptance:** axe-core zero critical/serious on every template; full keyboard walk of header/off-canvas/carousel/accordion documented; Lighthouse mobile ≥ 90 performance / 100 accessibility on Home + Service + Article; CSP report-only log clean, then enforce.
✅ Commits: `feat: base layout, header, footer with cookie consent`, `feat: care-line and core ui components`, `feat: home page`, `feat: services and cqc templates`, `feat: news hub and article`, `feat: policy + error pages`, `feat: jquery effect modules wired`, `test: e2e smoke + axe across templates`.

---

# PHASE 4 — Forms Pipeline (Contact & Referral)

Build `app/Domain/Forms` implementing the hardened shared pipeline from spec Section 7.

1. **Shared pipeline:** `FormSubmission` model (polymorphic `type`, encrypted `payload` cast, `status` New/InProgress/Closed, `assigned_to`, `reference` like `LC-2026-0001`); every submission stores first, then dispatches a queued `SendFormNotification` (3 tries, exponential backoff) to the recipient configured per form type in Settings, plus a queued branded acknowledgement to the submitter. A daily `forms:alert-failed` scheduled command emails super admins any failed notification jobs — zero silent loss.
2. **Anti-spam stack on every public form:** Cloudflare Turnstile (server-verified), spatie honeypot, minimum-time-to-submit (reject < 3s), throttle `5,10` per IP per form. All four are individually feature-tested.
3. **Contact form** exactly per spec 7.1 (fields, lengths, enquiry types, service select populated from published Services, preferred contact method, privacy confirmation linking `/privacy`). Bootstrap validation styling driven by `forms.js`; server errors re-render with `aria-describedby` links and an `aria-live` summary.
4. **Referral form** as a 4-step server-side wizard (session-held state, back navigation preserves input, one topic per step, progress indicator, review step): referrer details → person referred (initials/first name only, age band, LA area, funding status) → support needs (services multi-select, brief overview with guidance text, urgency) → review + submit. Confirmation screen shows the reference number and next-steps copy. Referral submissions are flagged high-priority and notify the referrals address immediately.
5. **Filament inboxes:** Contact and Referral resources (read-only payload render, status board, assignment, internal notes); referral list badge-counts `New`. CSV export gated to super_admin and audit-logged.
6. Retention: nightly `forms:purge` honours the Settings retention months (contact 12, referral 6 by default), logs type+count only.

**Tests:** happy path stores→notifies→acknowledges (queue asserted); each spam layer rejects; rate limit enforced; wizard back-navigation keeps data; payload encrypted in DB (raw column assertion); purge respects settings; recruiter cannot see form inboxes.
✅ Commits: `feat: form submission pipeline with queued notifications`, `feat: layered anti-spam stack`, `feat: contact form`, `feat: referral wizard`, `feat: filament form inboxes`, `feat: retention purge for submissions`.

---

# PHASE 5 — Careers & Secure CV Pipeline

Build `app/Domain/Careers`. This phase handles the most sensitive data — implement the upload pipeline exactly.

1. **Vacancy** model/resource: title, slug, location, contract type, salary range, closing_date, rich description blocks, status Draft/Published/Closed; scheduled command auto-closes at closing_date; closed vacancy URLs return the "position closed" page (410) linking live roles. `JobPosting` JSON-LD on vacancy detail (Google for Jobs eligible).
2. **Careers hub**: employer value proposition section, benefits grid, staff quotes, live vacancy list with location/contract filters (server-side, crawlable URLs). Careers band on Home now shows the real live count.
3. **Application form** (vacancy detail + `/careers/register-interest`) per spec 7.3, including right-to-work radio and unticked-by-default talent-pool consent.
4. **Hardened upload:** accept PDF/DOC/DOCX ≤ 5MB; validate by finfo MIME sniff of content (not extension); random UUID filename; store on `cvs` private disk (`storage/app/private/cvs`, encrypted filesystem driver); original filename kept as sanitised display metadata only. Reject double-extension and content/extension mismatch with clear errors. If `CLAMAV_SOCKET` is configured, scan and quarantine on detection; otherwise the no-execution-path posture applies.
5. **Application model:** encrypted casts on name/email/phone/cover message; belongsTo vacancy (nullable for speculative); `retention_date` computed (6 months post-closure, or 12 months rolling with consent).
6. **Recruiter workspace in Filament:** per-vacancy Kanban board (New → Shortlisted → Interview → Offer → Rejected → Withdrawn), applicant notes, templated outcome emails, CV download only through a signed, time-limited (15 min), policy-gated route that streams with `Content-Disposition: attachment` + `nosniff` — every view/download audit-logged with user+IP.
7. **Retention automation:** purge job for expired applications with a 14-day advance-notice email containing a one-click consent-extension signed link; talent-pool refresh email at 11 months.

**Tests:** MIME spoof (exe renamed .pdf) rejected; oversize rejected; stored file unreachable by direct URL; signed link expires; viewer/editor denied CV download (policy test); encrypted columns asserted raw; auto-close flips status and page returns 410; retention purge + notice email; JobPosting JSON-LD validates.
✅ Commits: `feat: vacancies with auto-closure and jobposting schema`, `feat: careers hub and filters`, `feat: hardened cv upload pipeline`, `feat: recruiter application board`, `feat: application retention automation`.

---

# PHASE 6 — Newsletter Module

Build `app/Domain/Newsletter` per spec Section 8.

1. **Subscribers:** model with status Pending/Subscribed/Unsubscribed/Bounced, `consent_at/ip/source`, signed single-use confirm token (24h). Public endpoints: subscribe (footer + `/newsletter` + article CTA), `newsletter/confirm/{token}`, `newsletter/unsubscribe/{token}` (instant, no login, RFC 8058 one-click POST supported). Unconfirmed auto-delete after 7 days; unsubscribed profile data purged after 30 days with suppression hash retained.
2. **Campaign builder in Filament:** block composer (heading, rich text, image, button, article-picker pulling title/image/excerpt from Posts) rendering into a pre-built MJML-compiled responsive template (committed as compiled Blade) with auto plain-text part. Workflow Draft → Test sent → Scheduled/Sending → Sent; live send is disabled until a test send to admin addresses has succeeded for the current revision.
3. **Sending:** `SendCampaignBatch` job chunked at the Settings-configurable rate (default 50/min) via the cron-driven queue; audience is locked to Confirmed subscribers minus suppression list at dispatch time; per-send record captures status; hard bounces (webhook or IMAP-poll stub, provider-agnostic interface) auto-suppress after 2 events. `List-Unsubscribe` + `List-Unsubscribe-Post` headers on every campaign email; footer includes postal address from Settings and the unsubscribe link.
4. **Compliance tooling:** per-subscriber export (SAR) and hard delete; CSV import disabled by default — enabling requires super_admin and writes a justification to the activity log. Open tracking OFF by default; a Settings toggle enables it and injects the documented notice into the signup copy.

**Tests:** double opt-in round trip; expired/reused token rejected; unsubscribe idempotent and suppresses future sends; send blocked without test send; batch respects rate and skips suppressed; newsletter_manager cannot access other CMS areas.
✅ Commits: `feat: double opt-in subscriptions`, `feat: campaign builder with mjml template`, `feat: batched cron-driven sending with suppression`, `feat: subscriber sar tools`.

---

# PHASE 7 — Hardening, Accessibility & Performance Audit

No new features. Make the build pass the launch gate.

1. **Security sweep:** run `composer audit` (zero known vulns), OWASP ZAP baseline against staging (resolve every High/Medium), verify securityheaders.com grade A, walk the access-control matrix as an automated Pest dataset (every role × every route/action), attempt the upload attack set again on staging, confirm `.env`/storage/git paths return 403/404 via `.htaccess`.
2. **Accessibility audit:** axe CI green across all templates and both viewports; manual NVDA + VoiceOver pass on Home, Service, Referral wizard, Application form, cookie banner; fix and document. Publish the Accessibility Statement content.
3. **Performance:** full-page response cache for anonymous GETs (invalidated on publish), image `loading=lazy` + `fetchpriority` on heroes, verify JS ≤ 90KB gz / critical CSS inline ≤ 12KB with nonce, Lighthouse CI budgets enforced on Home/Service/Vacancy/Article (≥ 90 mobile perf, LCP < 2.5s, CLS < 0.1, INP < 200ms).
4. **Ops:** spatie/laravel-backup nightly encrypted off-server dump + storage (30-day rotation) with restore-test doc in `docs/restore-runbook.md`; `health:check` scheduled command alerting on failed jobs/queue backlog/low disk; uptime-monitor endpoints.
5. **GDPR pack in `docs/`:** privacy notice + cookie policy final copy (loaded into Pages), retention schedule matching Settings defaults, processing inventory, short-form DPIA (CV pipeline + referral form), processor list. Add `gdpr:subject-report {email}` artisan command aggregating a person's data across submissions/applications/subscribers.

✅ Commits: `test: role-route access matrix`, `fix: zap findings`, `perf: response cache + budgets`, `feat: backups, health checks`, `docs: gdpr pack + runbooks`.

---

# PHASE 8 — cPanel Deployment & Launch

1. Write `docs/deploy-cpanel.md` and implement `deploy/post-deploy.sh`: cPanel Git Version Control pull of the release tag → `composer install --no-dev --optimize-autoloader` → `php artisan migrate --force` (preceded by automatic DB dump) → `config:cache route:cache view:cache event:cache` → `storage:link`. Document MultiPHP 8.3 settings (memory 256M, upload/post 8M, OPcache), the single cron line, document-root mapping to `public/` with the hardened `.htaccess` fallback, AutoSSL + HSTS enablement, and SPF/DKIM/DMARC records for the sending domain (DMARC `p=quarantine` → `p=reject` after 30 days).
2. Staging first: password-protected, `noindex` subdomain on the same account; run the full E2E suite and a real newsletter test send there.
3. Launch checklist (execute and tick in `docs/launch-checklist.md`): all spec Section 16 acceptance criteria; forms verified end-to-end on production (submission → inbox → notification → acknowledgement); CV pipeline attack-tested on production infra; double opt-in round trip on the live domain; DNS cutover; sitemap submitted; 301s verified; monitoring alerts firing to the right inbox.
4. Handover: 45-minute admin training outline + `docs/editor-guide.md` with annotated screenshots for Settings, Pages, News, Vacancies/Applications, Newsletter; 30-day hypercare notes template.
5. Tag `v1.0.0`, protect `main`, enable Dependabot, diarise the monthly patch window.

✅ Commits: `docs: cpanel deploy runbook`, `chore: post-deploy script`, `docs: launch checklist + editor guide`, `chore: v1.0.0`.

---

# Definition of Done (applies to every phase)

- All listed tests pass locally and in CI; no skipped tests.
- `pint` clean, `larastan` level 6 clean, `composer audit` clean.
- No CSP violations in the browser console on touched pages.
- axe-core: zero critical/serious on touched templates.
- Conventional commits pushed; phase demo notes appended to `docs/decisions.md`.

# If Claude Code goes off-track (recovery prompts)

- "Stop. Re-read the security non-negotiables in CLAUDE.md. Point out which of them your last change violates, then fix it."
- "This must run on cPanel shared hosting with no daemons. Refactor to the cron-driven queue pattern."
- "The design is drifting from the Steady Hands system. List every hard-coded colour/font you introduced, replace them with the SCSS tokens, and remove all but one animation from this section."
- "Show me the failing test output, state the root cause in one sentence, then fix the cause — not the test."
