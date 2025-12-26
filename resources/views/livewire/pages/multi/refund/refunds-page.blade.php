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
									<span>Претензии и возвраты</span>
								</span>
            </li>
        </ul>
    </div>
    <section class="notebook  animate-block fade-up" data-watch data-watch-once>
        <div class='notebook__container'>
            <div class="notebook__top">
                <div class="notebook__info">
                    <a href="javascript:void(0)" class="notebook__back" style='--icon:url(&quot;/img/icons/back.svg&quot;)'></a>
                    <h2 class="notebook__title block-title">Претензии и Возвраты</h2>
                </div>
            </div>
            <div class="notebook__quest quest-block quest-block--alt">
                <div class="quest-block__info">
                    <h2 class="quest-block__title block-title">поиск артикулов
                        <br>
                        в возвратах
                    </h2>
                </div>
                <div class="quest-block__content">
                    <form action="#" class="quest-block__form form">
                        <div class="form__search">
                            <div class="form__search-input">
                                <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="По артикулу..." class="input">
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
                                        <input id="cddd_1" data-error="Ошибка" class="checkbox__input" type="radio" value="1" name="form[]">
                                        <label for="cddd_1" class="checkbox__label">
															<span class="checkbox__text">10
															</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form__column-item">
                                    <div class="form__column-checkbox checkbox">
                                        <input id="cddd_2" data-error="Ошибка" class="checkbox__input" type="radio" value="1" name="form[]">
                                        <label for="cddd_2" class="checkbox__label">
															<span class="checkbox__text">20
															</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form__column-item">
                                    <div class="form__column-checkbox checkbox">
                                        <input id="cddd_3" data-error="Ошибка" class="checkbox__input" type="radio" value="1" name="form[]">
                                        <label for="cddd_3" class="checkbox__label">
															<span class="checkbox__text">30
															</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form__column-item">
                                    <div class="form__column-checkbox checkbox">
                                        <input id="cddd_4" data-error="Ошибка" class="checkbox__input" type="radio" value="1" name="form[]">
                                        <label for="cddd_4" class="checkbox__label">
															<span class="checkbox__text">Показать все
															</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form__column" data-one-select>
                            <div class="form__column-title">Сортировать:</div>
                            <div class="form__column-items form__column-items--two">
                                <div class="form__column-item">
                                    <div class="form__column-select">
                                        <select name="form[]" class="form">
                                            <option value="1">За день</option>
                                            <option value="2">За неделю</option>
                                            <option value="3">За месяц</option>
                                            <option value="4">За 3 месяца</option>
                                            <option value="5">За 6 месяцев</option>
                                            <option value="6" selected>Причина</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form__column-item">
                                    <div class="form__column-select">
                                        <select name="form[]" class="form">
                                            <option value="1">За день</option>
                                            <option value="2">За неделю</option>
                                            <option value="3">За месяц</option>
                                            <option value="4">За 3 месяца</option>
                                            <option value="5">За 6 месяцев</option>
                                            <option value="6" selected>Статус</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form__column-item">
                                    <a href="{{ route('refunds.create') }}" class="form__column-link btn btn--blue btn--icon" style='--icon:url(&quot;/img/icons/03.svg&quot;)'>Создать зааявку на возврат</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="notebook__pagination pagination">
                    <a href="javascript:void(0)" class="pagination__arrow pagination__arrow--hidden" style='--icon:url(&quot;/img/icons/08.svg&quot;)'></a>
                    <ul class="pagination__list">
                        <li>
                            <a href="javascript:void(0)" class="pagination__item _active">1</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="pagination__item">2</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="pagination__item">3</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="pagination__item">...</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="pagination__item">10</a>
                        </li>
                    </ul>
                    <a href="javascript:void(0)" class="pagination__arrow" style='--icon:url(&quot;/img/icons/09.svg&quot;)'></a>
                </div>
            </div>
            <div class="notebook__table table-block">
                <div class="table-block__scroll">
                    <div class="table-block__items">
                        <div class="table-block__item table-block__item--head">
                            <div class="table-block__row table-block__row--three">
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Заявка</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Причины возврата</div>
                                    </div>
                                </div>
                                <div class="table-block__column ">
                                    <div class="table-block__info">
                                        <div class="table-block__category">СУММА, ₽</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Срок возврата</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Статус</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Распечатать</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach($refunds as $refund)
                            <div class="table-block__item table-block__item--color">
                                <div class="table-block__row table-block__row--three">
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <a href="{{ route('refunds.show', $refund->id) }}" class="table-block__text">№ {{ $refund->id }} от 22.09.2025</a>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">
                                                @foreach($refund->refundItems as $item)
                                                    {{ $item->refundType->name }}
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $refund->TotalAmount }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text"></div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $refund->refundStatus->name }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <a href="javascript:void(0)" class="table-block__btn" style='--icon:url(&quot;/img/icons/24.svg&quot;)'></a>
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
</div>
