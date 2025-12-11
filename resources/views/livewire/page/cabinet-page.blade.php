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
									<span>Личный кабаинет</span>
								</span>
            </li>
        </ul>
    </div>

    <section class="cabinet  animate-block">
        <div class='cabinet__container'>
            <div class="cabinet__inner">
                <aside class="cabinet__aside fade-up" data-watch data-watch-once>
                    <div class="cabinet__info">
                        <div class="cabinet__info-items">
                            <a href="javascript:void(0)" class="cabinet__info-item" style='--icon:url(&quot;/img/icons/61.svg&quot;)'>
                                <div class="cabinet__info-name" style='--icon:url(&quot;/img/icons/60.svg&quot;)'>Заказы</div>
                            </a>
                            <a href="javascript:void(0)" class="cabinet__info-item" style='--icon:url(&quot;/img/icons/61.svg&quot;)'>
                                <div class="cabinet__info-name" style='--icon:url(&quot;/img/icons/62.svg&quot;)'>Взаиморасчеты</div>
                            </a>
                            <a href="javascript:void(0)" class="cabinet__info-item" style='--icon:url(&quot;/img/icons/61.svg&quot;)'>
                                <div class="cabinet__info-name" style='--icon:url(&quot;/img/icons/63.svg&quot;)'>Возвраты</div>
                            </a>
                            <a href="javascript:void(0)" class="cabinet__info-item" style='--icon:url(&quot;/img/icons/61.svg&quot;)'>
                                <div class="cabinet__info-name" style='--icon:url(&quot;/img/icons/64.svg&quot;)'>Блокнот</div>
                            </a>
                            <a href="{{ route('profile') }}" class="cabinet__info-item" style='--icon:url(&quot;/img/icons/61.svg&quot;)'>
                                <div class="cabinet__info-name" style='--icon:url(&quot;/img/icons/65.svg&quot;)'>Профиль</div>
                            </a>
                        </div>
                        <div class="cabinet__manager manager-cabinet">
                            <div class="manager-cabinet__title">Ваш МЕНЕДЖЕР</div>
                            <div class="manager-cabinet__name">{{ $manager->fullName }}</div>
                            <div class="manager-cabinet__items">
                                <a href="javascript:void(0)" class="manager-cabinet__item" style='--icon:url(&quot;/img/icons/11.svg&quot;)'>
                                    <b>{{ $manager->internal_phone }}</b>
                                </a>
                                <a href="javascript:void(0)" class="manager-cabinet__item" style='--icon:url(&quot;/img/icons/12.svg&quot;)'>{{ $manager->user->email }}</a>
                            </div>
                            <div class="manager-cabinet__items">
                                <time datetime="2016-11-18T09:54" class="manager-cabinet__item" style='--icon:url(&quot;/img/icons/13.svg&quot;)'>{{ $manager->work_schedule }}</time>
                            </div>
                        </div>
                    </div>
                </aside>
                <div class="cabinet__main">
                    <div class="cabinet__block fade-up" data-watch data-watch-once>
                        <div class="cabinet__top">
                            <div class="cabinet__title">{{ $name }}</div>
                        </div>
                        <div class="cabinet__content">
                            <div class="cabinet__agreement agreement-cabinet">
                                <div class="agreement-cabinet__row">
                                    <div class="agreement-cabinet__column">
                                        <div class="agreement-cabinet__title">
                                            ID клиента</div>
                                        <div class="agreement-cabinet__value">
                                            <b>{{ $id }}</b>
                                        </div>
                                    </div>
                                    <div class="agreement-cabinet__column">
                                        <div class="agreement-cabinet__title">
                                            ИНН/КПП</div>
                                        <div class="agreement-cabinet__value">
                                            <b>{{ $inn }}</b>
                                        </div>
                                    </div>
                                    <div class="agreement-cabinet__column">
                                        <div class="agreement-cabinet__title">
                                            № Договора</div>
                                        <div class="agreement-cabinet__value">
                                            <b>Договор № 12324</b>
                                            <span>от 25 сентября 2025 г
															</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="agreement-cabinet__bottom">
                                    <div class="agreement-cabinet__items">
                                        <a href="javascript:void(0)" class="agreement-cabinet__item" style='--icon:url(&quot;/img/icons/11.svg&quot;)'>{{ $phone }}</a>
                                        <a href="javascript:void(0)" class="agreement-cabinet__item" style='--icon:url(&quot;/img/icons/12.svg&quot;)'>{{ $email }}</a>
                                    </div>
                                    <a href="javascript:void(0)" class="agreement-cabinet__link btn btn--blue btn--icon" style='--icon:url(&quot;/img/icons/03.svg&quot;)'>Больше информации</a>
                                </div>
                            </div>
                            <div class="cabinet__balance">
                                <div class="cabinet__balance-title">Баланс</div>
                                <div class="cabinet__balance-items">
                                    <dl class="cabinet__balance-item">
                                        <dt class="cabinet__balance-category">Лимит</dt>
                                        <dd class="cabinet__balance-value">10 000 ₽</dd>
                                    </dl>
                                    <dl class="cabinet__balance-item">
                                        <dt class="cabinet__balance-category">Остаток</dt>
                                        <dd class="cabinet__balance-value">10 000 ₽</dd>
                                    </dl>
                                    <dl class="cabinet__balance-item">
                                        <dt class="cabinet__balance-category">Долг
                                        </dt>
                                        <dd class="cabinet__balance-value">0 ₽</dd>
                                    </dl>
                                    <dl class="cabinet__balance-item">
                                        <dt class="cabinet__balance-category">Отсрочка
                                        </dt>
                                        <dd class="cabinet__balance-value">10 дней
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cabinet__block fade-up" data-watch data-watch-once>
                        <div class="cabinet__top">
                            <div class="cabinet__subtitle">Уведомления</div>
                        </div>
                        <div class="cabinet__cards">
                            <a href="javascript:void(0)" class="cabinet__card">
                                <div class="cabinet__card-top">
                                    <time datetime="2016-11-18T09:54" class="cabinet__card-time">22.06.2025</time>
                                    <div class="cabinet__card-title">Отсрочка подходит к концу</div>
                                </div>
                                <div class="cabinet__card-btn" style='--icon:url(&quot;/img/icons/46.svg&quot;)'></div>
                            </a>
                            <a href="javascript:void(0)" class="cabinet__card">
                                <div class="cabinet__card-top">
                                    <time datetime="2016-11-18T09:54" class="cabinet__card-time">22.06.2025</time>
                                    <div class="cabinet__card-title">Отсрочка подходит к концу</div>
                                </div>
                                <div class="cabinet__card-btn" style='--icon:url(&quot;/img/icons/46.svg&quot;)'></div>
                            </a>
                            <a href="javascript:void(0)" class="cabinet__card">
                                <div class="cabinet__card-top">
                                    <time datetime="2016-11-18T09:54" class="cabinet__card-time">22.06.2025</time>
                                    <div class="cabinet__card-title">Отсрочка подходит к концу</div>
                                </div>
                                <div class="cabinet__card-btn" style='--icon:url(&quot;/img/icons/46.svg&quot;)'></div>
                            </a>
                        </div>

                        <a href="javascript:void(0)" class="cabinet__showmore btn btn--showmore">загрузить еще уведомления</a>

                    </div>
                </div>
            </div>
        </div>
    </section></div>
