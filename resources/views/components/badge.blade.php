@props(['type' => 'neutral', 'dot' => false])

@php
$badgeClasses = match($type) {
    'success' => 'badge-success',
    'warning' => 'badge-warning',
    'danger' => 'badge-danger',
    'info' => 'badge-info',
    'neutral' => 'badge-neutral',
    default => 'badge-neutral',
};
@endphp

<span {{ $attributes->merge(['class' => $badgeClasses]) }}>
    @if ($dot)
        <span class="status-dot {{ $type }}"></span>
    @endif
    {{ $slot }}
</span>
