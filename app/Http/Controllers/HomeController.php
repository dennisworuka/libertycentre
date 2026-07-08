<?php

namespace App\Http\Controllers;

use App\Domain\Content\Models\Post;
use App\Domain\Content\Models\Service;
use App\Domain\Content\Models\Testimonial;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('pages.home', [
            'services' => Service::published()->orderBy('order')->get(),
            'posts' => Post::published()->latest('published_at')->take(3)->get(),
            'testimonials' => Testimonial::published()->latest()->get(),
        ]);
    }
}
