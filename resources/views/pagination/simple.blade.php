@if ($paginator->hasPages())
    <nav class="flex items-center justify-between gap-6 py-2">
        <div class="flex items-center gap-3">
            @if ($paginator->onFirstPage())
                <span class="px-5 py-2.5 bg-surface-soft/50 text-text-faint font-bold text-xs rounded-xl border border-border/30 cursor-not-allowed opacity-50">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-5 py-2.5 bg-white text-text-muted hover:text-accent font-bold text-xs rounded-xl border border-border/60 hover:border-accent/20 hover:shadow-md transition-all active:scale-95">
                    Previous
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-5 py-2.5 bg-white text-text-muted hover:text-accent font-bold text-xs rounded-xl border border-border/60 hover:border-accent/20 hover:shadow-md transition-all active:scale-95">
                    Next
                </a>
            @else
                <span class="px-5 py-2.5 bg-surface-soft/50 text-text-faint font-bold text-xs rounded-xl border border-border/30 cursor-not-allowed opacity-50">
                    Next
                </span>
            @endif
        </div>
        
        <div class="hidden sm:flex items-center gap-2">
            <span class="text-[0.65rem] font-black text-text-faint uppercase tracking-widest">Page</span>
            <span class="w-8 h-8 flex items-center justify-center bg-accent text-white rounded-lg text-xs font-black shadow-lg shadow-accent/20">
                {{ $paginator->currentPage() }}
            </span>
            <span class="text-[0.65rem] font-black text-text-faint uppercase tracking-widest mx-1">of</span>
            <span class="text-xs font-bold text-text-muted">{{ $paginator->lastPage() }}</span>
        </div>
    </nav>
@endif
