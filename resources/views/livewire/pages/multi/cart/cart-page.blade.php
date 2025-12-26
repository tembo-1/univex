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
                                <form class="quest-block__form form" wire:submit.prevent="add()">
                                    <div class="form__search">
                                        <div class="form__search-input">
                                            <input wire:model="skuInput" autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Артикул..." class="input">
                                        </div>
                                        <button type="submit" class="form__search-icon" style='--icon:url(&quot;/img/icons/15.svg&quot;)'></button>
                                    </div>
                                    <div class="form__constructor">
                                        <div data-quantity class="form__quantity quantity">
                                            <button data-quantity-minus type="button" class="quantity__button quantity__button--minus"></button>
                                            <div class="quantity__input">
                                                <input wire:model="qtyInput" data-quantity-value autocomplete="off" type="number" name="form[]" value="1">
                                            </div>
                                            <button

                                                data-quantity-plus type="button" class="quantity__button quantity__button--plus"></button>
                                        </div>
                                        <button
                                            type="submit"
                                           class="form__basket"
                                           style='--icon:url(&quot;/img/icons/basket.svg&quot;)'></button>
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
                                                        <a href="javascript:void(0)" class="table-block__text">{{ $cartItem->warehouseProduct->product->sku }}</a>
                                                    </div>
                                                </div>
                                                <div class="table-block__column">
                                                    <div class="table-block__info">
                                                        <a href="javascript:void(0)" class="table-block__text">{{ $cartItem->warehouseProduct->product->manufacturer->name }}</a>
                                                    </div>
                                                </div>
                                                <div class="table-block__column table-block__column--big">
                                                    <div class="table-block__info">
                                                        <div class="table-block__text">{{ $cartItem->warehouseProduct->product->name }}</div>
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
                    </div>
                    <div wire:ignore.self>
                        <div class="manufacturer__block" data-watch data-watch-once>
                            <h3 class="manufacturer__subtitle">Доставка заказа</h3>
                            <form wire:submit.prevent="placeOrder" class="manufacturer__choice">
                                <!-- Тип доставки: самовывоз -->
                                <fieldset class="manufacturer__choice-block">
                                    <div class="manufacturer__choice-checkbox checkbox">
                                        <input wire:model="deliveryType"
                                               id="delivery_pickup"
                                               class="checkbox__input"
                                               type="radio"
                                               value="pickup"
                                               name="delivery_type">
                                        <label for="delivery_pickup" class="checkbox__label">
                                            <span class="checkbox__text">Самовывоз со склада</span>
                                        </label>
                                    </div>

                                    <div class="manufacturer__choice-hidden" @if($deliveryType !== 'pickup') hidden @endif>
                                        <div class="manufacturer__choice-inner">
                                            <div class="manufacturer__choice-row">
                                                @foreach($deliveryAddresses as $deliveryAddress)
                                                    <div class="manufacturer__choice-column">
                                                        <div class="manufacturer__choice-checkbox checkbox">
                                                            <input wire:model="address"
                                                                   id="address_{{ $deliveryAddress->id }}"
                                                                   class="checkbox__input"
                                                                   type="radio"
                                                                   value="{{ $deliveryAddress->address }}"
                                                                   name="selected_address_id">
                                                            <label for="address_{{ $deliveryAddress->id }}" class="checkbox__label"></label>
                                                        </div>
                                                        <div class="manufacturer__choice-info">
                                                            <address class="manufacturer__choice-address">
                                                                {{ $deliveryAddress->address }}
                                                            </address>
                                                            <div class="manufacturer__choice-take">
                                                                Забирайте 28 июня, после 11:00
                                                            </div>
                                                            <time datetime="2016-11-18T09:54" class="manufacturer__choice-time">
                                                                {{ $deliveryAddress->working_hours }}
                                                            </time>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Тип доставки: доставка -->
                                <fieldset class="manufacturer__choice-block">
                                    <div class="manufacturer__choice-checkbox checkbox">
                                        <input wire:model="deliveryType"
                                               id="delivery_home"
                                               class="checkbox__input"
                                               type="radio"
                                               value="delivery"
                                               name="delivery_type">
                                        <label for="delivery_home" class="checkbox__label">
                                            <span class="checkbox__text">Доставка</span>
                                        </label>
                                    </div>

                                    <div class="manufacturer__choice-hidden" @if($deliveryType !== 'delivery') hidden @endif>
                                        <div class="manufacturer__choice-inner">
                                            <div class="manufacturer__choice-items">
                                                <div class="manufacturer__choice-item item-manufacturer">
                                                    <div class="item-manufacturer__title">Адрес доставки</div>
                                                    <div class="item-manufacturer__textarea">
                            <textarea wire:model="address"
                                      class="input"
                                      placeholder="Введите адрес доставки..."
                                      data-autoheight
                                      data-autoheight-min="91"
                                      data-autoheight-max="300"></textarea>
                                                    </div>
                                                </div>
                                                <div class="manufacturer__choice-item item-manufacturer">
                                                    <div class="item-manufacturer__title">Комментарий</div>
                                                    <div class="item-manufacturer__textarea">
                            <textarea wire:model="comment"
                                      class="input"
                                      placeholder="Введите комментарий..."
                                      data-autoheight
                                      data-autoheight-min="91"
                                      data-autoheight-max="300"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                @if($hasMore)
                                    <button type="submit"
                                            class="manufacturer__btn manufacturer__btn--two btn btn--blue">
                                        Оформить заказ
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                @livewire('components.blocks.balance')
            </div>

        </div>
    </section>
</div>
