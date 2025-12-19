<div>
    <div class="breadcrumb">
        <ul class="breadcrumb__list breadcrumb__container">
            <li class="breadcrumb__item" style='--icon:url(&quot;/img/icons/10.svg&quot;)'>
								<span>
									<a href="javascript:void(0)">
										<span>
											Главная
										</span>
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
    <section class="manufacturer  animate-block" data-watch data-watch-once>
        <div class='manufacturer__container'>
            <h2 class="manufacturer__title block-title">Каталог</h2>
            <div class="manufacturer__quest quest-block quest-block--alt">
                <div class="quest-block__info">
                    <h2 class="quest-block__title block-title">поиск<br>по каталогу</h2>
                </div>
                <div class="quest-block__content">
                    <form wire:submit.prevent="applyFilters" class="quest-block__form form">
                        <div class="form__search">
                            <div class="form__search-input">
                                <input autocomplete="off" type="text" name="form[]" wire:model.live="search"
                                       data-error="Ошибка"
                                       placeholder="По артикулу, ID товара, производителю, названию..."
                                       class="input">
                            </div>
                            <button type="submit" class="form__search-icon"
                                    style='--icon:url(&quot;/img/icons/15.svg&quot;)'></button>
                        </div>
                    </form>

                    <!-- История поиска -->
                    @if($searchHistory && count($searchHistory) > 0)
                        <div class="search-history-panel">
                            <div class="search-history-panel__header">
                                <div class="search-history-panel__title">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"/>
                                    </svg>
                                    <span>История поиска:</span>
                                </div>
                                <button type="button"
                                        wire:click="clearSearchHistory"
                                        class="search-history-panel__clear"
                                        title="Очистить историю">
                                    Очистить всё
                                </button>
                            </div>

                            <div class="search-history-panel__items">
                                @foreach($searchHistory as $query)
                                    <div class="search-history-panel__item">
                                        <button type="button"
                                                wire:click="searchFromHistory('{{ $query }}')"
                                                class="search-history-panel__query"
                                                title="Повторить поиск: {{ $query }}">
                                            {{ Str::limit($query, 25) }}
                                        </button>
                                        <button type="button"
                                                wire:click.stop="removeFromHistory('{{ $query }}')"
                                                class="search-history-panel__remove"
                                                title="Удалить">
                                            ×
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <style>
                .search-history-panel {
                    margin-top: 12px;
                    padding: 12px;
                    background: #f9fafb;
                    border-radius: 8px;
                    border: 1px solid #e5e7eb;
                }

                .search-history-panel__header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 8px;
                    padding-bottom: 8px;
                    border-bottom: 1px solid #e5e7eb;
                }

                .search-history-panel__title {
                    display: flex;
                    align-items: center;
                    gap: 6px;
                    font-size: 13px;
                    color: #6b7280;
                    font-weight: 500;
                }

                .search-history-panel__title svg {
                    width: 14px;
                    height: 14px;
                    color: #9ca3af;
                }

                .search-history-panel__clear {
                    font-size: 12px;
                    color: #9ca3af;
                    background: none;
                    border: none;
                    padding: 2px 6px;
                    border-radius: 4px;
                    cursor: pointer;
                    transition: all 0.2s;
                }

                .search-history-panel__clear:hover {
                    color: #ef4444;
                    background: #fef2f2;
                }

                .search-history-panel__items {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 6px;
                }

                .search-history-panel__item {
                    display: flex;
                    align-items: center;
                    background: white;
                    border: 1px solid #d1d5db;
                    border-radius: 16px;
                    overflow: hidden;
                    transition: all 0.2s;
                }

                .search-history-panel__item:hover {
                    border-color: #9ca3af;
                    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                }

                .search-history-panel__query {
                    padding: 4px 10px;
                    background: none;
                    border: none;
                    font-size: 12px;
                    color: #4b5563;
                    cursor: pointer;
                    text-align: left;
                    max-width: 120px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    flex-grow: 1;
                    transition: color 0.2s;
                }

                .search-history-panel__query:hover {
                    color: #3b82f6;
                }

                .search-history-panel__remove {
                    width: 22px;
                    height: 22px;
                    background: none;
                    border: none;
                    font-size: 16px;
                    color: #9ca3af;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: all 0.2s;
                    flex-shrink: 0;
                }

                .search-history-panel__remove:hover {
                    color: #ef4444;
                    background: #fef2f2;
                }

                /* Адаптивность */
                @media (max-width: 768px) {
                    .search-history-panel {
                        padding: 10px;
                        margin-top: 10px;
                    }

                    .search-history-panel__items {
                        gap: 4px;
                    }

                    .search-history-panel__query {
                        max-width: 100px;
                        padding: 3px 8px;
                        font-size: 11px;
                    }

                    .search-history-panel__remove {
                        width: 20px;
                        height: 20px;
                        font-size: 14px;
                    }
                }
            </style>

            <div class="manufacturer__body">
                <aside class="manufacturer__aside aside">
                    <div class="aside__title">Фильтр</div>
                    <button type="button" class="aside__close" style='--icon:url(&quot;/img/icons/38.svg&quot;)'></button>
                    <div class="aside__inner">
                        <form wire:submit.prevent="applyFilters" class="aside__form form">
                            <fieldset class="form__fieldset">
                                <div class="form__fieldset-title">Производители</div>
                                <div class="form__fieldset-search form">
                                    <div class="form__search">
                                        <div class="form__search-input">
                                            <input
                                                wire:model.live.debounce.100ms="searchManufacturers"
                                                autocomplete="off"
                                                type="text"
                                                name="form[]"
                                                data-error="Ошибка"
                                                placeholder="Производитель..."
                                                class="input"
                                            >
                                        </div>
                                        <button type="button" class="form__search-icon" style="--icon:url(&quot;/img/icons/15.svg&quot;)"></button>
                                    </div>
                                </div>
                                <div class="form__fieldset-inner">
                                    <div class="form__fieldset-checkboxs js-search">
                                        @foreach($manufacturers as $manufacturer)
                                            <div class="form__fieldset-checkbox checkbox">
                                                <input
                                                    wire:model.live="selectedManufacturers"
                                                    id="manufacturer_{{ $manufacturer->id }}"
                                                    data-error="Ошибка"
                                                    class="checkbox__input"
                                                    type="checkbox"
                                                    value="{{ $manufacturer->id }}"
                                                    name="manufacturers[]"
                                                >
                                                <label for="manufacturer_{{ $manufacturer->id }}" class="checkbox__label">
                                                    <span class="checkbox__text">{{ $manufacturer->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form__fieldset">
                                <div class="form__fieldset-title">Наличие и акции</div>
                                <div class="form__fieldset-inner">
                                    <div class="form__fieldset-checkboxs js-search">
                                        <div class="form__fieldset-checkbox checkbox">
                                            <input
                                                wire:model.live="inStockOnly"
                                                id="in_stock_only"
                                                data-error="Ошибка"
                                                class="checkbox__input"
                                                type="checkbox"
                                                name="in_stock"
                                            >
                                            <label for="in_stock_only" class="checkbox__label">
                                                <span class="checkbox__text">Только в наличии</span>
                                            </label>
                                        </div>
                                        <div class="form__fieldset-checkbox checkbox">
                                            <input
                                                wire:model.live="onSaleOnly"
                                                id="on_sale_only"
                                                data-error="Ошибка"
                                                class="checkbox__input"
                                                type="checkbox"
                                                name="on_sale"
                                            >
                                            <label for="on_sale_only" class="checkbox__label">
                                                <span class="checkbox__text">Участвует в акции</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form__bottom">
                                <button type="button" wire:click="applyFilters" class="form__bottom-btn btn btn--blue">
                                    ПОКАЗАТЬ
                                    <span>{{ $productsCount }}</span>
                                </button>

                                @if(count($selectedManufacturers) > 0 || $inStockOnly || $onSaleOnly || $searchManufacturers)
                                    <button type="button" wire:click="resetFilters" class="form__bottom-btn btn btn--outline">
                                        Сбросить фильтры
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </aside>
                <div class="manufacturer__main">
                    <a href="javascript:void(0)" class="manufacturer__filter btn btn--blue">фильтры</a>
                    <div class="notebook__table table-block">
                        <div class="table-block__scroll">
                            <div class="table-block__items">
                                <div class="table-block__item table-block__item--head">
                                    <div class="table-block__row table-block__row--eleven">
                                        <div class="table-block__column">
                                            <div class="table-block__info">
                                                <div class="table-block__category">
                                                    ID товара</div>
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
                                @foreach($products as $key => $product)
                                    @if ($key % 2)
                                        <div class="table-block__item table-block__item--color" style='--color: #ffffff'>
                                            <div class="table-block__row table-block__row--eleven">
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <a href="{{ route('product.show', $product->sku) }}" class="table-block__text">{{ $product->id }}</a>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product->manufacturer?->name }}</div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product->sku }}</div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column table-block__column--big">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text" style="font-weight: bold;">{{ $product->name }}</div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        @if(!$product->productSubstitutions->isEmpty())
                                                            <a href="{{ route('product.show', $product->sku) }}" class="table-block__btn" style='--icon:url(&quot;/img/icons/39.svg&quot;)'></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="table-block__item table-block__item--color" style='--color: #ECEEF2'>
                                            <div class="table-block__row table-block__row--eleven">
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <a href="{{ route('product.show', $product->sku) }}" class="table-block__text">{{ $product->id }}</a>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product->manufacturer?->name }}</div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product->sku }}</div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column table-block__column--big">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text" style="font-weight: bold;">{{ $product->name }}</div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        @if(!$product->productSubstitutions->isEmpty())
                                                            <a href="{{ route('product.show', $product->sku) }}" class="table-block__btn" style='--icon:url(&quot;/img/icons/39.svg&quot;)'></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    </div>
{{--                    @if($hasMore)--}}
{{--                        <a href="javascript:void(0)" class="notebook__showmore btn btn--showmore">Просмотреть еще</a>--}}
{{--                    @endif--}}
                </div>
            </div>

        </div>
    </section>
</div>
