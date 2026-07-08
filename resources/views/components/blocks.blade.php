@props(['blocks' => []])

@foreach ($blocks as $block)
    @php
        $type = $block['type'] ?? null;
        $data = $block['data'] ?? [];
    @endphp

    @switch($type)
        @case('heading')
            @php $level = in_array($data['level'] ?? 'h2', ['h2', 'h3']) ? $data['level'] : 'h2'; @endphp
            <{{ $level }} class="mt-5 mb-3">{{ $data['text'] ?? '' }}</{{ $level }}>
            @break

        @case('rich_text')
            <div class="lc-prose text-measure mb-4">{!! $data['content'] ?? '' !!}</div>
            @break

        @case('image')
            <figure class="mb-4">
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($data['path'] ?? '') }}"
                    alt="{{ $data['alt'] ?? '' }}"
                    class="img-fluid rounded-3"
                    loading="lazy"
                >
                @if (! empty($data['caption']))
                    <figcaption class="small text-body-secondary mt-2">{{ $data['caption'] }}</figcaption>
                @endif
            </figure>
            @break

        @case('feature_list')
            <div class="mb-5">
                @if (! empty($data['title']))
                    <h3 class="mb-3">{{ $data['title'] }}</h3>
                @endif
                <div class="row g-4">
                    @foreach ($data['items'] ?? [] as $item)
                        <div class="col-md-4">
                            <h4 class="h5">{{ $item['title'] ?? '' }}</h4>
                            <p class="mb-0">{{ $item['description'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            @break

        @case('steps')
            <div class="mb-5">
                @if (! empty($data['title']))
                    <h3 class="mb-3">{{ $data['title'] }}</h3>
                @endif
                <ol class="lc-steps list-unstyled row g-4">
                    @foreach ($data['items'] ?? [] as $i => $item)
                        <li class="col-md-4">
                            <span class="lc-step-number d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white mb-2">{{ $i + 1 }}</span>
                            <h4 class="h5">{{ $item['title'] ?? '' }}</h4>
                            <p class="mb-0">{{ $item['description'] ?? '' }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
            @break

        @case('faq')
            <div class="mb-5">
                <x-faq-accordion :items="$data['items'] ?? []" :id="'faq-'.$loop->index" />
            </div>
            @break

        @case('quote')
            <blockquote class="blockquote border-start border-4 border-primary ps-4 my-4">
                <p class="mb-2">{{ $data['text'] ?? '' }}</p>
                @if (! empty($data['attribution']))
                    <footer class="blockquote-footer">{{ $data['attribution'] }}</footer>
                @endif
            </blockquote>
            @break

        @case('cta')
            <x-cta-band
                :heading="$data['heading'] ?? null"
                :text="$data['text'] ?? null"
                :buttonLabel="$data['button_label'] ?? 'Learn more'"
                :buttonUrl="$data['button_url'] ?? '#'"
            />
            @break

        @case('two_column')
            <div class="row g-4 mb-4">
                <div class="col-md-6 lc-prose">{!! $data['left'] ?? '' !!}</div>
                <div class="col-md-6 lc-prose">{!! $data['right'] ?? '' !!}</div>
            </div>
            @break
    @endswitch
@endforeach
