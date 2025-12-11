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

    <section class="cabinet  animate-block fade-up" data-watch data-watch-once>
        <div class='cabinet__container'>
            <div class="cabinet__inner">
                <aside class="cabinet__aside">
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
                            <a href="javascript:void(0)" class="cabinet__info-item _active" style='--icon:url(&quot;/img/icons/61.svg&quot;)'>
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
                <div class="cabinet__main cabinet__main--two">
                    <div class="cabinet__top">
                        <div class="cabinet__title">{{ $name }}</div>
                        <div class="cabinet__btns">
                            <button type="button" class="cabinet__btn cabinet__btn--new btn" style='--icon:url(&quot;/img/icons/69.svg&quot;)'>Внести измененеия</button>
                        </div>
                    </div>

                    <form action="#" class="cabinet__form form">
                        <div class="form__blocks">
                            <div class="form__block">
                                <div class="form__block-title">Реквизиты организации</div>
                                <div class="form__block-items">
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Полное наименование организации</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Введите имя наименоание организации" class="input" data-validate>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Краткое наименование организации</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Введите краткое наименование организации" class="input" data-validate>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">ИНН</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Введите ИНН" class="input" data-validate>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">КПП</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Введите КПП" class="input" data-validate>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">ОГРН</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Введите ваше ОКПО " class="input" data-validate>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Юридический адрес</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="г. Москва...." class="input" data-validate>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Почтовый адрес</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="г. Москва...." class="input" data-validate>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">ФИО руководителя</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Иванов Иван Иванович" class="input" data-validate>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Должность руководителя</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Главный инженер" class="input" data-validate>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form__block">
                                <div class="form__block-title">Банковские реквизиты</div>
                                <div class="form__block-items">
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Банк</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Введите ваше e-mail" class="input" data-validate data-required="email">
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">БИК</label>
                                            <input autocomplete="off" type="tel" name="form[]" data-error="Ошибка" placeholder="Введите ваш телефон" class="input" data-validate data-required="tel">
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Расчетный счет</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Введите ваше e-mail" class="input" data-validate data-required="email">
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Корреспондетский счет</label>
                                            <input autocomplete="off" type="tel" name="form[]" data-error="Ошибка" placeholder="Введите ваш телефон" class="input" data-validate data-required="tel">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form__block">
                                <div class="form__block-title">Электронный документооборот</div>
                                <div class="form__block-items">
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Оператор ЭДО</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Введите ваше e-mail" class="input" data-validate data-required="email">
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Идентификатор ЭДО</label>
                                            <input autocomplete="off" type="tel" name="form[]" data-error="Ошибка" placeholder="Введите ваш телефон" class="input" data-validate data-required="tel">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form__block">
                                <div class="form__block-title">Основная информация</div>
                                <div class="form__block-items">
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Имя</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Введите ваше имя" class="input" data-validate data-required>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Отчество</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Введите ваше  отчество" class="input" data-validate data-required>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Фамилия</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Введите вашу фамилию" class="input" data-validate data-required>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">Телефон
                                            </label>
                                            <input autocomplete="off" type="tel" name="form[]" data-error="Ошибка" placeholder="Введите ваш телефон" class="input" data-validate data-required="tel">
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label for="" class="form__block-label">e-mail</label>
                                            <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Введите ваше e-mail" class="input" data-validate data-required="email">
                                        </div>
                                    </div>

                                </div>
                                <button type="button" class="form__block-btn btn btn--blue btn--icon" style='--icon:url(&quot;/img/icons/03.svg&quot;)'>Cохранить изменения</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
    </section>
</div>
