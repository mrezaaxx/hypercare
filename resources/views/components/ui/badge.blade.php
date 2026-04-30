@props(['variant' => 'info', 'dot' => false, 'pulse' => false])

@php
    $variants = [
        'info' => 'bg-info/10 text-info border-info/10 shadow-info/5',
        'success' => 'bg-success/10 text-success border-success/10 shadow-success/5',
        'warning' => 'bg-warning/10 text-warning border-warning/10 shadow-warning/5',
        'danger' => 'bg-danger/10 text-danger border-danger/10 shadow-danger/5',
        'accent' => 'bg-accent/10 text-accent border-accent/10 shadow-accent/5',
    ];

    $classes = "inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[0.6rem] font-black uppercase tracking-widest border shadow-sm " . ($variants[$variant] ?? $variants['info']);
    
    $dotClasses = "w-1.5 h-1.5 rounded-full " . match($variant) {
        'success' => 'bg-success',
        'warning' => 'bg-warning',
        'danger' => 'bg-danger',
        'accent' => 'bg-accent',
        default => 'bg-info',
    };
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="{{ $dotClasses }} {{ $pulse ? 'animate-pulse' : '' }}"></span>
    @endif
    {{ $slot }}
</span>
