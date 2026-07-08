<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterSubscribeController extends Controller
{
    /**
     * Placeholder handler: the real double opt-in subscription pipeline is
     * built in Phase 6. For now this just validates the address and
     * acknowledges the request without persisting anything.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        return back()->with(
            'status',
            'Thanks for your interest — newsletter sign-up is being finalised and will be live soon.'
        );
    }
}
