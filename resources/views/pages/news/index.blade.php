@extends('layouts.app')

@section('content')

    <x-breadcrumbs :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'News & Updates'],
    ]" />

    <x-section>
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-5 gap-3">
            <h1 class="mb-0">News & Updates</h1>
            <a href="{{ route('news.feed') }}" class="small">Subscribe via RSS</a>
        </div>

        @if ($categories->isNotEmpty())
            <nav aria-label="Filter by category" class="mb-4">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link {{ ! $activeCategory ? 'active fw-semibold' : '' }}" href="{{ route('news.index') }}">All</a>
                    </li>
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link {{ $activeCategory === $category ? 'active fw-semibold' : '' }}" href="{{ route('news.index', ['category' => $category]) }}">
                                {{ $category }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif

        @if ($posts->isEmpty())
            <p>There are no articles in this category yet.</p>
        @else
            <div class="row g-5" data-reveal-stagger>
                @foreach ($posts as $post)
                    <div class="col-md-4">
                        <x-card.post :post="$post" />
                    </div>
                @endforeach
            </div>

            <div class="mt-5">
                {{ $posts->links() }}
            </div>
        @endif
    </x-section>

@endsection
