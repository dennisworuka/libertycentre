LIBERTY CENTRE LIMITED
Website & CMS Specification Document
Document Version: 1.0
Date: July 2026
Project: Corporate Website & Content Management System
Client: Liberty Centre Limited (CQC-Registered Specialist Care Provider)
Hosting Environment: Dedicated Server
Status: For Approval
Prepared by: Prince Woruka
CQC Good Rating — 2026
1. Executive Summary
Liberty Centre Limited requires a professional, standards-compliant website with an integrated Content Management System (CMS). The platform will present the organisation's care services to families, local authorities, and healthcare professionals; capture referrals and enquiries securely; operate a recruitment portal with CV management; and provide the Liberty Centre team with a straightforward admin panel to manage all site content without developer involvement.
As a CQC-registered provider recently awarded a good rating (2026), the website must reflect the same standards of safeguarding, transparency, accessibility, and data protection that CQC expects of the care itself. This document defines every page, feature, workflow, data structure, security control, and compliance measure required to deliver that outcome.
1.1 Project Goals
Present Liberty Centre's services clearly and accessibly to service users, families, commissioners, and professionals.
Convert visitors into referrals and enquiries through prominent, secure, easy-to-use forms.
Operate a recruitment portal that accepts CV submissions and manages applicants through a structured pipeline.
Give staff full control of content — pages, sliders, news, gallery, testimonials, FAQs, newsletters — via a role-based CMS.
Meet or exceed UK GDPR, PECR (cookies/e-marketing), WCAG 2.2 AA accessibility, and CQC information-transparency expectations.
Run reliably and securely on cPanel shared hosting.
1.2 Success Criteria
2. Technical Architecture
2.1 Technology Stack
2.2 cPanel Hosting Constraints & Mitigations
2.3 High-Level Architecture
[Visitor Browser]      │ HTTPS (forced)▼[cPanel Apache/LiteSpeed → public_html → Laravel public/]│├── Blade Frontend (Bootstrap 5.3)├── Filament 3 Admin Panel  (/admin — MFA protected)│▼[Laravel 12 Application Layer]├── Form handling (validation, CSRF, spam protection)├── Queued mail (confirmations, notifications, newsletters)├── Media library (secure storage, image conversions)▼[MySQL 8]        [Private storage/ for CVs & referral documents]
Critical rule: uploaded CVs and referral documents are stored in storage/app/private (outside the web root) and served only through authenticated, signed, permission-checked download routes — never as direct public URLs.
3. Brand & Design System
3.1 Official Colour Palette
Supporting neutrals: #FFFFFF (backgrounds), #F8F6F3 (warm off-white section alternation), #212529 (body text), #5C5C5C (muted text — only on white, min 7:1 where possible).
3.2 Colour Accessibility Rules (WCAG 2.2 AA)
Body text: #212529 on white/off-white (contrast ≈ 16:1).
Deep Brick Red #B14040 on white: contrast ≈ 5.0:1 — passes AA for normal text; use for headings, buttons with white text (white on #B14040 ≈ 4.2:1 → use bold ≥ 18.66px or darken to #A03636 for small button text).
Olive Green #77A244 on white: ≈ 3.0:1 — large text / decorative use only; for text use #5E8230 (darkened AA-safe variant defined as --lc-secondary-text).
Never convey meaning by colour alone (e.g., form errors use icon + text + colour).
Focus outline: 3px solid #C36844 with 2px offset on all interactive elements.
3.3 Typography
Rationale: care-sector audiences include older family members and users with visual or cognitive differences — larger base type, generous line-height, and short line lengths (max 70ch) are specified throughout.
3.4 Component Standards
Buttons: Primary (--lc-primary, white text, hover --lc-primary-dark), Secondary (outline red), CTA (--lc-accent), Success/positive (--lc-secondary-dark). Min touch target 44×44px.
Cards: All homepage feature/service cards include an image (16:9, lazy-loaded, mandatory alt text — the CMS validates alt text on save), title, 2-line summary, and a "Learn more" link with descriptive aria-label.
Forms: Labels always visible (no placeholder-only labels), inline validation with aria-describedby error messages, logical tab order, autocomplete attributes.
Corners & shadows: 12px radius, soft shadows — warm, approachable, non-clinical aesthetic.
4. Site Map & Page Inventory
4.1 Public Pages
4.2 Global Elements (every page)
Header: Logo (CMS-managed), primary navigation (CMS-managed menu builder), phone number click-to-call, "Make a Referral" button (accent orange), "Contact Us" button.
Footer: Contact details, CQC rating badge/widget with link to the CQC report, quick links, compliance page links, newsletter signup, social media links, company registration & CQC provider ID.
Cookie consent banner: Blocks non-essential cookies until consent; granular accept/reject; preference centre; consent logged (PECR/UK GDPR).
Accessibility toolbar (optional toggle): text size increase, high-contrast mode.
Translation: language selector (browser-native translate integration or Weglot-style service), plus Easy Read links.
Floating WhatsApp / live chat button (CMS toggle, configurable number).
Skip-to-content link as first focusable element.
5. Homepage Specification
Section order (each section CMS-toggleable and reorderable):
Hero Slider — up to 5 slides, each with: background image (CMS, with focal point crop), heading, subheading, up to 2 buttons (label/URL/style), overlay opacity control for text contrast, per-slide alt text. Auto-advance 7s, pause on hover/focus, visible pause button (WCAG 2.2.2), swipe-enabled, reduced-motion respected (prefers-reduced-motion → static first slide).
Intro strip — "Empowering Lives. Supporting Independence. Inspiring Possibilities." + short welcome paragraph + CQC Good Rating 2026 badge.
Quick Service Links — 5 service cards, each with an image (CMS-enforced), icon, title, one-line summary, link. Keyboard-navigable card grid.
Make a Referral CTA band — full-width band (brick red), white text, "Make a Referral" (orange button) + "Contact Us" (outline white).
Why Liberty Centre / stats — 20 Years' Experience, 50+ Service Users, CQC Good 2026, boroughs covered. Animated counters (reduced-motion safe).
CQC & Quality Assurance — rating badge, link to full CQC report, summary of quality commitments.
Testimonials / Family Feedback carousel — CMS-managed quotes (name/relationship optional, consent flag required in CMS before publish).
Latest News & Events — 3 most recent posts + next 2 upcoming events.
Coverage map strip — boroughs served (Barking & Dagenham, Havering, Waltham Forest, Bromley, parts of Essex) with embedded Google Map (loads only after cookie consent).
Newsletter signup — email + consent checkbox, double opt-in.
Emergency / urgent contact strip — out-of-hours number, safeguarding contact, local authority emergency duty team signposting.
6. Service Page Template
Every service page (Autism Support, Supported Living, Domiciliary Care, Community & Life Skills, Respite/Short Breaks) uses one structured template managed in the CMS with these sections:
Hero (image + title + one-line summary)
Overview of the service
Who the service is for (eligibility snapshot)
What support looks like (day-to-day description; supports bullet lists and image/text rows)
How care is personalised — person-centred planning, communication approaches (TEACCH, PECS), strengths-based goals
Eligibility and access — funding routes (local authority, NHS CHC, private), assessment process
Referral process — numbered steps + "Make a Referral" button
Benefits to service users
Family & professional involvement
Related testimonial (optional pull-through)
FAQ block (service-specific, optional)
Call-to-action — referral + contact buttons, phone number
CMS model: each section is a flexible block; editors can hide/reorder blocks but the template enforces heading hierarchy (single H1, sequential H2/H3) for accessibility and SEO.
7. Referral & Enquiry System
7.1 Online Referral Form (/referral)
Multi-step (3 steps, progress indicator, save-per-step validation):
Step 1 — Referrer details: name, role/relationship (self / family / social worker / health professional / other), organisation (optional), phone, email.
Step 2 — Person being referred: name, DOB (optional at referral stage), borough/local authority, current living situation, primary support needs (checkbox list: autism, learning disability, communication, personal care, behaviour support, other), services of interest (multi-select of the 5 services), funding status (known/unknown/private), urgency (routine / soon / urgent — urgent displays the phone number prominently and flags the submission).
Step 3 — Supporting information: free-text summary (max 3,000 chars), document upload (up to 3 files; PDF/DOC/DOCX/JPG/PNG; 10MB each; virus-scan hook; stored privately), preferred contact method/time, consent checkbox (explicit, unticked by default, links to Privacy Policy: "I consent to Liberty Centre processing this information to assess and respond to this referral"), optional marketing consent (separate checkbox).
On submission:
Server-side validation + CSRF + honeypot + time-trap + Cloudflare Turnstile (or hCaptcha) — layered spam protection without excluding assistive-tech users.
Record stored with status New; unique reference number generated (e.g. REF-2026-00042).
Auto-confirmation email to referrer (reference number, what happens next, expected response time, urgent contact number). Queued.
Admin notification email to configurable recipient list; Urgent referrals additionally trigger a distinct subject prefix.
Thank-you page with reference number and next steps.
Downloadable referral form: professionally designed fillable PDF available on the page for those who prefer email/post, with secure email address stated.
7.2 General Enquiry Form (/contact)
Fields: name, email, phone (optional), subject (dropdown: General / Services / Referral question / Careers / Feedback or complaint / Other), message, consent checkbox. Same spam/security stack. Auto-confirmation + admin notification. "Feedback or complaint" selections surface a link to the Complaints Procedure in the confirmation email.
Contact page also includes: address, phone (click-to-call), email, office hours, emergency/out-of-hours information, Google Map (consent-gated), and safeguarding contact signposting.
7.3 Enquiry & Referral Management (CMS)
Unified Submissions area with separate resources for Referrals, Enquiries, Job Applications, Newsletter subscribers.
List views: reference, name, type, urgency, status, assigned staff member, received date; filters and search.
Statuses: Referrals → New / In Review / Assessment Arranged / Accepted / Declined / Closed; Enquiries → New / In Progress / Responded / Closed.
Detail view: full submission, secure document downloads (signed URLs, permission-checked, access logged), internal notes timeline, status history (audit trail: who changed what, when), assignment to staff user.
Export: CSV export (permission-gated, logged) excluding document contents.
Retention automation: scheduled command anonymises/purges per the retention schedule (Section 15.6); admins receive a monthly digest of items due for deletion.
8. Recruitment Portal & CV Management
8.1 Public Careers Section (/careers)
Intro: working at Liberty Centre, values, training & development, benefits.
Vacancy listing: title, location/borough, contract type (full/part-time, bank), salary/rate, closing date; filter by service area and contract type. Closed vacancies auto-hide at closing date.
Vacancy detail: full description, responsibilities, requirements (including Enhanced DBS requirement statement), how to apply, closing date, share links.
Speculative applications: "No suitable role? Send us your CV" open application form.
8.2 Application Form (per vacancy or speculative)
Fields: name, email, phone, postcode (for travel feasibility), right-to-work confirmation (checkbox), driving licence (yes/no — relevant for outreach roles), CV upload (required; PDF/DOC/DOCX, 5MB), cover message (optional), how they heard about the role, consent checkbox (recruitment privacy notice — states 12-month retention with option to be kept on file), optional consent to be considered for future roles.
Security: identical spam stack; CVs stored in private storage with UUID filenames; MIME + extension + content-type triple validation; optional ClamAV scan via cPanel if available.
Auto-confirmation email to applicant; notification to HR recipient list.
8.3 CV / Applicant Management (CMS)
Pipeline statuses: New → Shortlisted → Interview → Offer → Hired / Unsuccessful / Withdrawn.
Kanban-style or filtered list view per vacancy; applicant detail with CV secure download, notes, status history, email templates (invite to interview / regret) sent from the panel and logged.
Vacancy management: create/edit vacancies (rich text description, salary, closing date, publish/unpublish, duplicate as template).
GDPR tooling: one-click anonymise applicant; automatic purge of unsuccessful applicants 12 months after closure (configurable); talent-pool flag only where future-roles consent was given.
9. Newsletter System
9.1 Subscription
Signup blocks: footer (site-wide), homepage section, /newsletter page, optional post-enquiry checkbox.
Double opt-in: signup → confirmation email with signed verification link → subscribed. Unverified records purged after 30 days.
Consent timestamp, source, and IP recorded (evidential requirement under UK GDPR/PECR).
Every email footer: company details + one-click unsubscribe (signed URL, no login).
9.2 Newsletter Creation (CMS)
Campaign builder: subject, preheader, block-based content editor (heading, rich text, image, button, news-article pull-in, divider) rendered into a responsive, accessibility-checked email template using brand colours.
Preview (desktop/mobile) + send-test-to-self.
Audience: all active subscribers (segmenting by source optional, v2).
Scheduling: send now or schedule; sending is chunked via the queue (e.g. 50 emails/minute) to respect shared-hosting limits, via authenticated SMTP.
Reporting: sent count, delivery failures, unsubscribes per campaign. (Open tracking optional and off by default — privacy-first stance.)
Bounce handling: hard bounces auto-flag subscriber inactive.
10. CMS / Admin Panel Specification (Filament 3, /admin)
10.1 Dashboard
Widgets: new referrals (with urgent highlight), new enquiries, new job applications, newsletter subscriber trend, latest published news, quick links (new news post, new vacancy, new slide), system health (last backup, queue status, scheduled tasks last run).
10.2 Modules
10.3 Site Settings
Identity: site name, logo (header + footer variants), favicon, strapline.
Branding: theme colours (pre-loaded with the official palette; contrast checker warns if an AA-failing combination is chosen), font size scale.
Contact: address, phones, emails, office hours, emergency/out-of-hours details, Google Maps location, WhatsApp number + chat toggle.
Social links: Facebook, Instagram, LinkedIn, X, YouTube.
CQC: provider ID, rating, rating date, report URL (renders the footer/homepage badge).
Forms: recipient lists per form type, urgent-referral extra recipients, auto-reply templates (editable rich text with merge tags), spam protection keys.
SEO & analytics: default meta, robots, GA4/Matomo ID (loads only after cookie consent), organisation schema fields.
Cookie banner: text, policy links, category descriptions.
Maintenance mode toggle with branded holding page (admin bypass).
10.4 Users, Roles & Permissions
Rules: MFA (TOTP) mandatory for all admin users; strong password policy (min 12 chars, breach-list check); session timeout 30 min idle; login rate limiting + lockout; email alert on new-device login; per-role permission matrix enforced at policy level (server-side), not just UI hiding.
11. Compliance & Trust Content
Static-but-CMS-editable pages, each with "last reviewed" date displayed (CQC values current, accurate information):
Privacy Policy / Privacy Notice — controller identity & ICO registration number, lawful bases per processing activity (referrals: legitimate interests/consent + Art. 9(2)(h) for health data; recruitment: pre-contract necessity; newsletter: consent), data categories, recipients, retention periods (mirrors Section 15.6), data subject rights & DSAR contact, complaints route to the ICO.
Cookie Policy — cookie inventory table auto-generated from the consent tool categories.
Safeguarding Statement — commitment to protecting people from abuse, discrimination, avoidable harm and neglect; how to raise a safeguarding concern (internal contact + local authority safeguarding teams for each borough served + emergency 999 guidance).
Complaints Procedure — stages, timescales, escalation to the Local Government & Social Care Ombudsman and CQC contact details.
Whistleblowing Statement
Modern Slavery Statement
Equality, Diversity & Inclusion Statement
Accessibility Statement — WCAG 2.2 AA conformance claim, known limitations, feedback route, alternative formats offer (Easy Read, large print).
Easy Read section:
Simplified, image-supported versions of: About us, our services, how to complain, keeping you safe, Contact us. Produced with short sentences, one idea per line, supporting imagery.
12. Accessibility Specification (WCAG 2.2 Level AA)
13. SEO Specification
Clean semantic URLs (as in Section 4.1); 301 redirect managers in CMS for changed slugs.
Per-page meta title/description, Open Graph & Twitter cards; auto XML sitemap (/sitemap.xml) + HTML sitemap; robots.txt.
Structured data (JSON-LD): Organization + LocalBusiness (with service areas), Service per service page, JobPosting per vacancy (Google Jobs eligibility), FAQPage, Event, Article for news, BreadcrumbList.
Local SEO: borough-specific copy on service pages; Google Business Profile alignment; NAP consistency in footer.
Performance as ranking factor: WebP responsive images, lazy loading, critical CSS, HTTP/2, far-future caching for static assets, target Lighthouse ≥ 90 (Performance, Accessibility, Best Practices, SEO).
Analytics: GA4 or privacy-first Matomo, consent-gated.
14. Email & Notification Matrix
All mail sent via authenticated SMTP; SPF, DKIM, DMARC records documented in the deployment runbook; branded, accessible, mobile-responsive email templates; plain-text alternative part included.
15. Security & Data Protection Specification
15.1 Transport & Platform
SSL/TLS enforced (AutoSSL/Let's Encrypt via cPanel), HTTP→HTTPS 301, HSTS (max-age 1 year, includeSubDomains).
Security headers: Content-Security-Policy (script/style allow-listing, frame-ancestors 'self'), X-Content-Type-Options: nosniff, Referrer-Policy: strict-origin-when-cross-origin, Permissions-Policy (camera/mic/geolocation denied), X-Frame-Options: SAMEORIGIN.
Application code above web root; env inaccessible; directory listing disabled; sensitive paths blocked in .htaccess.
PHP hardened: expose_php off, display_errors off in production, up-to-date PHP 8.3 branch.
cPanel account: strong password + MFA on cPanel itself; ModSecurity/WAF ruleset enabled via host; Imunify360/ClamAV where offered by the host.
15.2 Application Security (OWASP Top 10 aligned)
CSRF tokens on all forms; Eloquent ORM/parameterised queries (SQLi); Blade auto-escaping + explicit sanitisation of rich text via HTML Purifier (XSS); signed URLs for downloads/unsubscribe/verification (tamper-proof); route-model binding with policy checks on every admin action (IDOR prevention); mass-assignment guarded models.
File uploads: extension + MIME + content sniff validation, size caps, randomised UUID filenames, private disk storage, images re-encoded (strips embedded payloads/EXIF), no execution permissions on storage, AV scan hook.
Rate limiting: forms (per IP + per session), login (5 attempts → 15-min lockout + alert), API-less surface (no public API in v1).
Spam defence-in-depth: honeypot + minimum-time trap + Turnstile/hCaptcha + disposable-domain check on newsletter signups.
Dependency hygiene: composer audit in CI; monthly patch window; framework LTS updates.
15.3 Admin Access Security
Mandatory TOTP MFA; strong password policy with HaveIBeenPwned k-anonymity check; 30-minute idle timeout; concurrent-session revocation; admin URL not linked publicly (optionally renamed); full audit log (Section 10.2) retained 24 months; personal-data downloads (CVs, referral docs, CSV exports) individually logged.
15.4 Backups & Recovery
Nightly automated backup: database dump + storage/ (private uploads) — retained 30 days; weekly retained 12 weeks; monthly retained 12 months.
Off-server copy (encrypted, pushed to S3-compatible or remote destination via scheduled task) — backups on the same cPanel account alone are not sufficient.
Quarterly restore test documented. RPO 24h, RTO 8h targets.
15.5 UK GDPR Governance
Lawful bases mapped per data flow (see Privacy Policy, Section 11) — referral data includes special category (health) data: processed under Art. 9(2)(h) (provision of health/social care) with appropriate safeguards, and access restricted to Care Manager/Admin roles.
Data minimisation: forms collect only what's needed to respond; DOB optional at referral stage.
DSAR support: admin search across submissions by name/email; export of an individual's data; erasure/anonymise actions with audit trail.
Consent records: timestamp, wording version, source stored for every consent (forms, newsletter, cookies, testimonial/photo consent flags).
Processors documented: hosting provider, SMTP relay, spam-protection service, analytics — listed in the Privacy Policy with transfer safeguards.
DPIA: a short Data Protection Impact Assessment is recommended before launch given health data + vulnerable individuals; template checklist included in the project handover pack.
Breach response: logging + admin alerts enable detection; runbook includes 72-hour ICO notification procedure and client contact tree.
15.6 Data Retention Schedule (automated)
All periods configurable in Site Settings; monthly automated purge with pre-purge digest email to Super Admin.
16. Data Model Overview (principal tables)
users (admin, role, mfa_secret) · roles / permissions · pages + page_blocks + page_revisions · slides · services + service_blocks · posts (news) + categories · events · galleries + gallery_images (consent_flag) · testimonials (consent_flag) · team_members · case_studies (consent_flag) · faqs · downloads · vacancies · applications (status, cv_path[private]) + application_notes + application_status_history · referrals (urgency, status) + referral_documents (private) + referral_notes + referral_status_history · enquiries · subscribers (verified_at, consent meta) · campaigns + campaign_sends · menus + menu_items · media (alt_text, conversions) · settings (key/value, grouped) · redirects · consents (polymorphic consent evidence) · audit_logs · jobs / failed_jobs (queue).
17. Non-Functional Requirements
18. Testing & Acceptance Criteria
Automated:
Feature tests — every public form (validation, spam rejection, consent required, emails queued, records created); permission matrix tests per role; retention command tests; newsletter chunking test; signed-URL tamper tests.
Manual pre-launch checklist:
All 30+ pages present, populated, and proofed; last-reviewed dates set on compliance pages.
Referral form end-to-end on mobile + desktop, including document upload and urgent flag routing.
Enquiry, application, and newsletter double opt-in flows verified with real inboxes (SPF/DKIM/DMARC passing, not landing in spam).
Admin: create slide, page edit + revision restore, vacancy publish → application → status email, newsletter test send, media alt-text enforcement, consent-flag enforcement on gallery/testimonials.
Accessibility: axe/Pa11y clean, keyboard-only pass, NVDA pass, 400% zoom reflow, reduced-motion check, contrast audit.
Security: SSLLabs A grade, security headers verified, login lockout, MFA enrolment, private file direct-URL access blocked (expect 403), .env inaccessible.
Backups: full backup + restore rehearsal completed.
Cookie banner blocks analytics/maps until consent; consent recorded.
Lighthouse ≥ 90 across categories on Home, a service page, and Careers.
404/500 pages branded; redirects for any legacy URLs in place.
Acceptance:
Client sign-off against this checklist + 2-week post-launch warranty period for defects.
19. cPanel Deployment Runbook (summary)
Create MySQL DB + user (least privilege); note credentials.
Upload application to ~/app/ (above web root); point public_html to app/public via symlink or set subdomain document root; verify no framework files web-accessible.
Configure. env (production, debug off, SMTP, queue=database, cache=file, session=database); php artisan key:generate, migrate --force, storage:link, config/route/view cache.
Cron jobs: * * * * * php /home/USER/app/artisan schedule:run (scheduler drives queue processing, backups, retention purge, sitemap refresh).
Enable AutoSSL; force HTTPS; add security headers via middleware (already in app) + .htaccess hardening.
DNS: SPF, DKIM (via SMTP provider), DMARC records; test with mail-tester.
Configure off-server backup destination credentials; run first backup manually and verify.
Create admin users, enforce MFA enrolment on first login; delete any seed/demo accounts.
Submit sitemap to Google Search Console; verify structured data with Rich Results test.
Enable uptime monitoring; hand over admin user guide + credentials via secure channel.
20. Project Phases & Deliverables
Each phase maps 1:1 to a Claude Code build prompt for implementation.
21. Handover Pack Contents
Admin user guide (illustrated, per role) · deployment runbook · credentials register (delivered securely) · DPIA checklist · retention schedule config sheet · accessibility statement + audit evidence · backup/restore procedure · incident/breach response runbook · content style guide (plain English + alt-text guidance).
End of specification — Liberty Centre Limited Website & CMS, v1.0, July 2026.
