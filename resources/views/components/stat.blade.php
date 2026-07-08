@props(['value', 'label', 'suffix' => ''])

<div class="lc-stat text-center" data-counter data-counter-target="{{ (int) $value }}">
    <p class="display-5 fw-bold text-primary mb-1">
        <span data-counter-value>0</span>{{ $suffix }}
    </p>
    <p class="mb-0">{{ $label }}</p>
</div>
