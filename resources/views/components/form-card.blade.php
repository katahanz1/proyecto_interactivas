@props(['title' => null, 'description' => null, 'icon' => null])

<div {{ $attributes->merge(['class' => 'card bg-primary-25 border-primary-200']) }}>
    @if($title || $icon)
        <div class="flex items-start gap-3 mb-6 pb-6 border-b border-primary-200">
            @if($icon)
                <div class="p-2 bg-accent-100 rounded-lg flex-shrink-0">
                    {!! $icon !!}
                </div>
            @endif
            <div class="flex-1">
                @if($title)
                    <h3 class="text-lg font-bold text-primary-900">{{ $title }}</h3>
                @endif
                @if($description)
                    <p class="text-sm text-primary-600 mt-1">{{ $description }}</p>
                @endif
            </div>
        </div>
    @endif
    {{ $slot }}
</div>
