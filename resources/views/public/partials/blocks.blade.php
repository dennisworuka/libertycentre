@foreach ($blocks as $block)
    @php
        $level = (int) ($block['heading_level'] ?? 2);
        $tag = 'h' . max(1, min(3, $level));
    @endphp

    <section class="content-block content-block-{{ $block['type'] ?? 'text' }}">
        <{{ $tag }}>{{ $block['heading'] ?? '' }}</{{ $tag }}>
        @if(! empty($block['body']))
            @foreach (preg_split("/\r\n|\n|\r/", $block['body']) as $paragraph)
                @if(trim($paragraph) !== '')
                    <p>{{ $paragraph }}</p>
                @endif
            @endforeach
        @endif
    </section>
@endforeach
