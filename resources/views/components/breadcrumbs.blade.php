@props(['items' => []])
{{-- $items: array of ['label' => string, 'url' => string|null]. Omit url (or make it the last item) for the current page. --}}

<nav aria-label="Breadcrumb" class="lc-breadcrumbs py-3">
    <ol class="breadcrumb mb-0">
        @foreach ($items as $item)
            @if ($loop->last || empty($item['url']))
                <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
            @else
                <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
            @endif
        @endforeach
    </ol>
</nav>

<x-json-ld :data="[
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => collect($items)->values()->map(fn ($item, $i) => array_filter([
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $item['label'],
        'item' => $item['url'] ?? null,
    ]))->all(),
]" />
