@props(['post'])

<div class="card h-100 position-relative">
    <div class="card-body d-flex flex-column">
        @if ($post->category)
            <span class="badge bg-surface text-primary border mb-2 align-self-start">{{ $post->category }}</span>
        @endif

        <h3 class="h5">
            <a href="{{ route('news.show', $post->slug) }}" class="stretched-link text-decoration-none text-body">
                {{ $post->title }}
            </a>
        </h3>

        <p class="small text-body-secondary mb-0 mt-auto">{{ optional($post->published_at)->format('j F Y') }}</p>
    </div>
</div>
