<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Public\Concerns\LoadsPublicLayoutData;
use App\Models\TeamMember;
use Illuminate\Contracts\View\View;

class TeamController extends Controller
{
    use LoadsPublicLayoutData;

    public function __invoke(): View
    {
        return view('public.team.index', $this->publicLayoutData([
            'teamMembers' => TeamMember::published()->get(),
            'title' => 'Our Team | Liberty Centre Limited',
        ]));
    }
}
