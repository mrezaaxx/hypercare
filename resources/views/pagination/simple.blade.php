@if ($paginator->hasPages())
    <nav class="pagination">
        @if ($paginator->onFirstPage())
            <span class="btn btn-sm btn-secondary disabled">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm btn-secondary">Previous</a>
        @endif

        <span class="pagination-info">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm btn-secondary">Next</a>
        @else
            <span class="btn btn-sm btn-secondary disabled">Next</span>
        @endif
    </nav>
@endif
