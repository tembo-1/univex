<div>
    <!-- Хлебные крошки -->
    <div class="breadcrumb">
        <ul class="breadcrumb__list breadcrumb__container">
            <li class="breadcrumb__item" style='--icon:url("/img/icons/10.svg")'>
                <span>
                    <a href="{{ route('home') }}">
                        <span>Главная</span>
                    </a>
                </span>
            </li>
            <li class="breadcrumb__item breadcrumb__item--active">
                <span>
                    <span>Каталог</span>
                </span>
            </li>
        </ul>
    </div>

    <!-- Основной контент каталога -->
    <section class="manufacturer animate-block fade-up" data-watch data-watch-once>
        <div class='manufacturer__container'>
            <h2 class="manufacturer__title block-title">Каталог</h2>

            <!-- Поиск -->
            <div class="manufacturer__quest quest-block quest-block--alt">
                <div class="quest-block__info">
                    <h2 class="quest-block__title block-title">поиск<br>по каталогу</h2>
                </div>
                <div class="quest-block__content">
                    <form class="quest-block__form form" wire:submit.prevent>
                        <div class="form__search">
                            <div class="form__search-input">
                                <input autocomplete="off"
                                       type="text"
                                       data-error="Ошибка"
                                       placeholder="По артикулу, ID товара, производителю, названию..."
                                       class="input"
                                       wire:model.live.debounce.500ms="search">
                            </div>
                            <button type="submit"
                                    class="form__search-icon"
                                    style='--icon:url("/img/icons/15.svg")'></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="manufacturer__body">
                <!-- Фильтры -->
                <aside class="manufacturer__aside aside {{ $showFilters ? 'aside--active' : '' }}">
                    <div class="aside__title">Фильтр</div>
                    <button type="button"
                            class="aside__close"
                            style='--icon:url("/img/icons/38.svg")'
                            wire:click="$set('showFilters', false)"></button>

                    <div class="aside__inner">
                        <form class="aside__form form" wire:submit.prevent>
                            <!-- Производители -->
                            <fieldset class="form__fieldset">
                                <div class="form__fieldset-title">Производители</div>
                                <div class="form__fieldset-search form">
                                    <div class="form__search">
                                        <div class="form__search-input">
                                            <input autocomplete="off"
                                                   type="text"
                                                   placeholder="Производитель..."
                                                   class="input"
                                                   wire:model.live.debounce.300ms="manufacturerSearch">
                                        </div>
                                        <button type="submit"
                                                class="form__search-icon"
                                                style="--icon:url('/img/icons/15.svg')"></button>
                                    </div>
                                </div>

                                <div class="form__fieldset-inner">
                                    <div class="form__fieldset-checkboxs">
                                        @foreach($this->manufacturers as $manufacturer)
                                            <div class="form__fieldset-checkbox checkbox">
                                                <input id="manufacturer_{{ $manufacturer->id }}"
                                                       class="checkbox__input"
                                                       type="checkbox"
                                                       value="{{ $manufacturer->id }}"
                                                       wire:model.live="selectedManufacturers">
                                                <label for="manufacturer_{{ $manufacturer->id }}"
                                                       class="checkbox__label">
                                                    <span class="checkbox__text">{{ $manufacturer->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach

                                        @if($this->manufacturers->isEmpty())
                                            <div class="text-muted">Производители не найдены</div>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Наличие и акции -->
                            <fieldset class="form__fieldset">
                                <div class="form__fieldset-title">наличие и акции</div>
                                <div class="form__fieldset-inner">
                                    <div class="form__fieldset-checkboxs">
                                        <div class="form__fieldset-checkbox checkbox">
                                            <input id="in_stock"
                                                   class="checkbox__input"
                                                   type="checkbox"
                                                   wire:model.live="inStock">
                                            <label for="in_stock" class="checkbox__label">
                                                <span class="checkbox__text">Только в наличии</span>
                                            </label>
                                        </div>
                                        <div class="form__fieldset-checkbox checkbox">
                                            <input id="on_sale"
                                                   class="checkbox__input"
                                                   type="checkbox"
                                                   wire:model.live="onSale">
                                            <label for="on_sale" class="checkbox__label">
                                                <span class="checkbox__text">Участвует в акции</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form__bottom">
                                <button type="button"
                                        class="form__bottom-btn btn btn--blue"
                                        wire:click="clearFilters">
                                    ПОКАЗАТЬ
                                    <span>{{ $this->filteredProductsCount }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </aside>

                <!-- Основной контент -->
                <div class="manufacturer__main">
                    <!-- Кнопка фильтров для мобильных -->
                    <button type="button"
                            class="manufacturer__filter btn btn--blue"
                            wire:click="toggleFilters">
                        фильтры
                        @if(count($selectedManufacturers) > 0 || $inStock || $onSale)
                            <span class="filter-badge">{{ count($selectedManufacturers) + ($inStock ? 1 : 0) + ($onSale ? 1 : 0) }}</span>
                        @endif
                    </button>

                    <!-- Таблица товаров -->
                    <div class="notebook__table table-block">
                        <div class="table-block__scroll">
                            <div class="table-block__items">
                                <!-- Заголовки таблицы -->
                                <div class="table-block__item table-block__item--head">
                                    <div class="table-block__row table-block__row--eleven">
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
                                        <div class="table-block__column">
                                            <div class="table-block__info">
                                                <div class="table-block__category">Артикул</div>
                                            </div>
                                        </div>
                                        <div class="table-block__column table-block__column--big">
                                            <div class="table-block__info">
                                                <div class="table-block__category">Название</div>
                                            </div>
                                        </div>
                                        <div class="table-block__column">
                                            <div class="table-block__info">
                                                <div class="table-block__category">Замены</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Строки товаров -->
                                @forelse($this->products as $index => $product)
                                    <div class="table-block__item table-block__item--color"
                                         style='--color: {{ $index % 2 === 0 ? '#ECEEF2' : '#ffffff' }}'>
                                        <div class="table-block__row table-block__row--eleven">
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <a href=""
                                                       class="table-block__text">{{ $product->id }}</a>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__text">{{ $product->manufacturer->name ?? '-' }}</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__text">{{ $product->article }}</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column table-block__column--big">
                                                <div class="table-block__info">
                                                    <div class="table-block__text">{{ $product->name }}</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    @if($product->replacements && count($product->replacements) > 0)
                                                        <button type="button"
                                                                class="table-block__btn"
                                                                style='--icon:url("/img/icons/39.svg")'
                                                                wire:click="$dispatch('showReplacements', { productId: {{ $product->id }} })">
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="table-block__item">
                                        <div class="table-block__row table-block__row--eleven">
                                            <div class="table-block__column" colspan="5">
                                                <div class="table-block__info text-center py-4">
                                                    @if($search || !empty($selectedManufacturers) || $inStock || $onSale)
                                                        Товары не найдены. Попробуйте изменить параметры поиска.
                                                    @else
                                                        Товары пока не добавлены.
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Кнопка "Просмотреть еще" -->
                    @if($this->products->hasMorePages())
                        <button type="button"
                                class="notebook__showmore btn btn--showmore"
                                wire:click="$set('perPage', {{ $perPage + 20 }})"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Просмотреть еще</span>
                            <span wire:loading>Загрузка...</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
