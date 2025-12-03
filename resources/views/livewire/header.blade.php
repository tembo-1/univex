<header class="header">
    <div class="header__container">
        <div class="header__menu menu">
            <div class="menu__inner">
                <div class="menu__info">
                    <button type="button" class="menu__icon" style='--icon:url("{{ asset('img/icons/29.svg') }}")'></button>
                    <a href="{{ route('home') }}" class="menu__logo">
                        <img src="{{ asset('img/menu/01.svg') }}" alt="Логотип">
                    </a>
                </div>
                <div class="menu__content">
                    <nav class="menu__body" data-da=".menu__scroll, 992, 0">
                        <div class="menu__select" style='--icon:url("{{ asset('img/icons/29.svg') }}")' data-da=".menu__list, 992, 1">
                            <select name="form[]" class="form">
                                <option data-href="{{ route('catalog') }}" value="1" selected>Каталог</option>
                                <option data-href="https://www.dns-shop.ru/" value="2">Каталог PDF</option>
                            </select>
                        </div>
                        <ul class="menu__list">
                            <li class="menu__item menu__item--hidden">
                                <a href="{{ route('home') }}" class="menu__link">Главная</a>
                            </li>
                            <li class="menu__item">
                                <a href="#" class="menu__link">Клиентам</a>
                            </li>
                            <li class="menu__item">
                                <a href="#" class="menu__link">Поставщикам</a>
                            </li>
                            <li class="menu__item">
                                <a href="{{ route('about') }}" class="menu__link">О компании</a>
                            </li>
                            <li class="menu__item">
                                <a href="#" class="menu__link">Контакты</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="menu__constructor">
                        <time datetime="2016-11-18T09:54" class="menu__constructor-item" style='--icon:url("{{ asset('img/icons/30.svg') }}")'>8:00–17:00 Пн–Пт</time>
                        <div class="menu__constructor-info">
                            <a href="tel:+74957397210" class="menu__constructor-item" style='--icon:url("{{ asset('img/icons/31.svg') }}")'>
                                <b>+7 495 739-72-10</b>
                            </a>
                            <a href="#" class="menu__constructor-link btn btn--blue btn--icon" style='--icon:url("{{ asset('img/icons/03.svg') }}")'>Заказать звонок</a>
                        </div>
                        <div class="menu__constructor-btns">
                            <a href="#" class="menu__constructor-btn js-open-search" style='--icon:url("{{ asset('img/icons/32.svg') }}")'></a>
                            <a href="#" class="menu__constructor-btn" style='--icon:url("{{ asset('img/icons/33.svg') }}")'></a>
                            <a href="#" class="menu__constructor-btn menu__constructor-btn--account" style='--icon:url("{{ asset('img/icons/34.svg') }}")'>
                                <span>Вход</span>
                            </a>
                        </div>
                    </div>
                    <form action="#" class="menu__form form">
                        <div class="form__search">
                            <div class="form__search-input">
                                <input autocomplete="off" type="text" name="search" data-error="Ошибка" placeholder="Артикул или наименование…" class="input">
                            </div>
                            <button type="submit" class="form__search-icon" style="--icon:url('{{ asset('img/icons/15.svg') }}')"></button>
                        </div>
                    </form>
                    <div class="menu__header">
                        <div class="menu__scroll">
                            <button type="button" class="menu__close" style='--icon:url("{{ asset('img/icons/38.svg') }}")'></button>

                            <div class="menu__mobile">
                                <address class="menu__mobile-address">Москва, район Троицк, Чароитовая улица, 5, стр. 49</address>
                                <div class="menu__mobile-info">
                                    <a href="tel:+74957397210" class="menu__mobile-phone">+7 495 739-72-10</a>
                                    <div class="menu__mobile-items">
                                        <a href="#" class="menu__mobile-item" style='--icon:url("{{ asset('img/icons/35.svg') }}")'></a>
                                        <a href="#" class="menu__mobile-item" style='--icon:url("{{ asset('img/icons/36.svg') }}")'></a>
                                        <a href="#" class="menu__mobile-item" style='--icon:url("{{ asset('img/icons/37.svg') }}")'></a>
                                    </div>
                                </div>
                                <a href="#" class="menu__mobile-btn btn btn--icon" style='--icon:url("{{ asset('img/icons/03.svg') }}")'>Перезвоните нам</a>
                                <div class="menu__mobile-block">
                                    <div class="menu__mobile-title">Мы в соцсетях:</div>
                                    <div class="menu__mobile-row">
                                        <a href="#" class="menu__mobile-column">
                                            <img src="{{ asset('img/menu/02.svg') }}" alt="">
                                        </a>
                                        <a href="#" class="menu__mobile-column">
                                            <img src="{{ asset('img/menu/03.svg') }}" alt="">
                                        </a>
                                        <a href="#" class="menu__mobile-column">
                                            <img src="{{ asset('img/menu/04.svg') }}" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
