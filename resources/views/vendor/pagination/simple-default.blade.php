@if ($paginator->hasPages())
    <ul class="pagination col s6 offset-s3">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled btn"><span>Prev</span></li>
        @else
            <li class="btn"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">Prev</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="btn"><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a></li>
        @else
            <li class="disabled btn"><span>Next</span></li>
        @endif
    </ul>
@endif
