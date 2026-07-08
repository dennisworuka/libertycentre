@extends('layouts.app')

@section('content')

    <x-breadcrumbs :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => $page->title],
    ]" />

    <x-section>
        <h1 class="mb-4">{{ $page->title }}</h1>
        <x-blocks :blocks="$page->body" />
        <p class="small text-body-secondary mt-5">Last updated {{ $page->updated_at->format('j F Y') }}.</p>
    </x-section>

@endsection
