@props(['items' => [], 'id' => 'faq'])

<div class="accordion" id="{{ $id }}">
    @foreach ($items as $i => $item)
        <div class="accordion-item">
            <h3 class="accordion-header" id="{{ $id }}-heading-{{ $i }}">
                <button
                    class="accordion-button {{ $i > 0 ? 'collapsed' : '' }}"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#{{ $id }}-collapse-{{ $i }}"
                    aria-expanded="{{ $i === 0 ? 'true' : 'false' }}"
                    aria-controls="{{ $id }}-collapse-{{ $i }}"
                >
                    {{ $item['question'] ?? '' }}
                </button>
            </h3>
            <div
                id="{{ $id }}-collapse-{{ $i }}"
                class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                aria-labelledby="{{ $id }}-heading-{{ $i }}"
                data-bs-parent="#{{ $id }}"
            >
                <div class="accordion-body">
                    {{ $item['answer'] ?? '' }}
                </div>
            </div>
        </div>
    @endforeach
</div>
