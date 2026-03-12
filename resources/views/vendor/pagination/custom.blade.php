@if ($paginator->hasPages())
    <nav class="d-flex justify-content-end" aria-label="Pagination">
        <ul class="pagination pagination-sm m-0 shadow-sm rounded-pill overflow-hidden">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link border-0 text-muted bg-white h-100 d-flex align-items-center px-3">
                        <i class="bi bi-chevron-left small"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link border-0 text-primary bg-white h-100 d-flex align-items-center px-3 hover-bg-light" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="bi bi-chevron-left small"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link border-0 text-muted bg-white px-3">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link border-0 bg-primary text-white fw-bold px-3">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link border-0 text-dark bg-white px-3 hover-text-primary" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link border-0 text-primary bg-white h-100 d-flex align-items-center px-3 hover-bg-light" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="bi bi-chevron-right small"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link border-0 text-muted bg-white h-100 d-flex align-items-center px-3">
                        <i class="bi bi-chevron-right small"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
        .page-link:focus { box-shadow: none; }
        .hover-bg-light:hover { background-color: #f8f9fa!important; }
        .hover-text-primary:hover { color: var(--bs-primary)!important; background-color: #f8f9fa!important; }
    </style>
@endif
