<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class CareersController extends Controller
{
    public function index(): View
    {
        return view('pages.careers', [
            'title' => 'Careers',
        ]);
    }
}
