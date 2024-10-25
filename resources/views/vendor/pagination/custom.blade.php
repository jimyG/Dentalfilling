<!-- resources/views/vendor/pagination/custom.blade.php -->
@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            {{-- Botón "Anterior" --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">&laquo;</a></li>
            @endif

            {{-- Links de las páginas --}}
            @foreach ($elements as $element)
                {{-- Elipses --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Links de las páginas --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Botón "Siguiente" --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
