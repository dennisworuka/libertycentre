<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Public\Concerns\LoadsPublicLayoutData;
use App\Models\Faq;
use Illuminate\Contracts\View\View;

class FaqController extends Controller
{
    use LoadsPublicLayoutData;

    public function __invoke(): View
    {
        return view('public.faqs.index', $this->publicLayoutData([
            'faqsByCategory' => Faq::published()->get()->groupBy('category'),
            'title' => 'FAQs | Liberty Centre Limited',
        ]));
    }
}
