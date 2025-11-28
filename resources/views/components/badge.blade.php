@props(['type' => 'neutral'])

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
    {{ $slot }}
</span>
