@extends('layouts.app')

@section('content')
    <article class="section-band bg-white">
        <div class="container content-measure">
            @include('public.partials.blocks', ['blocks' => $page->blocks ?? []])
        </div>
    </article>
@endsection
