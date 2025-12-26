<div>
    <section class="notebook  animate-block" data-watch data-watch-once>
        <div class='notebook__container'>
            <div class="notebook__top">
                <div class="notebook__info">
                    <a href="javascript:void(0)" class="notebook__back" style='--icon:url(&quot;/img/icons/back.svg&quot;)'></a>
                    <h2 class="notebook__title block-title">Заказы</h2>
                </div>
            </div>
            <div class="notebook__quest quest-block quest-block--alt">
                <div class="quest-block__info">
                    <h2 class="quest-block__title block-title">поиск
                        <br>
                        товара в заказах
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
                <form wire:ignore class="notebook__constructor-form form" data-one-select>
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
                                    <div  class="form__column-select">
                                        <select id="status-select" name="status" class="form">
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                            <option selected>Статус</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form__column-item">
                                    <div class="form__column-select">
                                        <select id="period-select" name="period" class="form">
                                            <option value="1">За день</option>
                                            <option value="2">За неделю</option>
                                            <option value="3">За месяц</option>
                                            <option value="4">За 3 месяца</option>
                                            <option value="5">За 6 месяцев</option>
                                            <option selected>Дата создания</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @if($orders->hasPages())
                    <div class="notebook__pagination pagination">
                        {{-- Стрелка назад --}}
                        @if($orders->onFirstPage())
                            <span class="pagination__arrow pagination__arrow--hidden" style='--icon:url("/img/icons/08.svg")'></span>
                        @else
                            <button wire:click="previousPage" wire:loading.attr="disabled"
                                    class="pagination__arrow" style='--icon:url("/img/icons/08.svg")'></button>
                        @endif

                        {{-- Список страниц --}}
                        <ul class="pagination__list">
                            @php
                                // Получаем элементы пагинации
                                $elements = $orders->links()->elements[0] ?? [];
                                $currentPage = $orders->currentPage();
                                $lastPage = $orders->lastPage();
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
                        @if($orders->hasMorePages())
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
                            <div class="table-block__row table-block__row--six">
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">ДАТА заказа</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Номер заказа</div>
                                    </div>
                                </div>
                                <div class="table-block__column ">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Дата Обновления</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Сумма заказа, ₽</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">оплата</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">сТАТУС</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach($orders->items() as $key => $order)
                            <div class="table-block__item table-block__item--color" @if($key % 2)  @else style='--color: #EDF0F4' @endif>
                                <div class="table-block__row table-block__row--six">
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <a href="{{ route('orders.show', $order->id) }}" class="table-block__text">{{ $order->created_at }}</a>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $order->id }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $order->updated_at }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $order->totalAmount }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text"> @if($order->is_paid) Оплачено @else Не оплачено @endif</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column table-block__column--big">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $order->orderStatus->name }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("selectCallback", function(e) {
            const statusSelect = document.getElementById('status-select');
            const periodSelect = document.getElementById('period-select');

            // ✅ ТОЧНО КАК В БЛОКНОТЕ - БЕЗ проверок!
            if (statusSelect) @this.set('status', statusSelect.value);
            if (periodSelect) @this.set('period', periodSelect.value);
        });
    </script>
</div>
