@extends('layouts.app')

@section('content')

    <x-breadcrumbs :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'News & Updates', 'url' => route('news.index')],
        ['label' => $post->title],
    ]" />

    <x-section>
        <article class="row g-5">
            <div class="col-lg-8">
                @if ($post->category)
                    <span class="badge bg-surface text-primary border border-mist mb-3">{{ $post->category }}</span>
                @endif

                <h1 class="mb-2">{{ $post->title }}</h1>
                <p class="text-body-secondary mb-4">
                    {{ optional($post->published_at)->format('j F Y') }}
                    @if ($post->author_name)
                        &middot; {{ $post->author_name }}
                    @endif
                </p>

                @if ($post->getFirstMediaUrl(\App\Domain\Content\Models\Post::HERO_IMAGE_COLLECTION))
                    <img
                        src="{{ $post->getFirstMediaUrl(\App\Domain\Content\Models\Post::HERO_IMAGE_COLLECTION, '960') }}"
                        alt="{{ $post->getFirstMedia(\App\Domain\Content\Models\Post::HERO_IMAGE_COLLECTION)?->getCustomProperty('alt') }}"
                        class="img-fluid rounded-3 mb-4"
                        loading="lazy"
                        fetchpriority="high"
                    >
                @endif

                <x-blocks :blocks="$post->body" />

                <div class="mt-5 pt-4 border-top border-mist">
                    <h2 class="h5">Stay in touch</h2>
                    <p>Get news like this straight to your inbox.</p>
                    <a href="{{ route('pages.show', 'newsletter') }}" class="btn btn-primary">Sign up to our newsletter</a>
                </div>
            </div>

            <div class="col-lg-4">
                @if ($related->isNotEmpty())
                    <h2 class="h5">Related articles</h2>
                    <div class="d-flex flex-column gap-3">
                        @foreach ($related as $relatedPost)
                            <x-card.post :post="$relatedPost" />
                        @endforeach
                    </div>
                @endif
            </div>
        </article>
    </x-section>

    <x-json-ld :data="[
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $post->title,
        'datePublished' => optional($post->published_at)->toAtomString(),
        'dateModified' => $post->updated_at->toAtomString(),
        'author' => ['@type' => 'Organization', 'name' => $siteOrganisation->site_name],
        'publisher' => ['@type' => 'Organization', 'name' => $siteOrganisation->site_name],
    ]" />

@endsection
