@props(['variant' => 'default', 'padding' => 'p-8'])

@php
    $baseClasses = "rounded-[2.5rem] transition-all duration-300";
    
    $variants = [
        'default' => 'bg-surface border border-border shadow-premium',
        'glass' => 'glass border border-white/20',
        'soft' => 'bg-surface-soft border border-border/50',
        'accent' => 'bg-accent text-white shadow-lg shadow-accent/20',
    ];

    $classes = $baseClasses . " " . ($variants[$variant] ?? $variants['default']) . " " . $padding;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
