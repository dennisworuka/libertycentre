<?php

use App\Domain\Content\Models\Redirect;
use App\Http\Controllers\CqcController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/cqc-quality', [CqcController::class, 'show'])->name('cqc-quality');

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
