<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class CqcController extends Controller
{
    public function show(): View
    {
        return view('pages.cqc-quality', [
            'title' => 'CQC & Quality',
        ]);
    }
}
