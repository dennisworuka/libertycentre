const STORAGE_KEY = 'lc_cookie_consent';
const SIX_MONTHS_MS = 1000 * 60 * 60 * 24 * 30 * 6;

function readConsent() {
    try {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (!raw) return null;

        const parsed = JSON.parse(raw);
        if (Date.now() - parsed.timestamp > SIX_MONTHS_MS) return null;

        return parsed;
    } catch (e) {
        return null;
    }
}

function writeConsent(analytics) {
    const consent = { analytics, timestamp: Date.now() };
    localStorage.setItem(STORAGE_KEY, JSON.stringify(consent));

    return consent;
}

function announce(consent) {
    document.dispatchEvent(new CustomEvent('lc:consent-updated', { detail: consent }));
}

export function initCookieConsent() {
    const banner = document.getElementById('cookie-consent-banner');
    if (!banner) return;

    const acceptBtn = document.getElementById('cookie-accept');
    const rejectBtn = document.getElementById('cookie-reject');
    const saveBtn = document.getElementById('cookie-save-preferences');
    const analyticsToggle = document.getElementById('cookie-analytics-toggle');
    const reopenBtn = document.getElementById('reopen-cookie-preferences');

    const existing = readConsent();

    if (existing) {
        banner.hidden = true;
        if (analyticsToggle) analyticsToggle.checked = Boolean(existing.analytics);
        announce(existing);
    } else {
        banner.hidden = false;
    }

    acceptBtn?.addEventListener('click', () => {
        if (analyticsToggle) analyticsToggle.checked = true;
        banner.hidden = true;
        announce(writeConsent(true));
    });

    rejectBtn?.addEventListener('click', () => {
        if (analyticsToggle) analyticsToggle.checked = false;
        banner.hidden = true;
        announce(writeConsent(false));
    });

    saveBtn?.addEventListener('click', () => {
        banner.hidden = true;
        announce(writeConsent(Boolean(analyticsToggle?.checked)));
    });

    reopenBtn?.addEventListener('click', () => {
        const current = readConsent();
        if (analyticsToggle) analyticsToggle.checked = Boolean(current?.analytics);
        banner.hidden = false;
        banner.scrollIntoView({ behavior: 'smooth', block: 'end' });
    });
}

// Anything marked data-requires-consent (currently just the contact page's
// map placeholder) only reveals its embed after an explicit click *and*
// existing consent — never automatically.
export function initConsentGatedEmbeds() {
    document.querySelectorAll('[data-requires-consent]').forEach((button) => {
        button.addEventListener('click', () => {
            if (!readConsent()) {
                const banner = document.getElementById('cookie-consent-banner');
                banner?.removeAttribute('hidden');
                banner?.scrollIntoView({ behavior: 'smooth', block: 'end' });

                return;
            }

            const placeholder = button.closest('.lc-map-placeholder');
            if (placeholder) {
                placeholder.innerHTML = '<p class="mb-0 text-body-secondary">Map embed goes here once a mapping provider is configured.</p>';
            }
        });
    });
}
