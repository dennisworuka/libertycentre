@php
    $pageTitle = trim(($title ?? null) ? "{$title} | {$siteOrganisation->site_name}" : $siteSocialSeo->default_meta_title);
    $pageDescription = $metaDescription ?? $siteSocialSeo->default_meta_description;
    $canonicalUrl = $canonicalUrl ?? url()->current();
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}">
<link rel="canonical" href="{{ $canonicalUrl }}">

<meta property="og:type" content="{{ $ogType ?? 'website' }}">
<meta property="og:site_name" content="{{ $siteOrganisation->site_name }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
@if (! empty($ogImage))
    <meta property="og:image" content="{{ $ogImage }}">
@endif

<meta name="twitter:card" content="{{ ! empty($ogImage) ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
@if (! empty($ogImage))
    <meta name="twitter:image" content="{{ $ogImage }}">
@endif
