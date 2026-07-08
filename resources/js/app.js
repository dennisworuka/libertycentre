import $ from 'jquery';

window.$ = window.jQuery = $;

import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;

// Checked once here; every effect module reads documentElement's
// .reduced-motion class (see resources/scss/app.scss) instead of
// re-querying matchMedia itself, so all effects downgrade together.
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
document.documentElement.classList.toggle('reduced-motion', prefersReducedMotion);

window.LC = window.LC || {};
window.LC.prefersReducedMotion = prefersReducedMotion;

import { initCookieConsent, initConsentGatedEmbeds } from './cookie-consent';

document.addEventListener('DOMContentLoaded', () => {
    initCookieConsent();
    initConsentGatedEmbeds();
});

import './modules/reveal';
import './modules/navbar';
import './modules/counters';
import './modules/smooth';
import './modules/forms';
import './modules/testimonials';
import './modules/hero-slider';
