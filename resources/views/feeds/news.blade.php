<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
@php
    $organisation = app(\App\Settings\OrganisationSettings::class);
@endphp
<rss version="2.0">
    <channel>
        <title>{{ $organisation->site_name }} — News</title>
        <link>{{ url('/news') }}</link>
        <description>Latest news and updates from {{ $organisation->site_name }}.</description>
        <language>en-gb</language>
        <lastBuildDate>{{ now()->toRssString() }}</lastBuildDate>
        @foreach ($posts as $post)
        <item>
            <title>{{ $post->title }}</title>
            <link>{{ url("/news/{$post->slug}") }}</link>
            <guid isPermaLink="true">{{ url("/news/{$post->slug}") }}</guid>
            <pubDate>{{ $post->published_at->toRssString() }}</pubDate>
            <description>{{ $post->meta_description }}</description>
        </item>
        @endforeach
    </channel>
</rss>
