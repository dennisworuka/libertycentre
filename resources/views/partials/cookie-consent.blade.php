<div class="lc-cookie-banner p-3 p-md-4" id="cookie-consent-banner" role="region" aria-label="Cookie consent" hidden>
    <div class="container">
        <div class="row g-3 align-items-center">
            <div class="col-lg-6">
                <p class="mb-0 small">{{ $siteCompliance->cookie_banner_text }}</p>
            </div>
            <div class="col-lg-6">
                <div class="d-flex flex-wrap align-items-center gap-3 justify-content-lg-end">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="cookie-analytics-toggle">
                        <label class="form-check-label small" for="cookie-analytics-toggle">Analytics cookies</label>
                    </div>
                    <button type="button" class="btn btn-link btn-sm text-decoration-underline p-0" id="cookie-save-preferences">
                        Save preferences
                    </button>
                    <button type="button" class="btn btn-outline-dark btn-sm" id="cookie-reject">Reject non-essential</button>
                    <button type="button" class="btn btn-dark btn-sm" id="cookie-accept">Accept all</button>
                </div>
            </div>
        </div>
    </div>
</div>
