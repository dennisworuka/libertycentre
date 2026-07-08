@extends('layouts.app')

@section('content')

    <x-breadcrumbs :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Contact'],
    ]" />

    <x-section>
        <div class="row g-5">
            <div class="col-lg-7">
                <h1 class="mb-4">Contact</h1>
                <x-blocks :blocks="$page->body" />

                <div class="border border-mist rounded-3 p-4 bg-surface">
                    <p class="mb-0">
                        The contact form will be enabled shortly. In the meantime, please call or email us using the
                        details opposite.
                    </p>
                </div>

                <p class="small text-body-secondary mt-4">
                    Worried about someone's safety or wellbeing? Read our
                    <a href="{{ route('pages.show', 'safeguarding') }}">safeguarding commitment</a> for how to raise a concern.
                </p>
            </div>

            <div class="col-lg-5">
                <div class="card border-mist mb-4">
                    <div class="card-body">
                        <h2 class="h5">Get in touch</h2>
                        <ul class="list-unstyled mb-0">
                            @if ($siteContact->phone)
                                <li class="mb-2"><a href="tel:{{ preg_replace('/\s+/', '', $siteContact->phone) }}">{{ $siteContact->phone }}</a></li>
                            @endif
                            @if ($siteContact->email_general)
                                <li class="mb-2"><a href="mailto:{{ $siteContact->email_general }}">{{ $siteContact->email_general }}</a></li>
                            @endif
                            <li>{{ $siteContact->office_hours }}</li>
                        </ul>
                    </div>
                </div>

                <div class="lc-map-placeholder border border-mist rounded-3 bg-surface d-flex align-items-center justify-content-center text-center p-5" style="min-height: 240px;">
                    <div>
                        <p class="mb-2">Map loads only once you consent to non-essential cookies.</p>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="load-map-button" data-requires-consent="analytics">
                            Show map
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-section>

@endsection
