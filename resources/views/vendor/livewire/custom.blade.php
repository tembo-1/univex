@if ($paginator->hasPages())
    <div class="admission__pagination pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="pagination__arrow pagination__arrow--hidden" style='--icon:url("/img/icons/08.svg")'></span>
        @else
            <button type="button" wire:click="previousPage" class="pagination__arrow" style='--icon:url("/img/icons/08.svg")'></button>
        @endif

        {{-- Pagination Elements --}}
        <ul class="pagination__list">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="pagination__item _active">{{ $page }}</span></li>
                        @else
                            <li><button type="button" wire:click="gotoPage({{ $page }})" class="pagination__item">{{ $page }}</button></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <button type="button" wire:click="nextPage" class="pagination__arrow" style='--icon:url("/img/icons/09.svg")'></button>
        @else
            <span class="pagination__arrow pagination__arrow--hidden" style='--icon:url("/img/icons/09.svg")'></span>
        @endif
    </div>
@endif
