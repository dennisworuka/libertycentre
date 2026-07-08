<?php

use App\Domain\Content\Models\Redirect;
use App\Http\Controllers\CareersController;
use App\Http\Controllers\CqcController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterSubscribeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/cqc-quality', [CqcController::class, 'show'])->name('cqc-quality');

Route::get('/careers', [CareersController::class, 'index'])->name('careers');

Route::get('/news/feed', [PostController::class, 'feed'])->name('news.feed');
Route::get('/news', [PostController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [PostController::class, 'show'])->name('news.show');

Route::post('/newsletter/subscribe', NewsletterSubscribeController::class)
    ->middleware('throttle:5,1')
    ->name('newsletter.subscribe');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/**
 * Contact gets its own named route (linked from all over the site) even
 * though it renders through the same generic Page controller as everything
 * below — ->defaults() supplies the slug that would otherwise come from
 * the URI.
 */
Route::get('/contact', [PageController::class, 'show'])->name('contact')->defaults('slug', 'contact');

/**
 * Generic CMS-driven pages: about, our-approach, referrals, newsletter,
 * privacy, cookies, accessibility, terms, safeguarding — every top-level
 * Page record not already matched above. Must stay last among GET routes.
 *
 * This pattern matches on path shape alone, so it intercepts every
 * single-segment path before Route::fallback ever sees it — including
 * legacy paths with no matching Page. PageController::show() checks the
 * Redirect table itself before aborting for exactly that reason; the same
 * applies to ServiceController/PostController's own {slug} routes above.
 */
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');

/**
 * Only reached once no other route has matched — i.e. exactly the request
 * that would otherwise 404. Checked here rather than in global middleware
 * so ordinary requests (assets, /admin, /up) don't pay for a redirect
 * lookup on every hit.
 */
Route::fallback(function () {
    $path = '/'.ltrim(request()->path(), '/');

    $redirect = Redirect::where('from_path', $path)->first();

    if (! $redirect) {
        abort(404);
    }

    $redirect->incrementHits();

    return redirect($redirect->to_path, $redirect->status_code);
});
