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
									<span>Корзина</span>
								</span>
            </li>
        </ul>
    </div>
    <section class="manufacturer  animate-block">
        <div class='manufacturer__container'>
            <h2 class="manufacturer__title block-title" data-watch data-watch-once>КОРЗИНА</h2>
            <div class="manufacturer__inner">
                <div class="manufacturer__content">
                    <div class="manufacturer__block" data-watch data-watch-once>
                        <div class="manufacturer__quest quest-block quest-block--two">
                            <div class="quest-block__info">
                                <h2 class="quest-block__title block-title">Добавить
                                    <br>
                                    в корзину
                                </h2>
                            </div>
                            <div class="quest-block__content">
                                <form action="#" class="quest-block__form form">
                                    <div class="form__search">
                                        <div class="form__search-input">
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Артикул..." class="input">
                                        </div>
                                        <button type="submit" class="form__search-icon" style='--icon:url(&quot;/img/icons/15.svg&quot;)'></button>
                                    </div>
                                    <div class="form__constructor">
                                        <div data-quantity class="form__quantity quantity">
                                            <button data-quantity-minus type="button" class="quantity__button quantity__button--minus"></button>
                                            <div class="quantity__input">
                                                <input data-quantity-value autocomplete="off" type="number" name="form[]" value="1">
                                            </div>
                                            <button

                                                data-quantity-plus type="button" class="quantity__button quantity__button--plus"></button>
                                        </div>
                                        <a wire:click.prevent="add"
                                           href="javascript:void(0)"
                                           class="form__basket"
                                           style='--icon:url(&quot;/img/icons/basket.svg&quot;)'></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @foreach($notifications as $notification)
                            <div class="manufacturer__attention">
                                <div class="manufacturer__attention-text">
                                    {{ $notification->content }}
                                </div>
                            </div>
                        @endforeach
                        <div class="manufacturer__table table-block">
                            <div class="table-block__scroll">
                                <div class="table-block__items">
                                    <div class="table-block__item table-block__item--head">
                                        <div class="table-block__row">
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__category">Артикул</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__category">Производитель</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column table-block__column--big">
                                                <div class="table-block__info">
                                                    <div class="table-block__category">наименование</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__category">Количество</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__category">СТОИМОСТЬ, ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($cartItems as $cartItem)
                                        <div class="table-block__item">
                                            <div class="table-block__row">
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <a href="javascript:void(0)" class="table-block__text">{{ $cartItem->warehouseProduct->productPrice->product->sku }}</a>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <a href="javascript:void(0)" class="table-block__text">{{ $cartItem->warehouseProduct->productPrice->product->manufacturer->name }}</a>
                                                    </div>
                                                </div>
                                                <div class="table-block__column table-block__column--big">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $cartItem->warehouseProduct->productPrice->product->name }}</div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column" style="flex-direction: row">
                                                    <div class="table-block__info">
                                                        <div data-quantity class="table-block__quantity quantity">
                                                            <button
                                                                wire:click="decrement({{$cartItem->id}})"
                                                                data-quantity-minus type="button" class="quantity__button quantity__button--minus"></button>
                                                            <div class="quantity__input">
                                                                <input data-quantity-value disabled autocomplete="off" type="number" name="form[]" value="{{ $cartItem->quantity }}">
                                                            </div>
                                                            <button
                                                                wire:click="increment({{$cartItem->id}})"
                                                                data-quantity-plus type="button" class="quantity__button quantity__button--plus"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <div class="table-block__price">
                                                            <div class="table-block__total">{{ ($cartItem->quantity * $cartItem->price) / 100.0 }}</div>
                                                            <button
                                                                type="button"
                                                                class="remove-item"
                                                                wire:click="remove({{$cartItem->id}})"
                                                                wire:confirm="Удалить товар из корзины?"
                                                            >
                                                                <a href="javascript:void(0)" class="table-block__delete" style='--icon:url(&quot;/img/icons/17.svg&quot;)'></a>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="table-block__item">
                                        <div class="table-block__row">
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <a href="javascript:void(0)" class="table-block__text"></a>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__text"></div>
                                                </div>
                                            </div>
                                            <div class="table-block__column table-block__column--big">
                                                <div class="table-block__info">
                                                    <div class="table-block__blocks">
                                                        <div class="table-block__block block-table">
                                                            <div class="block-table__category">Цена действитела:</div>
                                                            <div class="block-table__value">24 часа</div>
                                                        </div>
                                                        <div class="table-block__block block-table">
                                                            <div class="block-table__category">Удаление позиций:
                                                            </div>
                                                            <div class="block-table__value">20 дней</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__result">Итого:</div>
                                                </div>
                                            </div>
                                            <div class="table-block__column">
                                                <div class="table-block__info">
                                                    <div class="table-block__sum">{{ $cart->total ?? null }} ₽</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        <a href="javascript:void(0)" class="manufacturer__btn btn btn--blue btn--icon" style='--icon:url(&quot;/img/icons/03.svg&quot;)'>Пересчитать цены</a>--}}
                    </div>
                    <div wire:ignore>
                        <div class="manufacturer__block" data-watch data-watch-once>
                            <h3 class="manufacturer__subtitle">Доставка заказа</h3>
                            <form action="#" class="manufacturer__choice">
                                <fieldset class="manufacturer__choice-block">
                                    <div class="manufacturer__choice-checkbox checkbox">
                                        <input id="csdfs_1" data-error="Ошибка" class="checkbox__input" type="radio" value="1" name="form[]" checked>
                                        <label for="csdfs_1" class="checkbox__label">
                                            <span class="checkbox__text">Самовывоз со склада</span>
                                        </label>
                                    </div>
                                    <div class="manufacturer__choice-hidden" hidden>
                                        <div class="manufacturer__choice-inner">
                                            <div class="manufacturer__choice-row">
                                                <div class="manufacturer__choice-column">
                                                    <div class="manufacturer__choice-checkbox checkbox">
                                                        <input id="csdfsdfsdfs_1" data-error="Ошибка" class="checkbox__input" type="radio" value="1" name="form[]1">
                                                        <label for="csdfsdfsdfs_1" class="checkbox__label"></label>
                                                    </div>
                                                    <div class="manufacturer__choice-info">
                                                        <address class="manufacturer__choice-address">мкр. Востряково, ул.Вокзальная, стр. 59В</address>
                                                        <div class="manufacturer__choice-take">Забирайте 28 июня, после 11:00
                                                        </div>
                                                        <time datetime="2016-11-18T09:54" class="manufacturer__choice-time">пн.-вс.: с 9:00 до 20:00</time>
                                                    </div>
                                                </div>
                                                <div class="manufacturer__choice-column">
                                                    <div class="manufacturer__choice-checkbox checkbox">
                                                        <input id="csdfsdfsdfs_2" data-error="Ошибка" class="checkbox__input" type="radio" value="1" name="form[]1">
                                                        <label for="csdfsdfsdfs_2" class="checkbox__label"></label>
                                                    </div>
                                                    <div class="manufacturer__choice-info">
                                                        <address class="manufacturer__choice-address">мкр. Востряково, ул.Вокзальная, стр. 59В</address>
                                                        <div class="manufacturer__choice-take">Забирайте 28 июня, после 11:00
                                                        </div>
                                                        <time datetime="2016-11-18T09:54" class="manufacturer__choice-time">пн.-вс.: с 9:00 до 20:00</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="manufacturer__choice-block">
                                    <div class="manufacturer__choice-checkbox checkbox">
                                        <input id="csdfs_2" data-error="Ошибка" class="checkbox__input" type="radio" value="1" name="form[]">
                                        <label for="csdfs_2" class="checkbox__label">
														<span class="checkbox__text">Доставка
														</span>
                                        </label>
                                    </div>
                                    <div class="manufacturer__choice-hidden" hidden>
                                        <div class="manufacturer__choice-inner">
                                            <div class="manufacturer__choice-items">
                                                <div class="manufacturer__choice-item item-manufacturer">
                                                    <div class="item-manufacturer__title">Адрес доставки</div>
                                                    <div class="item-manufacturer__textarea">
                                                        <textarea class="input" placeholder="Введите что-то..." data-autoheight data-autoheight-min="91" data-autoheight-max="300"></textarea>
                                                    </div>
                                                </div>
                                                <div class="manufacturer__choice-item item-manufacturer">
                                                    <div class="item-manufacturer__title">Коментарий
                                                    </div>
                                                    <div class="item-manufacturer__textarea">
                                                        <textarea class="input" placeholder="Введите что-то..." data-autoheight data-autoheight-min="91" data-autoheight-max="300"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <button type="button" class="manufacturer__btn manufacturer__btn--two btn btn--blue">Оформить заказ</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="manufacturer__balance" data-watch data-watch-once data-da=".manufacturer__block, 992, 1">
                    <div class="manufacturer__balance-title">Баланс</div>
                    <div class="manufacturer__balance-items">
                        <dl class="manufacturer__balance-item">
                            <dt class="manufacturer__balance-category">Лимит</dt>
                            <dd class="manufacturer__balance-value">10 000 ₽</dd>
                        </dl>
                        <dl class="manufacturer__balance-item">
                            <dt class="manufacturer__balance-category">Остаток</dt>
                            <dd class="manufacturer__balance-value">10 000 ₽</dd>
                        </dl>
                        <dl class="manufacturer__balance-item">
                            <dt class="manufacturer__balance-category">Долг
                            </dt>
                            <dd class="manufacturer__balance-value">0 ₽</dd>
                        </dl>
                        <dl class="manufacturer__balance-item">
                            <dt class="manufacturer__balance-category">Отсрочка
                            </dt>
                            <dd class="manufacturer__balance-value">10 дней</dd>
                        </dl>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
