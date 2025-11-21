@props(['striped' => true])

<div class="overflow-x-auto">
    <table {{ $attributes->merge(['class' => 'w-full border-collapse']) }}>
        {{ $slot }}
    </table>
</div>

@push('styles')
<style>
    @if($striped)
        tbody tr:nth-child(odd) {
            @apply bg-primary-25;
        }
    @endif
</style>
@endpush
