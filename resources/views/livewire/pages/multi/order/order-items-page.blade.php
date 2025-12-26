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
									<span>История заказов</span>
								</span>
            </li>
        </ul>
    </div>
    <section class="notebook  animate-block fade-up" data-watch data-watch-once>
        <div class='notebook__container'>
            <div class="notebook__top">
                <div class="notebook__info">
                    <a href="javascript:void(0)" class="notebook__back" style='--icon:url(&quot;/img/icons/back.svg&quot;)'></a>
                    <h2 class="notebook__title block-title">История заказА №3345</h2>
                </div>
                <div class="notebook__btns">
                    <a href="#" class="notebook__link btn btn--gry">Сохранить в Exel</a>
                    <button wire:click="downloadScore" class="notebook__link btn btn--blue">Счет на оплату</button>

                    @if($order->orderStatus->id == 1)
                        <a href="{{ route('orders.edit', $order->id) }}" class="notebook__link btn btn--icon" style='--icon:url(&quot;/img/icons/03.svg&quot;)'>Изменить заказ</a>
                    @endif
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
                        <div class="tracking-notebook__btn"   @if($order->orderStatus->id == 1) style='--bg: #6EC53F; --color: #FFFFFF' @else style='--bg: #FFF; --color: #5C5C5C' @endif>{{ $order->orderStatus->name }}
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
                            <div class="table-block__row table-block__row--seven">
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
                            </div>
                        </div>
                        @foreach($orderItems as $orderItem)
                            <div class="table-block__item table-block__item--color" style='--color: #ffffff'>
                                <div class="table-block__row table-block__row--seven">
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <a href="javascript:void(0)" class="table-block__text">{{ $orderItem->id }}</a>
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
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $orderItem->quantity }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $orderItem->totalAmountRub }}</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
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
                                    <textarea disabled class="input" placeholder="Введите что-то..." data-autoheight data-autoheight-min="125" data-autoheight-max="300">{{ $order->comment }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    </section>
</div>
