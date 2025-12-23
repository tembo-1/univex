<div id="callback-popupSix" wire:ignore.self aria-hidden="true" role="dialog" class="popup popup--three">
    <div class="popup__wrapper">
        <div class="popup__content">
            <div class="popup__inner">
                <button data-close type="button" class="popup__close" style='--icon:url(&quot;/img/icons/73.svg&quot;)'></button>
                <div class="popup__top">
                    <div class="popup__title">Регистрация</div>
                </div>
                <div data-tabs class="popup__tabs tabs">
                    <div data-tabs-body class="tabs__content">
                        <div class="tabs__body">
                            <div class="tabs__quest quest-block quest-block--alt">
                                <div class="quest-block__info">
                                    <h2 class="quest-block__title block-title">поиск
                                        <br>
                                        по ИНН
                                    </h2>
                                </div>
                                <div class="quest-block__content">
                                    <form  wire:submit.prevent="searchByInn" class="quest-block__form form">
                                        <div class="form__search">
                                            <div class="form__search-input">
                                                <input
                                                    wire:model="inn"
                                                    autocomplete="off" type="text" name="inn" data-error="Ошибка" placeholder="Введите ИНН для авто заполнения" class="input">
                                            </div>
                                            <button type="submit" class="form__search-icon" style='--icon:url(&quot;/img/icons/15.svg&quot;)'></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <form wire:submit.prevent="submit" class="tabs__form form"> <!-- Добавил wire:submit -->
                                <div class="form__blocks">
                                    <div class="form__block">
                                        <div class="form__block-title">Реквизиты организации</div>
                                        <div class="form__block-items">
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Полное наименование организации</label>
                                                    <input wire:model="name" autocomplete="off" type="text" data-error="Ошибка" placeholder="Введите полное наименование организации" class="input" data-validate>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Краткое наименование организации</label>
                                                    <input wire:model="shortName" autocomplete="off" type="text" data-error="Ошибка" placeholder="Введите краткое наименование организации" class="input" data-validate>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">ИНН</label>
                                                    <input wire:model="inn" autocomplete="off" type="text" data-error="Ошибка" placeholder="Введите ИНН" class="input" data-validate>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">КПП</label>
                                                    <input wire:model="kpp" autocomplete="off" type="text" data-error="Ошибка" placeholder="Введите КПП" class="input" data-validate>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">ОГРН</label>
                                                    <input wire:model="ogrn" autocomplete="off" type="text" data-error="Ошибка" placeholder="Введите ОГРН" class="input" data-validate>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Юридический адрес</label>
                                                    <input wire:model="legalAddress" autocomplete="off" type="text" data-error="Ошибка" placeholder="г. Москва...." class="input" data-validate>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Почтовый адрес</label>
                                                    <input wire:model="postalAddress" autocomplete="off" type="text" data-error="Ошибка" placeholder="г. Москва...." class="input" data-validate>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">ФИО руководителя</label>
                                                    <input wire:model="headName" autocomplete="off" type="text" data-error="Ошибка" placeholder="Иванов Иван Иванович" class="input" data-validate>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Должность руководителя</label>
                                                    <input wire:model="headPosition" autocomplete="off" type="text" data-error="Ошибка" placeholder="Главный инженер" class="input" data-validate>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__block">
                                        <div class="form__block-title">Банковские реквизиты</div>
                                        <div class="form__block-items">
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Банк</label>
                                                    <input wire:model="bankName" autocomplete="off" type="text" data-error="Ошибка" placeholder="Наименование банка" class="input" data-validate>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">БИК</label>
                                                    <input wire:model="bik" autocomplete="off" data-error="Ошибка" placeholder="БИК банка" class="input" data-validate>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Расчетный счет</label>
                                                    <input wire:model="paymentAccount" autocomplete="off" type="text" data-error="Ошибка" placeholder="Расчетный счет" class="input" data-validate>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Корреспондентский счет</label>
                                                    <input wire:model="correspondentAccount" autocomplete="off" type="text" data-error="Ошибка" placeholder="Корреспондентский счет" class="input" data-validate>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__block">
                                        <div class="form__block-title">Электронный документооборот</div>
                                        <div class="form__block-items">
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Оператор ЭДО</label>
                                                    <input wire:model="edoOperator" autocomplete="off" type="text" data-error="Ошибка" placeholder="Например: СБИС, Диадок" class="input" data-validate>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Идентификатор ЭДО</label>
                                                    <input wire:model="edoIdentifier" autocomplete="off" data-error="Ошибка" placeholder="Идентификатор в системе ЭДО" class="input" data-validate>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__block">
                                        <div class="form__block-title">Основная информация</div>
                                        <div class="form__block-items">
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Имя</label>
                                                    <input wire:model="firstName" autocomplete="off" type="text" data-error="Ошибка" placeholder="Введите ваше имя" class="input" data-validate data-required>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Отчество</label>
                                                    <input wire:model="middleName" autocomplete="off" type="text" data-error="Ошибка" placeholder="Введите ваше отчество" class="input" data-validate data-required>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Фамилия</label>
                                                    <input wire:model="lastName" autocomplete="off" type="text" data-error="Ошибка" placeholder="Введите вашу фамилию" class="input" data-validate data-required>
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">Телефон</label>
                                                    <input wire:model="phone" autocomplete="off" type="tel" data-error="Ошибка" placeholder="Введите ваш телефон" class="input" data-validate data-required="tel">
                                                </div>
                                            </div>
                                            <div class="form__block-item">
                                                <div class="form__block-input">
                                                    <label class="form__block-label">e-mail</label>
                                                    <input wire:model="email" autocomplete="off" type="text" data-error="Ошибка" placeholder="Введите ваше e-mail" class="input" data-validate data-required="email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form__block-bottom">
                                            <div class="form__block-checkbox checkbox">
                                                <input id="cddd_1" wire:model="privacyPolicy" data-error="Ошибка" class="checkbox__input" type="checkbox" value="1">
                                                <label for="cddd_1" class="checkbox__label">
                        <span class="checkbox__text">Я даю согласие на обработку своих персональных данных, на условиях определённых
                            <a href="javascript:void(0)">Политикой конфиденциальности</a>
                        </span>
                                                </label>
                                            </div>
                                            <button type="submit" class="form__block-btn btn btn--blue btn--icon" style='--icon:url(&quot;/img/icons/03.svg&quot;)'>Зарегистрироваться</button>
                                            @if($errors->any())
                                                <div class="form__error-message" style="width: 100%; color: #ff3b30; text-align: center; margin: 10px 0; padding: 10px; background: #ffeaea; border-radius: 5px;">
                                                    @foreach($errors->all() as $error)
                                                        <div>{{ $error }}</div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
