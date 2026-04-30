@props([
    'title',
    'value',
    'trend' => null,
    'trendUp' => true,
    'icon' => null,
    'color' => 'accent'
])

<x-ui.card padding="p-6" class="group hover:scale-[1.02]">
    <div class="flex items-center justify-between mb-4">
        @if($icon)
            <div class="w-12 h-12 rounded-2xl bg-{{ $color }}/10 flex items-center justify-center text-{{ $color }} transition-all group-hover:bg-{{ $color }} group-hover:text-white group-hover:shadow-lg group-hover:shadow-{{ $color }}/20">
                {{ $icon }}
            </div>
        @endif
        
        @if($trend)
            <span class="flex items-center gap-1 text-[0.7rem] font-bold {{ $trendUp ? 'text-success bg-success/10' : 'text-danger bg-danger/10' }} px-2.5 py-1 rounded-full border border-{{ $trendUp ? 'success' : 'danger' }}/10">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="{{ $trendUp ? '' : 'rotate-180' }}">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>
                </svg>
                {{ $trend }}
            </span>
        @endif
    </div>
    
    <p class="text-text-faint text-[0.65rem] font-bold uppercase tracking-[0.15em] mb-1.5">{{ $title }}</p>
    <div class="flex items-baseline gap-1">
        <h3 class="text-3xl font-black tracking-tight text-text">{{ $value }}</h3>
    </div>
</x-ui.card>
