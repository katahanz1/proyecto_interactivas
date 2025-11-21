@props(['href' => '#'])

<a {{ $attributes->merge(['href' => $href, 'class' => 'text-sm font-semibold text-accent-600 hover:text-accent-700 transition-colors duration-150']) }}>
    {{ $slot }}
</a>
