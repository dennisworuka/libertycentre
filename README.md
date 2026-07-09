# Liberty Centre Limited

Corporate website and CMS for a CQC-registered specialist care provider, built for cPanel shared hosting.

Liberty Centre supports people with special needs through specialist, person-centred care services.

## Stack

- Laravel 12, PHP 8.3
- Filament 3 admin panel at `/admin`
- Blade templates with Bootstrap 5.3 and committed public CSS
- MySQL 8 / MariaDB-compatible production database
- Database queue processed by cron with `queue:work --stop-when-empty`
- Scheduler via cron every minute
- SMTP mail, configurable per environment

## Hosting Model

The application code is intended to live above the web root. Only `public/` should be web-accessible. Redis and persistent queue workers are not required; shared-hosting cron drives scheduled tasks and queue draining.

## Local Tooling

This workspace includes a portable PHP and Composer toolchain under `.tools/` for local development on this machine. It is ignored by Git.

```powershell
.\.tools\php\php.exe artisan serve
.\.tools\php\php.exe artisan test
.\.tools\php\php.exe .\.tools\composer.phar install
```

## Phases

### Prompt 0: Project Setup & Standards

Fresh Laravel 12 scaffold, Filament 3 at `/admin`, hosting-aware environment defaults, brand CSS, base layout, cookie-consent stub, and phase folders.

### Phase 1: Foundation

Auth, MFA, roles, site settings, media library, menus, audit log, and dashboard.

### Phase 2: Pages & Homepage

Flexible page system, homepage slider, full homepage, header/footer, and design system.

### Phase 3: Core Content

Services, about/team, compliance pages, FAQs, downloads, easy read, and branded error pages.

### Phase 4: Referrals & Enquiries

Secure referral and enquiry forms, submission management, private document downloads, notifications, and retention.

### Phase 5: Recruitment

Careers, vacancies, applications, CV management, pipeline, and GDPR tooling.

### Phase 6: Publishing

News, events, gallery, testimonials, case studies, and homepage pull-throughs.

### Phase 7: Newsletter

Double opt-in subscriptions, campaign builder, chunked sending, unsubscribe, bounce handling, and reporting.

### Phase 8: SEO, Performance & Accessibility

Structured data, sitemap, robots, redirects, performance tuning, and accessibility audit automation.

### Phase 9: Launch Hardening & Handover

Security headers, cookie consent, backups, full testing, deployment runbook, and handover pack.
