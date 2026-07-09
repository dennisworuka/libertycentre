@extends('layouts.app')

@section('content')
    <section class="section-band bg-white easy-read-page">
        <div class="container content-measure">
            <h1>Easy Read</h1>
            <p>Simple information about Liberty Centre.</p>
            @forelse($pages as $page)
                <article class="easy-read-card">
                    <h2>{{ $page->title }}</h2>
                    @include('public.partials.blocks', ['blocks' => $page->blocks ?? []])
                </article>
            @empty
                <p class="empty-state">Easy Read pages will appear here.</p>
            @endforelse
        </div>
    </section>
@endsection
