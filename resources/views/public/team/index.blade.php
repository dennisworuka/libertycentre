@extends('layouts.app')

@section('content')
    <section class="section-band bg-white">
        <div class="container">
            <h1>Our Team</h1>
            <p>Meet the people leading and delivering Liberty Centre support.</p>
            <div class="team-grid">
                @forelse($teamMembers as $member)
                    <article class="team-card">
                        <h2 class="h3">{{ $member->name }}</h2>
                        <p class="fw-semibold">{{ $member->role }}</p>
                        @if($member->bio)
                            <p>{{ $member->bio }}</p>
                        @endif
                        @if($member->dbs_checked)
                            <span class="status-pill">DBS checked</span>
                        @endif
                    </article>
                @empty
                    <p class="empty-state">Team profiles will appear here.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
