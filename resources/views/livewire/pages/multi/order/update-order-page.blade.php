<div>
    <section class="notebook  animate-block" data-watch data-watch-once>
        <div class='notebook__container'>
            <div class="notebook__top">
                <div class="notebook__info">
                    <a href="javascript:void(0)" class="notebook__back" style='--icon:url(&quot;/img/icons/back.svg&quot;)'></a>
                    <h2 class="notebook__title block-title">История заказА №3345</h2>
                </div>
            </div>
            <div class="notebook__tracking tracking-notebook">
                <div class="tracking-notebook__items">
                    <div class="tracking-notebook__item">
                        <div class="tracking-notebook__title">ОБЩАЯ
                            <br>
                            СУММА ЗАКАЗА
                        </div>
                        <div class="tracking-notebook__price">{{ $order->totalAmount }} ₽
                        </div>
                    </div>
                    {{--                    <div class="tracking-notebook__item">--}}
                    {{--                        <div class="tracking-notebook__title">ОПЛАТА--}}
                    {{--                        </div>--}}
                    {{--                        <div class="tracking-notebook__btn" style='--bg: #6EC53F; --color: #FFFFFF'>{{ $order->is_paid }}--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="tracking-notebook__item">
                        <div class="tracking-notebook__title">СТАТУС
                        </div>
                        <div class="tracking-notebook__btn" style='--bg: #FFF; --color: #5C5C5C'>{{ $order->orderStatus->name }}
                        </div>
                    </div>
                    <div class="tracking-notebook__item">
                        <div class="tracking-notebook__title">СПОСОБ
                            <br>
                            ПОЛУЧЕНИЯ
                        </div>
                        <div class="tracking-notebook__btn" style='--bg: #FFF; --color: #5C5C5C'>{{ $order->shippingType->name }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="notebook__table table-block">
                <div class="table-block__scroll">
                    <div class="table-block__items">
                        <div class="table-block__item table-block__item--head">
                            <div class="table-block__row table-block__row--eight">
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">ID ТОВАРА</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">ПРОИЗВОДИТЕЛЬ</div>
                                    </div>
                                </div>
                                <div class="table-block__column ">
                                    <div class="table-block__info">
                                        <div class="table-block__category">АРТИКУЛ</div>
                                    </div>
                                </div>
                                <div class="table-block__column table-block__column--big">
                                    <div class="table-block__info">
                                        <div class="table-block__category">наименование</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">СкЛАД</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Цена, ₽</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Количество</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Стоимость, ₽</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">уДАЛИТЬ</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach($orderItems as $orderItem)
                            <div class="table-block__item table-block__item--color" style='--color: #fff'>
                                <div class="table-block__row table-block__row--eight">
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <a href="javascript:void(0)" class="table-block__text">{{ $orderItem->product_id }}</a>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $orderItem->product->manufacturer->name }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $orderItem->product_sku }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column table-block__column--big">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $orderItem->product_name }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $orderItem->warehouse->name }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $orderItem->unitPriceRub }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info" wire:key="quantity-{{ $orderItem->id }}-{{ $orderItem->quantity }}" >
                                            <div data-quantity class="table-block__quantity quantity">
                                                <button
                                                    wire:click="decrement({{$orderItem->id}})"
                                                    data-quantity-minus type="button" class="quantity__button quantity__button--minus"></button>
                                                <div class="quantity__input">
                                                    <input
                                                        wire:change="updateQuantityInput({{ $orderItem->id }}, $event.target.value)"
                                                        autocomplete="off"
                                                        type="number"
                                                        min="1"
                                                        name="quantity_{{ $orderItem->id }}"
                                                        value="{{ $orderItem->quantity }}"
                                                        class="quantity__input-field">
                                                </div>
                                                <button
                                                    wire:click="increment({{$orderItem->id}})"
                                                    data-quantity-plus type="button" class="quantity__button quantity__button--plus"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $orderItem->totalAmountRub }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <button
                                                wire:click="remove({{$orderItem->id}})"
                                                wire:confirm="Удалить товар из корзины?"
                                                class="table-block__btn" style='--icon:url(&quot;/img/icons/17.svg&quot;)'></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="notebook__quest notebook__quest--two quest-block quest-block--two">
                <div class="quest-block__info">
                    <h2 class="quest-block__title block-title">Добавить
                        <br>
                        ЕЩЕ ДЕТАЛЬ
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
                                    <input data-quantity-value autocomplete="off" type="number" name="form[]" value="180">
                                </div>
                                <button data-quantity-plus type="button" class="quantity__button quantity__button--plus"></button>
                            </div>
                            <a href="javascript:void(0)" class="form__basket" style='--icon:url(&quot;/img/icons/basket.svg&quot;)'></a>
                        </div>
                    </form>
                </div>
            </div>

            <form action="#" class="notebook__content">
                <div class="notebook__content-blocks"></div>
                <div class="notebook__content-blocks">
                    <div class="notebook__content-block block-notebook">
                        <div class="block-notebook__top">
                            <div class="block-notebook__title">Коментарий</div>
                        </div>
                        <div class="block-notebook__inner">
                            <div class="block-notebook__info">
                                <div class="block-notebook__textarea">
													<textarea class="input" placeholder="Введите что-то..." data-autoheight data-autoheight-min="125" data-autoheight-max="300">Домофон не работает. Этаж 24 лифт не работает.
										</textarea>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="block-notebook__btn btn btn--blue">Оформить заказ</button>
                    </div>
                </div>
            </form>
    </section>
</div>
