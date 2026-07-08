<?php

use App\Domain\Content\Models\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
