@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navegación de páginas">
        <ul class="pagination pagination-sm m-0 align-items-center gap-1">
            {{-- Enlace Anterior --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="Anterior">
                    <span class="page-link" aria-hidden="true">
                        <i class="fas fa-chevron-left" style="font-size: 11px;"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Anterior">
                        <i class="fas fa-chevron-left" style="font-size: 11px;"></i>
                    </a>
                </li>
            @endif

            {{-- Elementos de Páginas --}}
            @foreach ($elements as $element)
                {{-- Separador "..." --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array de Enlaces Numéricos --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Enlace Siguiente --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Siguiente">
                        <i class="fas fa-chevron-right" style="font-size: 11px;"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="Siguiente">
                    <span class="page-link" aria-hidden="true">
                        <i class="fas fa-chevron-right" style="font-size: 11px;"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
