<?php

namespace App\Http\Controllers;

use App\Domain\Content\Models\Redirect;
use Illuminate\Http\RedirectResponse;

abstract class Controller
{
    /**
     * A `/{slug}`-style catch-all route matches on path shape alone, so it
     * intercepts legacy paths before Route::fallback ever sees them — a
     * plain firstOrFail() here would 404 instead of honouring a Redirect
     * created when the record's slug changed. Check for one first.
     */
    protected function redirectOrAbort(string $path): RedirectResponse
    {
        $redirect = Redirect::where('from_path', $path)->first();

        if (! $redirect) {
            abort(404);
        }

        $redirect->incrementHits();

        return redirect($redirect->to_path, $redirect->status_code);
    }
}
