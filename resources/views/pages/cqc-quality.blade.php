@extends('layouts.app')

@section('content')

    <x-breadcrumbs :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'CQC & Quality'],
    ]" />

    <x-section>
        <div class="text-center mb-5">
            <x-cqc-badge />
            <h1 class="mt-3">Rated {{ $siteCqc->rating_label }} by the CQC</h1>
            <p class="text-measure mx-auto">
                Liberty Centre Limited is regulated by the Care Quality Commission (CQC), the independent regulator
                of health and social care in England.
            </p>
            <a href="{{ $siteCqc->report_url }}" target="_blank" rel="noopener" class="btn btn-primary">
                Read the CQC report
            </a>
        </div>

        <h2 class="text-center mb-4">How we're rated</h2>
        <div class="table-responsive">
            <table class="table border">
                <thead>
                    <tr>
                        <th scope="col">Key question</th>
                        <th scope="col">Our rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siteCqc->question_ratings as $row)
                        <tr>
                            <td>{{ $row['question'] }}</td>
                            <td><span class="badge" style="background-color: var(--lc-amber); color: var(--lc-ink);">{{ $row['rating'] }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-section>

    <x-section background="surface">
        <div class="row g-4">
            <div class="col-md-6">
                <h2 class="h4">Our quality commitment</h2>
                <p>We continuously review our practice against CQC standards, act on feedback, and support our staff to deliver consistent, person-centred care.</p>
            </div>
            <div class="col-md-6">
                <h2 class="h4">Complaints and feedback</h2>
                <p>
                    If you have a concern or compliment, please <a href="{{ route('contact') }}">contact us directly</a> —
                    or read our <a href="{{ route('pages.show', 'safeguarding') }}">safeguarding commitment</a> for how to
                    raise a safety concern.
                </p>
            </div>
        </div>
    </x-section>

@endsection
