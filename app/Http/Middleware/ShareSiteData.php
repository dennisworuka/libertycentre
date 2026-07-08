<?php

namespace App\Http\Middleware;

use App\Domain\Content\Models\NavigationItem;
use App\Settings\AnnouncementSettings;
use App\Settings\ComplianceSettings;
use App\Settings\ContactSettings;
use App\Settings\CqcSettings;
use App\Settings\OrganisationSettings;
use App\Settings\SocialSeoSettings;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Shares site settings and the two navigation trees with every view on the
 * public site via View::share() rather than a scoped View::composer(). A
 * composer bound to layouts.app only populates that one view instance —
 * the variables are undefined inside a child template's own section
 * content, since Blade renders that content in the child's own data scope
 * before the parent layout is even instantiated.
 *
 * Registered on the 'web' middleware group only, so Filament's admin panel
 * (which does not use that group) never pays for these queries.
 */
class ShareSiteData
{
    public function handle(Request $request, Closure $next): Response
    {
        View::share([
            'siteOrganisation' => app(OrganisationSettings::class),
            'siteContact' => app(ContactSettings::class),
            'siteCqc' => app(CqcSettings::class),
            'siteSocialSeo' => app(SocialSeoSettings::class),
            'siteAnnouncement' => app(AnnouncementSettings::class),
            'siteCompliance' => app(ComplianceSettings::class),
            'headerNavigation' => $this->navigationTree(NavigationItem::LOCATION_HEADER),
            'footerNavigation' => $this->navigationTree(NavigationItem::LOCATION_FOOTER),
        ]);

        return $next($request);
    }

    /**
     * @return Collection<int, NavigationItem>
     */
    protected function navigationTree(string $location): Collection
    {
        return Cache::remember("navigation.{$location}", now()->addMinutes(10), function () use ($location) {
            return NavigationItem::query()
                ->whereNull('parent_id')
                ->where('location', $location)
                ->where('is_active', true)
                ->with(['children' => fn ($query) => $query->where('is_active', true)])
                ->orderBy('order')
                ->get();
        });
    }
}
