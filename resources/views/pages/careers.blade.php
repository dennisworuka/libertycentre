@extends('layouts.app')

@section('content')

    <x-breadcrumbs :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Careers'],
    ]" />

    <x-section>
        <div class="text-center">
            <h1 class="mb-3">Join our team</h1>
            <p class="text-measure mx-auto mb-4">
                We're always looking for warm, reliable people to join our care team across West Yorkshire. Our full
                list of current vacancies is being finalised and will appear here shortly.
            </p>
            <a href="{{ route('contact') }}" class="btn btn-primary">Register your interest</a>
        </div>
    </x-section>

    <x-section background="surface">
        <div class="row g-4 text-center" data-reveal-stagger>
            <div class="col-md-4">
                <h2 class="h5">Training from day one</h2>
                <p class="mb-0">Full induction and ongoing professional development for every member of staff.</p>
            </div>
            <div class="col-md-4">
                <h2 class="h5">A supportive team</h2>
                <p class="mb-0">Consistent rotas and a management team who know you and the people you support.</p>
            </div>
            <div class="col-md-4">
                <h2 class="h5">Real career progression</h2>
                <p class="mb-0">Clear routes from support worker through to senior and management roles.</p>
            </div>
        </div>
    </x-section>

@endsection
