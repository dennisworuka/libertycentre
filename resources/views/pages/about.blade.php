@extends('layouts.app')

@section('content')

    <x-breadcrumbs :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'About Us'],
    ]" />

    <x-section>
        <h1 class="mb-4">About Us</h1>
        <x-blocks :blocks="$page->body" />
    </x-section>

    @if ($teamMembers->isNotEmpty())
        <x-section background="surface">
            <h2 class="text-center mb-5">Our leadership team</h2>
            <div class="row g-4" data-reveal-stagger>
                @foreach ($teamMembers as $member)
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                @if ($member->getFirstMediaUrl(\App\Domain\Content\Models\TeamMember::PHOTO_COLLECTION))
                                    <img
                                        src="{{ $member->getFirstMediaUrl(\App\Domain\Content\Models\TeamMember::PHOTO_COLLECTION, '480') }}"
                                        alt="{{ $member->getFirstMedia(\App\Domain\Content\Models\TeamMember::PHOTO_COLLECTION)?->getCustomProperty('alt') }}"
                                        class="rounded-circle mb-3"
                                        width="96"
                                        height="96"
                                        loading="lazy"
                                    >
                                @endif
                                <h3 class="h6 mb-1">{{ $member->name }}</h3>
                                <p class="small text-body-secondary mb-0">{{ $member->role }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-section>
    @endif

@endsection
