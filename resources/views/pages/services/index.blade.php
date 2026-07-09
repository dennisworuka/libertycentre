@extends('layouts.app')

@section('content')

    <x-breadcrumbs :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Services'],
    ]" />

    <x-section>
        <div class="text-center mb-5">
            <h1>Our Services</h1>
            <p class="text-measure mx-auto">Five specialist services, each built around the person receiving support.</p>
        </div>

        <div class="row g-5" data-reveal-stagger>
            @foreach ($services as $service)
                <div class="col-md-6 col-lg-4">
                    <x-card.service :service="$service" />
                </div>
            @endforeach
        </div>
    </x-section>

@endsection
