@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button'
])

@php
    $baseClasses = "inline-flex items-center justify-center font-bold transition-all duration-300 active:scale-95 group focus:outline-none focus:ring-4";
    
    $variants = [
        'primary' => 'bg-accent text-white shadow-lg shadow-accent/20 hover:bg-accent/90 focus:ring-accent/20',
        'secondary' => 'bg-surface-soft text-text hover:bg-surface-strong hover:text-text focus:ring-surface-strong/20 border border-border/50',
        'dark' => 'bg-text text-white shadow-lg shadow-text/10 hover:bg-text/90 focus:ring-text/20',
        'ghost' => 'bg-transparent text-text-faint hover:text-text hover:bg-surface-soft focus:ring-surface-soft/20',
        'danger' => 'bg-danger text-white shadow-lg shadow-danger/20 hover:bg-danger/90 focus:ring-danger/20',
    ];

    $sizes = [
        'xs' => 'px-3 py-1.5 text-[0.65rem] rounded-xl',
        'sm' => 'px-4 py-2 text-xs rounded-xl',
        'md' => 'px-6 py-3 text-sm rounded-2xl',
        'lg' => 'px-8 py-4 text-base rounded-[1.25rem]',
    ];

    $classes = $baseClasses . " " . ($variants[$variant] ?? $variants['primary']) . " " . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
