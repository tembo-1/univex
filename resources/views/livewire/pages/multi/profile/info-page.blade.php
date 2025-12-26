<div>
    <section class="cabinet  animate-block fade-up" data-watch data-watch-once>
        <div class='cabinet__container'>
            <div class="cabinet__inner">
                <aside class="cabinet__aside">
                    <div class="cabinet__info">
                        @livewire('components.blocks.user-menu')
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
                        <div class="cabinet__title">{{ $name ?: 'ООО “ИВАНОВ ИВАН ИВАНЫЧ”' }}</div>
                    </div>

                    <!-- ✅ ТОЛЬКО ДЛЯ ПРОСМОТРА - БЕЗ form и wire:model -->
                    <div class="cabinet__form form">
                        <div class="form__blocks">
                            <!-- Реквизиты организации -->
                            <div class="form__block">
                                <div class="form__block-title">Реквизиты организации</div>
                                <div class="form__block-items">
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Полное наименование организации</label>
                                            <input value="{{ $name }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Краткое наименование организации</label>
                                            <input value="{{ $shortName }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">ИНН</label>
                                            <input value="{{ $inn }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">КПП</label>
                                            <input value="{{ $kpp }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">ОГРН</label>
                                            <input value="{{ $ogrn }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Юридический адрес</label>
                                            <input value="{{ $legalAddress }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Почтовый адрес</label>
                                            <input value="{{ $postalAddress }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">ФИО руководителя</label>
                                            <input value="{{ $headName }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Должность руководителя</label>
                                            <input value="{{ $headPosition }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Банковские реквизиты -->
                            <div class="form__block">
                                <div class="form__block-title">Банковские реквизиты</div>
                                <div class="form__block-items">
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Банк</label>
                                            <input value="{{ $bankName }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">БИК</label>
                                            <input value="{{ $bik }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Расчетный счет</label>
                                            <input value="{{ $paymentAccount }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Корреспондентский счет</label>
                                            <input value="{{ $correspondentAccount }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ЭДО -->
                            <div class="form__block">
                                <div class="form__block-title">Электронный документооборот</div>
                                <div class="form__block-items">
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Оператор ЭДО</label>
                                            <input value="{{ $edoOperator }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Идентификатор ЭДО</label>
                                            <input value="{{ $edoIdentifier }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Основная информация -->
                            <div class="form__block">
                                <div class="form__block-title">Основная информация</div>
                                <div class="form__block-items">
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Имя</label>
                                            <input value="{{ $firstName }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Отчество</label>
                                            <input value="{{ $middleName }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Фамилия</label>
                                            <input value="{{ $lastName }}" type="text" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">Телефон</label>
                                            <input value="{{ $phone }}" type="tel" class="input" readonly>
                                        </div>
                                    </div>
                                    <div class="form__block-item">
                                        <div class="form__block-input">
                                            <label class="form__block-label">e-mail</label>
                                            <input value="{{ $email }}" type="email" class="input" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
