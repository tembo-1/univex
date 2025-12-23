<div>
    <section wire:ignore class="manufacturer  animate-block fade-up" data-watch data-watch-once>
        <div class='manufacturer__container'>
            <div class="manufacturer__gallery gallery-block">
                <div class="gallery-block__inner">
                    <div class="gallery-block__sliders">
                        <div class="gallery-block__slider swiper js-slider-gallery">
                            <div class="gallery-block__swiper swiper-wrapper">
                                <a href="javascript:void(0)" class="gallery-block__slide swiper-slide">
                                    <div class="gallery-block__img">
                                        <picture>
                                            <img src="http://localhost:3377/documents/posts/05.webp" srcset="http://localhost:3377/documents/posts/05.webp 2x" alt="">
                                        </picture>
                                    </div>
                                    <div class="gallery-block__icon" style='--icon:url(&quot;/img/icons/41.svg&quot;)'></div>
                                </a>
                                <a href="javascript:void(0)" class="gallery-block__slide swiper-slide">
                                    <div class="gallery-block__img">
                                        <picture>
                                            <img src="http://localhost:3377/documents/posts/05.webp" srcset="http://localhost:3377/documents/posts/05.webp 2x" alt="">
                                        </picture>
                                    </div>
                                    <div class="gallery-block__icon" style='--icon:url(&quot;/img/icons/41.svg&quot;)'></div>
                                </a>
                                <a href="javascript:void(0)" class="gallery-block__slide swiper-slide">
                                    <div class="gallery-block__img">
                                        <picture>
                                            <img src="http://localhost:3377/documents/posts/05.webp" srcset="http://localhost:3377/documents/posts/05.webp 2x" alt="">
                                        </picture>
                                    </div>
                                    <div class="gallery-block__icon" style='--icon:url(&quot;/img/icons/41.svg&quot;)'></div>
                                </a>
                                <a href="javascript:void(0)" class="gallery-block__slide swiper-slide">
                                    <div class="gallery-block__img">
                                        <picture>
                                            <img src="http://localhost:3377/documents/posts/05.webp" srcset="http://localhost:3377/documents/posts/05.webp 2x" alt="">
                                        </picture>
                                    </div>
                                    <div class="gallery-block__icon" style='--icon:url(&quot;/img/icons/41.svg&quot;)'></div>
                                </a>
                            </div>
                        </div>
                        <div class="gallery-block__bottom">
                            <div class="gallery-block__thumbs swiper js-slider-thumbs">
                                <div class="gallery-block__swiper swiper-wrapper">
                                    <div class="gallery-block__gallery swiper-slide">
                                        <div class="gallery-block__image">
                                            <picture>
                                                <img src="http://localhost:3377/documents/posts/05.webp" srcset="http://localhost:3377/documents/posts/05.webp 2x" alt="">
                                            </picture>
                                        </div>
                                    </div>
                                    <div class="gallery-block__gallery swiper-slide">
                                        <div class="gallery-block__image">
                                            <picture>
                                                <img src="http://localhost:3377/documents/posts/05.webp" srcset="http://localhost:3377/documents/posts/05.webp 2x" alt="">
                                            </picture>
                                        </div>
                                    </div>
                                    <div class="gallery-block__gallery swiper-slide">
                                        <div class="gallery-block__image">
                                            <picture>
                                                <img src="http://localhost:3377/documents/posts/05.webp" srcset="http://localhost:3377/documents/posts/05.webp 2x" alt="">
                                            </picture>
                                        </div>
                                    </div>
                                    <div class="gallery-block__gallery swiper-slide">
                                        <div class="gallery-block__image">
                                            <picture>
                                                <img src="http://localhost:3377/documents/posts/05.webp" srcset="http://localhost:3377/documents/posts/05.webp 2x" alt="">
                                            </picture>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery-block__arrows">
                                    <button type="button" class="gallery-block__arrow gallery-block__arrow--prev" style='--icon:url(&quot;/img/icons/42.svg&quot;)'></button>
                                    <button type="button" class="gallery-block__arrow gallery-block__arrow--next" style='--icon:url(&quot;/img/icons/43.svg&quot;)'></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gallery-block__content">
                        <div class="gallery-block__top" data-da=".gallery-block__inner, 992, 0">
                            <a href="javascript:void(0)" class="gallery-block__back" style='--icon:url(&quot;/img/icons/back.svg&quot;)'></a>
                            <div class="gallery-block__title">{{ $product->name }}</div>
                        </div>
                        <div class="gallery-block__items">
                            <dl class="gallery-block__item">
                                <dt class="gallery-block__category">Артикул:</dt>
                                <dd class="gallery-block__value">{{ $product->sku }}</dd>
                            </dl>
                            <dl class="gallery-block__item">
                                <dt class="gallery-block__category">Производитель:</dt>
                                <dd class="gallery-block__value">{{ $product->manufacturer->name }}</dd>
                            </dl>
                        </div>
                        <div class="gallery-block__btns">
                            <a href="javascript:void(0)" class="gallery-block__btn btn btn--border">ПОДРОБНЕЕ</a>
                            <a href="javascript:void(0)" class="gallery-block__btn btn btn--gry btn--icon" style='--icon:url(&quot;/img/icons/44.svg&quot;)'>Оригинальные номера</a>
                            <a href="{{ route('notepad', ['productSlug' => $product->sku]) }}" class="gallery-block__btn btn btn--icon" style='--icon:url(&quot;/img/icons/03.svg&quot;)'>Блокнот</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="manufacturer__body ">
                <aside class="manufacturer__aside aside">
                    <div class="aside__title">Фильтр</div>
                    <button type="button" class="aside__close" style='--icon:url(&quot;/img/icons/38.svg&quot;)'></button>
                    <div class="aside__inner">
                        <form wire:submit.prevent="applyFilters" class="aside__form form">
                            <fieldset class="form__fieldset">
                                <div class="form__fieldset-title">Цена, ₽</div>
                                <div class="form__fieldset-range range js-range" data-range>
                                    <div data-range-item></div>

                                    <div class="range__values js-range-values">
                                        <div class="range__value" data-value="от">
                                            <input wire:model.live="minPrice" id="rng2" class="input range__range-value" autocomplete="off" type="text" name="minPrice" aria-label="Минимальное значение" placeholder="" data-range-min="0">
                                        </div>
                                        <div class="range__value" data-value="до">
                                            <input wire:model.live="maxPrice" class="input range__range-value" autocomplete="off" aria-label="Максимальное значение" type="text" name="maxPrice" placeholder="" data-range-max="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="form__fieldset-inner">
                                    <div class="form__fieldset-checkboxs js-search">
                                        <div class="form__fieldset-checkbox checkbox">
                                            <input id="csssddd_1" data-error="Ошибка" class="checkbox__input" type="checkbox" value="central" name="form[]">
                                            <label for="csssddd_1" class="checkbox__label">
                                                <span class="checkbox__text">Центральный склад</span>
                                            </label>
                                        </div>
                                        <div class="form__fieldset-checkbox checkbox">
                                            <input id="csssddd_2" data-error="Ошибка" class="checkbox__input" type="checkbox" value="partner" name="form[]">
                                            <label for="csssddd_2" class="checkbox__label">
                                                <span class="checkbox__text">Партнерская сеть</span>
                                            </label>
                                        </div>
                                        <div class="form__fieldset-checkbox checkbox">
                                            <input id="csssddd_3" data-error="Ошибка" class="checkbox__input" type="checkbox" value="inStockOnly" name="form[]">
                                            <label for="csssddd_3" class="checkbox__label">
                                                <span class="checkbox__text">Только в наличии</span>
                                            </label>
                                        </div>
                                        <div class="form__fieldset-checkbox checkbox">
                                            <input id="csssddd_4" data-error="Ошибка" class="checkbox__input" type="checkbox" value="onSaleOnly" name="form[]">
                                            <label for="csssddd_4" class="checkbox__label">
                                                <span class="checkbox__text">Участвует в акции</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
{{--                            <fieldset class="form__fieldset">--}}
{{--                                <div class="form__fieldset-title">Дата отгрузки</div>--}}

{{--                                <div class="form__fieldset-selects">--}}
{{--                                    <div class="form__fieldset-select">--}}
{{--                                        <select name="form[]" class="form">--}}
{{--                                            <option value="1" selected>Завтра</option>--}}
{{--                                            <option value="2">Пункт №2</option>--}}
{{--                                            <option value="3">Пункт №3</option>--}}
{{--                                            <option value="4">Пункт №4</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </fieldset>--}}
                            <fieldset class="form__fieldset">
                                <div class="form__fieldset-title">Фильтры</div>
                                <div class="form__fieldset-checkboxs form__fieldset-checkboxs--radio">
                                    <div class="form__fieldset-checkbox checkbox">
                                        <input id="csssss_1" data-error="Ошибка" class="checkbox__input" type="radio" value="byPrice" name="form[]">
                                        <label for="csssss_1" class="checkbox__label">
															<span class="checkbox__text">По цене
															</span>
                                        </label>
                                    </div>
                                    <div class="form__fieldset-checkbox checkbox">
                                        <input id="csssss_2" data-error="Ошибка" class="checkbox__input" type="radio" value="byName" name="form[]">
                                        <label for="csssss_2" class="checkbox__label">
															<span class="checkbox__text">По алфавиту
															</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form__fieldset-inner">
                                    <div class="form__fieldset-checkboxs form__fieldset-checkboxs--two js-search">
                                        @foreach($manufacturers as $manufacturer)
                                            <div class="form__fieldset-checkbox checkbox">
                                                <input id="csss_1" data-error="Ошибка" class="checkbox__input" type="checkbox" value="{{ $manufacturer['id'] }}" name="form[]">
                                                <label for="csss_1" class="checkbox__label">
																<span class="checkbox__text">{{ $manufacturer['name'] }}
																</span>
                                                    <span class="checkbox__value">от {{ $manufacturer['price'] }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form__bottom">
                                <button type="submit" class="form__bottom-btn btn btn--blue">ПОКАЗАТЬ
                                    <span>{{ $filteredCount }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </aside>
                <div class="manufacturer__main">
                    <a href="javascript:void(0)" class="manufacturer__filter btn btn--blue">фильтры</a>
                    <div class="notebook__blocks">
                        <div class="notebook__table table-block">
                            <div class="table-block__title">НАЛИЧИЕ НА СКЛАДАХ</div>
                            <div class="table-block__scroll">
                                <div class="table-block__items">
                                    <div class="table-block__item table-block__item--head">
                                        <div class="table-block__row table-block__row--twelve">
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
                                                    <div class="table-block__category">наличие</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__category">склад</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__category">Дата отгрузки</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__category">ЦЕНА, ₽</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__category">Заказ</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($products->where('type', 'main') as $product)
                                        <div class="table-block__item table-block__item--color" style='--color: #ECEEF2'>
                                            <div class="table-block__row table-block__row--twelve">
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <a href="javascript:void(0)" class="table-block__text">{{ $product['id'] }}</a>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product['manufacturer']->name }}</div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product['sku'] }}</div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column table-block__column--big">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product['name'] }}</div>
                                                        @if($product['minOrderQuantity'] > 1)
                                                            <div class="table-block__attention">минимальный заказ от 10 шт.</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product['quantity'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product['warehouse']->cleanName }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">12.09.2025
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product['price'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <a wire:click="addToCart({{ $product['warehouseProduct'] }})" href="javascript:void(0)" class="table-block__basket" style='--icon:url(&quot;/img/icons/45.svg&quot;);
                                                         @if($product['in_cart']) background: #026DCA @endif'
                                                        ></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="notebook__table table-block">
                            <div class="table-block__title">Замены</div>
                            <div class="table-block__scroll">
                                <div class="table-block__items">
                                    <div class="table-block__item table-block__item--head">
                                        <div class="table-block__row table-block__row--twelve">
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
                                                    <div class="table-block__category">наличие</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__category">склад</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__category">Дата отгрузки</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__category">ЦЕНА, ₽</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__category">Заказ</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($products->where('type', 'substitute') as $product)
                                        <div class="table-block__item table-block__item--color" style='--color: #ECEEF2'>
                                            <div class="table-block__row table-block__row--twelve">
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <a href="{{ route('product.show', $product['sku']) }}" class="table-block__text">{{ $product['id'] }}</a>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product['manufacturer']->name }}</div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product['sku'] }}</div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column table-block__column--big">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product['name'] }}</div>
                                                        @if($product['minOrderQuantity'] > 1)
                                                            <div class="table-block__attention">минимальный заказ от 10 шт.</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product['quantity'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product['warehouse']->cleanName }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">12.09.2025
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $product['price'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <a wire:click="addToCart({{ $product['warehouseProduct'] }})" href="javascript:void(0)" class="table-block__basket" style='--icon:url(&quot;/img/icons/45.svg&quot;)'></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
