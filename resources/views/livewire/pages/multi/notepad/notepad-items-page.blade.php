<div>
    <section class="notebook  animate-block" data-watch data-watch-once>
        <div class='notebook__container'>
            <div class="notebook__top">
                <div class="notebook__info">
                    <a href="javascript:void(0)" class="notebook__back" style='--icon:url(&quot;/img/icons/back.svg&quot;)'></a>
                    <h2 class="notebook__title block-title">{{ $notepad->name }}</h2>
                </div>
            </div>
            <div class="notebook__quest quest-block quest-block--alt">
                <div class="quest-block__info">
                    <h2 class="quest-block__title block-title">поиск
                        <br>
                        по каталогу
                    </h2>
                </div>
                <div class="quest-block__content">
                    <form action="#" class="quest-block__form form">
                        <div class="form__search">
                            <div class="form__search-input">
                                <input
                                    wire:model.live.debounce.300ms="search"
                                    autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="По артикулу,  ID товара, производителю, названию..." class="input">
                            </div>
                            <button type="submit" class="form__search-icon" style='--icon:url(&quot;/img/icons/15.svg&quot;)'></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="notebook__constructor">
                <form action="#" class="notebook__constructor-form form">
                    <div class="form__row">
                        <div class="form__column">
                            <div class="form__column-title">ПОКАЗАТЬ СТРОК:</div>
                            <div class="form__column-items">
                                <div class="form__column-item">
                                    <div class="form__column-checkbox checkbox">
                                        <input wire:model.live="perPage" id="cddd_1" data-error="Ошибка" class="checkbox__input" type="radio" value="10" name="form[]">
                                        <label for="cddd_1" class="checkbox__label">
															<span class="checkbox__text">10
															</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form__column-item">
                                    <div class="form__column-checkbox checkbox">
                                        <input wire:model.live="perPage" id="cddd_2" data-error="Ошибка" class="checkbox__input" type="radio" value="20" name="form[]">
                                        <label for="cddd_2" class="checkbox__label">
															<span class="checkbox__text">20
															</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form__column-item">
                                    <div class="form__column-checkbox checkbox">
                                        <input wire:model.live="perPage" id="cddd_3" data-error="Ошибка" class="checkbox__input" type="radio" value="30" name="form[]">
                                        <label for="cddd_3" class="checkbox__label">
															<span class="checkbox__text">30
															</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form__column-item">
                                    <div class="form__column-checkbox checkbox">
                                        <input wire:model.live="perPage" id="cddd_4" data-error="Ошибка" class="checkbox__input" type="radio" value="100" name="form[]">
                                        <label for="cddd_4" class="checkbox__label">
															<span class="checkbox__text">100
															</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form__column">
                            <div class="form__column-title">Сортировать:</div>
                            <div class="form__column-items form__column-items--two">
                                <div class="form__column-item">
                                    <div wire:ignore class="form__column-select">
                                        <select id="period-select" name="period" class="form">
                                            <option value="1">За день</option>
                                            <option value="2">За неделю</option>
                                            <option value="3">За месяц</option>
                                            <option value="4">За 3 месяца</option>
                                            <option value="5">За 6 месяцев</option>
                                            <option value="6" selected>По дате</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form__column-item">
                                    <div class="form__column-checkbox checkbox">
                                        <input wire:model.live="sortType" id="cdddf_1" data-error="Ошибка" class="checkbox__input" type="radio" value="manufacturer" name="form[]1">
                                        <label for="cdddf_1" class="checkbox__label">
															<span class="checkbox__text">Производитель
															</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form__column-item">
                                    <div class="form__column-checkbox checkbox">
                                        <input wire:model.live="sortType" id="cdddf_2" data-error="Ошибка" class="checkbox__input" type="radio" value="sku" name="form[]1">
                                        <label for="cdddf_2" class="checkbox__label">
															<span class="checkbox__text">Артикул
															</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form__column-item">
                                    <div class="form__column-checkbox checkbox">
                                        <input wire:model.live="sortType" id="cdddf_3" data-error="Ошибка" class="checkbox__input" type="radio" value="name" name="form[]1">
                                        <label for="cdddf_3" class="checkbox__label">
															<span class="checkbox__text">Наименование
															</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @if($notepadItems->hasPages())
                    <div class="notebook__pagination pagination">
                        {{-- Стрелка назад --}}
                        @if($notepadItems->onFirstPage())
                            <span class="pagination__arrow pagination__arrow--hidden" style='--icon:url("/img/icons/08.svg")'></span>
                        @else
                            <button wire:click="previousPage" wire:loading.attr="disabled"
                                    class="pagination__arrow" style='--icon:url("/img/icons/08.svg")'></button>
                        @endif

                        {{-- Список страниц --}}
                        <ul class="pagination__list">
                            @php
                                // Получаем элементы пагинации
                                $elements = $notepadItems->links()->elements[0] ?? [];
                                $currentPage = $notepadItems->currentPage();
                                $lastPage = $notepadItems->lastPage();
                            @endphp

                            {{-- Всегда показываем первую страницу --}}
                            @if($currentPage > 3)
                                <li>
                                    <button wire:click="gotoPage(1)" class="pagination__item">1</button>
                                </li>
                                @if($currentPage > 4)
                                    <li><span class="pagination__item">...</span></li>
                                @endif
                            @endif

                            {{-- Показываем страницы вокруг текущей --}}
                            @for($page = max(1, $currentPage - 2); $page <= min($lastPage, $currentPage + 2); $page++)
                                <li>
                                    @if($page == $currentPage)
                                        <span class="pagination__item _active">{{ $page }}</span>
                                    @else
                                        <button wire:click="gotoPage({{ $page }})" class="pagination__item">{{ $page }}</button>
                                    @endif
                                </li>
                            @endfor

                            {{-- Всегда показываем последнюю страницу --}}
                            @if($currentPage < $lastPage - 2)
                                @if($currentPage < $lastPage - 3)
                                    <li><span class="pagination__item">...</span></li>
                                @endif
                                <li>
                                    <button wire:click="gotoPage({{ $lastPage }})" class="pagination__item">{{ $lastPage }}</button>
                                </li>
                            @endif
                        </ul>

                        {{-- Стрелка вперед --}}
                        @if($notepadItems->hasMorePages())
                            <button wire:click="nextPage" wire:loading.attr="disabled"
                                    class="pagination__arrow" style='--icon:url("/img/icons/09.svg")'></button>
                        @else
                            <span class="pagination__arrow pagination__arrow--hidden" style='--icon:url("/img/icons/09.svg")'></span>
                        @endif
                    </div>
                @endif
            </div>
            <div class="notebook__table table-block">
                <div class="table-block__scroll">
                    <div class="table-block__items">
                        <div class="table-block__item table-block__item--head">
                            <div class="table-block__row table-block__row--two">
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">ID товара</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Производитель</div>
                                    </div>
                                </div>
                                <div class="table-block__column ">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Артикул</div>
                                    </div>
                                </div>
                                <div class="table-block__column table-block__column--big">
                                    <div class="table-block__info">
                                        <div class="table-block__category">наименование</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Комментарий</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">УДАЛИТЬ</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach($notepadItems->items() as $key => $notepadItem)
                            @if($key % 2)
                                <div class="table-block__item">
                                    <div class="table-block__row table-block__row--two">
                                        <div class="table-block__column">
                                            <div class="table-block__info">
                                                <a href="{{ route('product.show', $notepadItem->product->sku) }}" class="table-block__text">{{ $notepadItem->product->id }}</a>
                                            </div>
                                        </div>
                                        <div class="table-block__column">
                                            <div class="table-block__info">
                                                <div class="table-block__text">{{ $notepadItem->product->manufacturer->name }}</div>
                                            </div>
                                        </div>
                                        <div class="table-block__column">
                                            <div class="table-block__info">
                                                <div class="table-block__text">{{ $notepadItem->product->sku }}</div>
                                            </div>
                                        </div>
                                        <div class="table-block__column table-block__column--big">
                                            <div class="table-block__info">
                                                <div class="table-block__text">{{ $notepadItem->product->name }}</div>
                                            </div>
                                        </div>
                                        <div class="table-block__column">
                                            <div class="table-block__info">
                                                <a
                                                    href="{{ route('popup.notepadComment', ['id' => $notepadItem->id]) }}"
                                                    data-popup="#callback-popupFive"
                                                    class="table-block__btn" style='--icon:url(&quot;/img/icons/20.svg&quot;)'></a>
                                            </div>
                                        </div>
                                        <div class="table-block__column">
                                            <div class="table-block__info">
                                                <a
                                                    wire:click="remove({{$notepadItem->id}})"
                                                    wire:confirm="Удалить заметку из блокнота?"
                                                    href="javascript:void(0)" class="table-block__btn" style='--icon:url(&quot;/img/icons/17.svg&quot;)'></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="table-block__item table-block__item--color" style='--color: #EDF0F4'>
                                    <div class="table-block__row table-block__row--two">
                                        <div class="table-block__column">
                                            <div class="table-block__info">
                                                <a href="{{ route('product.show', $notepadItem->product->sku) }}" class="table-block__text">{{ $notepadItem->product->id }}</a>
                                            </div>
                                        </div>
                                        <div class="table-block__column">
                                            <div class="table-block__info">
                                                <div class="table-block__text">{{ $notepadItem->product->manufacturer->name }}</div>
                                            </div>
                                        </div>
                                        <div class="table-block__column">
                                            <div class="table-block__info">
                                                <div class="table-block__text">{{ $notepadItem->product->sku }}</div>
                                            </div>
                                        </div>
                                        <div class="table-block__column table-block__column--big">
                                            <div class="table-block__info">
                                                <div class="table-block__text">{{ $notepadItem->product->name }}</div>
                                            </div>
                                        </div>
                                        <div class="table-block__column">
                                            <div class="table-block__info">
                                                <a
                                                    href="{{ route('popup.notepadComment', ['id' => $notepadItem->id]) }}"
                                                    data-popup="#callback-popupFive"
                                                    class="table-block__btn" style='--icon:url(&quot;/img/icons/20.svg&quot;)'></a>
                                            </div>
                                        </div>
                                        <div class="table-block__column">
                                            <div class="table-block__info">
                                                <a
                                                    wire:click="remove({{$notepadItem->id}})"
                                                    wire:confirm="Удалить заметку из блокнота?"
                                                    href="javascript:void(0)" class="table-block__btn" style='--icon:url(&quot;/img/icons/17.svg&quot;)'></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("selectCallback", function(e) {
            const periodSelect = document.getElementById('period-select');

            if (periodSelect) {
            @this.set('period', periodSelect.value);
            }
        });

        // На случай если обычные события тоже работают
        document.addEventListener('change', function(e) {
            if (e.target && e.target.id === 'period-select') {
            @this.set('period', e.target.value);
            }
        });
    </script>
</div>
