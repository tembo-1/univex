<div>
    <section class="intro animate-block">
        <div class='intro__container'>
            <div class="intro__content">
                <div class="intro__inner">
                    <div class="intro__info fade-up" data-watch data-watch-once>
                        <h2 class="intro__title">
                            Ваш склад запчастей
                            <span>для европейских грузовиков</span>
                        </h2>
                        <a href="#" class="intro__btn btn btn--icon btn--org" style='--icon:url("{{ asset('img/icons/03.svg') }}")'>заказать звонок</a>
                    </div>
                    <div class="intro__items fade-up" data-watch data-watch-once>
                        <div class="intro__item" style='--icon:url("{{ asset('img/icons/14.svg') }}")'>
                            <div class="intro__item-text">
                                Склад в Москве. Быстрая доставка по всей России
                            </div>
                        </div>
                    </div>
                </div>
                <div class="intro__img">
                    <picture>
                        <source media="(max-width: 992px)" srcset="{{ asset('img/intro/01-m.webp') }}, {{ asset('img/intro/01-m@2x.webp') }} 2x">
                        <img src="{{ asset('img/intro/01.webp') }}" srcset="{{ asset('img/intro/01@2x.webp') }} 2x" alt="">
                    </picture>
                </div>
            </div>
        </div>
    </section>

    <section class="quest animate-block">
        <div class='quest__container'>
            <div class="quest__inner quest-block">
                <div class="quest-block__info fade-up" data-watch data-watch-once>
                    <h2 class="quest-block__title block-title">Быстрый поиск<br>по артикулу</h2>
                </div>
                <div class="quest-block__content fade-up" data-watch data-watch-once>
                    <form action="#" class="quest-block__form form">
                        <div class="form__search">
                            <div class="form__search-input">
                                <input autocomplete="off" type="text" name="search" data-error="Ошибка" placeholder="Артикул или наименование…" class="input">
                            </div>
                            <button type="submit" class="form__search-icon" style='--icon:url("{{ asset('img/icons/15.svg') }}")'></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="partner animate-block fade-up" data-watch data-watch-once>
        <div class='partner__container'>
            <div class="partner__slider swiper js-slider-partner">
                <div class="partner__swiper swiper-wrapper">
                    <a href="#" class="partner__slide swiper-slide">
                        <div class="partner__slide-img">
                            <picture>
                                <source media="(max-width: 621px)" data-src="{{ asset('img/partner/01-s.webp') }}" data-srcset="{{ asset('img/partner/01-s@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                                <img data-src="{{ asset('img/partner/01.webp') }}" data-srcset="{{ asset('img/partner/01@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                            </picture>
                        </div>
                    </a>
                    <a href="#" class="partner__slide swiper-slide">
                        <div class="partner__slide-img">
                            <picture>
                                <img data-src="{{ asset('img/partner/02.webp') }}" data-srcset="{{ asset('img/partner/02@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                            </picture>
                        </div>
                    </a>
                </div>
                <div class="partner__arrows swiper-arrows">
                    <button type="button" class="partner__arrow partner__arrow--prev swiper-arrow swiper-arrow--prev" style='--icon:url("{{ asset('img/icons/08.svg') }}")'></button>
                    <button type="button" class="partner__arrow partner__arrow--next swiper-arrow swiper-arrow--next" style='--icon:url("{{ asset('img/icons/09.svg') }}")'></button>
                </div>
                <div class="partner__pagging swiper-pagging"></div>
            </div>
        </div>
    </section>

    <section class="admission animate-block">
        <div class='admission__container'>
            <div class="admission__top fade-up" data-watch data-watch-once>
                <h2 class="admission__title block-title">Новые<br>поступления</h2>
                <a href="#" class="admission__link btn btn--blue btn--icon" style='--icon:url("/img/icons/07.svg")'>Подпишитесь</a>
            </div>
            <div class="admission__row fade-up" data-watch data-watch-once>
                @foreach($posts as $item)
                    <a href="posts/{{ $item->slug }}" class="admission__column card-product">
                        <div class="card-product__img">
                            <picture>
                                <img data-src="{{ $item->imageUrl }}"
                                     data-srcset="{{ $item->imageUrl }} 2x"
                                     src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                                     alt="{{ $item->title }}">
                            </picture>
                        </div>
                        <div class="card-product__info">
                            <time datetime="{{ $item->published_at }}" class="card-product__time">
                                {{ $item->published_at }}
                            </time>
                            <div class="card-product__title">{{ $item->title }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
            <a href="{{ route('posts') }}" class="admission__showmore btn btn--showmore fade-up" data-watch data-watch-once>
                Просмотреть все новинки
            </a>
        </div>
    </section>

    <section class="spares animate-block">
        <div class='spares__container'>
            <div class="spares__top fade-up" data-watch data-watch-once>
                <h2 class="spares__title block-title">Каталог<br>запчастей</h2>
                <div class="spares__value">10 000 +</div>
            </div>
            <div class="spares__row fade-up" data-watch data-watch-once>
                <a href="#" class="spares__column">
                    <div class="spares__column-img">
                        <picture>
                            <img data-src="{{ asset('img/spares/01.webp') }}" data-srcset="{{ asset('img/spares/01@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                        </picture>
                    </div>
                </a>
                <a href="#" class="spares__column">
                    <div class="spares__column-img">
                        <picture>
                            <img data-src="{{ asset('img/spares/02.webp') }}" data-srcset="{{ asset('img/spares/02@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                        </picture>
                    </div>
                </a>
                <a href="#" class="spares__column">
                    <div class="spares__column-img">
                        <picture>
                            <img data-src="{{ asset('img/spares/03.webp') }}" data-srcset="{{ asset('img/spares/03@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                        </picture>
                    </div>
                </a>
                <a href="#" class="spares__column">
                    <div class="spares__column-img">
                        <picture>
                            <img data-src="{{ asset('img/spares/04.webp') }}" data-srcset="{{ asset('img/spares/04@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                        </picture>
                    </div>
                </a>
                <a href="#" class="spares__column">
                    <div class="spares__column-img">
                        <picture>
                            <img data-src="{{ asset('img/spares/05.webp') }}" data-srcset="{{ asset('img/spares/05@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                        </picture>
                    </div>
                </a>
                <a href="#" class="spares__column">
                    <div class="spares__column-img">
                        <picture>
                            <img data-src="{{ asset('img/spares/06.webp') }}" data-srcset="{{ asset('img/spares/06@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                        </picture>
                    </div>
                </a>
                <a href="#" class="spares__column">
                    <div class="spares__column-img">
                        <picture>
                            <img data-src="{{ asset('img/spares/07.webp') }}" data-srcset="{{ asset('img/spares/07@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                        </picture>
                    </div>
                </a>
                <a href="#" class="spares__column">
                    <div class="spares__column-img">
                        <picture>
                            <img data-src="{{ asset('img/spares/08.webp') }}" data-srcset="{{ asset('img/spares/08@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                        </picture>
                    </div>
                </a>
                <a href="#" class="spares__column">
                    <div class="spares__column-img">
                        <picture>
                            <img data-src="{{ asset('img/spares/09.webp') }}" data-srcset="{{ asset('img/spares/09@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                        </picture>
                    </div>
                </a>
                <a href="#" class="spares__column">
                    <div class="spares__column-img">
                        <picture>
                            <img data-src="{{ asset('img/spares/10.webp') }}" data-srcset="{{ asset('img/spares/10@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                        </picture>
                    </div>
                </a>
                <a href="#" class="spares__column">
                    <div class="spares__column-img">
                        <picture>
                            <img data-src="{{ asset('img/spares/11.webp') }}" data-srcset="{{ asset('img/spares/11@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                        </picture>
                    </div>
                </a>
                <a href="#" class="spares__column">
                    <div class="spares__column-img">
                        <picture>
                            <img data-src="{{ asset('img/spares/12.webp') }}" data-srcset="{{ asset('img/spares/12@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                        </picture>
                    </div>
                </a>
            </div>
            <a href="{{ route('manufacturers') }}" class="spares__btn btn btn--showmore fade-up" data-watch data-watch-once>Просмотреть весь каталог</a>
        </div>
    </section>

    <section class="location animate-block">
        <div class='location__container'>
            <div class="location__top fade-up" data-watch data-watch-once>
                <div class="location__top-content">
                    <h2 class="location__top-title">Москва, район Троицк,<br>Чароитовая улица, 5, стр. 49</h2>
                    <div class="location__top-info">
                        <a href="tel:+74957397210" class="location__top-phone">+7 495 739-72-10</a>
                        <div class="location__top-socials">
                            <a href="#" class="location__top-social" style='--icon:url("{{ asset('img/icons/012.svg') }}")'></a>
                            <a href="#" class="location__top-social" style='--icon:url("{{ asset('img/icons/02.svg') }}")'></a>
                        </div>
                        <time datetime="2016-11-18T09:54" class="location__top-title">Пн–Пт 8:00 до 17:00</time>
                    </div>
                </div>
                <a href="#" class="location__top-btn btn btn--alt btn--icon" style='--icon:url("{{ asset('img/icons/03.svg') }}")'>Перезвоните нам</a>
            </div>
            <div class="location__inner">
                <div class="location__info fade-up" data-watch data-watch-once>
                    <div class="location__slider swiper js-slider-location">
                        <div class="location__swiper swiper-wrapper">
                            <div class="location__slide swiper-slide">
                                <div class="location__slide-img">
                                    <picture>
                                        <img src="{{ asset('img/location/01.webp') }}" srcset="{{ asset('img/location/01@2x.webp') }} 2x" alt="">
                                    </picture>
                                </div>
                            </div>
                            <div class="location__slide swiper-slide">
                                <div class="location__slide-img">
                                    <picture>
                                        <img src="{{ asset('img/location/01.webp') }}" srcset="{{ asset('img/location/01@2x.webp') }} 2x" alt="">
                                    </picture>
                                </div>
                            </div>
                        </div>
                        <div class="location__arrows swiper-arrows">
                            <button type="button" class="location__arrow location__arrow--prev swiper-arrow swiper-arrow--prev" style='--icon:url("{{ asset('img/icons/05.svg') }}")'></button>
                            <button type="button" class="location__arrow location__arrow--next swiper-arrow swiper-arrow--next" style='--icon:url("{{ asset('img/icons/06.svg') }}")'></button>
                        </div>
                        <div class="location__pagging swiper-pagging"></div>
                    </div>
                    <div class="location__row">
                        <div class="location__column">
                            <div class="location__column-title">Парковка</div>
                            <div class="location__column-text">Парковка: пн–вс, кроме праздников, с 8:00 до 21:00 ч — 450 ₽/ч;<br>с 21:00 до 8:00 ч — 200 ₽/ч</div>
                        </div>
                        <div class="location__column">
                            <div class="location__column-title">Как добраться</div>
                            <div class="location__column-text">Двигаясь по внутренней стороне Садового кольца свернуть направо на улицу Спиридоновка.</div>
                        </div>
                    </div>
                    <div class="location__bottom">
                        <div class="location__bottom-info">
                            <div class="location__bottom-title">Мы в соцсетях:</div>
                            <div class="location__bottom-items">
                                <a href="#" class="location__bottom-item">
                                    <picture>
                                        <img src="{{ asset('img/footer/01.webp') }}" srcset="{{ asset('img/footer/01@2x.webp') }} 2x" alt="">
                                    </picture>
                                </a>
                                <a href="#" class="location__bottom-item">
                                    <picture>
                                        <img src="{{ asset('img/footer/02.webp') }}" srcset="{{ asset('img/footer/02@2x.webp') }} 2x" alt="">
                                    </picture>
                                </a>
                                <a href="#" class="location__bottom-item">
                                    <picture>
                                        <img src="{{ asset('img/footer/03.webp') }}" srcset="{{ asset('img/footer/03@2x.webp') }} 2x" alt="">
                                    </picture>
                                </a>
                            </div>
                        </div>
                        <a href="#" class="location__bottom-btn btn btn--icon btn--org" style='--icon:url("{{ asset('img/icons/03.svg') }}")'>Проложить маршрут</a>
                    </div>
                </div>
                <div class="location__map map fade-up" data-watch data-watch-once id="map" data-key="Ваш API ключ" data-center="[55.779324, 37.581623]" data-icon="Ссылка на иконку"></div>
            </div>
        </div>
    </section>
</div>
