<div>
    <section class="intro animate-block">
        <div class='intro__container'>
            <div class="intro__content">
                <div class="intro__inner">
                    <div class="intro__info fade-up" data-watch data-watch-once>
                        @if($introHeading = $blocks->firstWhere('slug', 'intro')?->siteElements->firstWhere('slug', 'rules-up'))
                            <h2 class="intro__title">
                                {!! $introHeading->content !!}
                            </h2>
                        @endif
                        <a href="{{ route('popup.callback') }}" data-popup="#callback-popupTwo" class="intro__btn btn btn--icon btn--org" style='--icon:url("{{ asset('img/icons/03.svg') }}")'>заказать звонок</a>
                    </div>
                    <div class="intro__items fade-up" data-watch data-watch-once>
                        <div class="intro__item" style='--icon:url("{{ asset('img/icons/14.svg') }}")'>
                            @if($introHeading = $blocks->firstWhere('slug', 'intro')?->siteElements->firstWhere('slug', 'rules-down'))
                                <div class="intro__item-text">
                                    {!! $introHeading->content !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="intro__img">
                    <picture>
                        @if($introHeading = $blocks->firstWhere('slug', 'intro')?->siteElements->firstWhere('slug', 'intro-banner'))
                            <source media="(max-width: 992px)" srcset="{{ asset('img/intro/01-m.webp') }}, {{ asset('img/intro/01-m@2x.webp') }} 2x">
                            <img src="{{ $introHeading->imageUrl }}" srcset="{{ $introHeading->imageUrl }} 2x" alt="">
                        @endif
{{--                        <source media="(max-width: 992px)" srcset="{{ asset('img/intro/01-m.webp') }}, {{ asset('img/intro/01-m@2x.webp') }} 2x">--}}
{{--                        <img src="{{ asset('img/intro/01.webp') }}" srcset="{{ asset('img/intro/01@2x.webp') }} 2x" alt="">--}}
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
                    <form action="{{ route('catalog') }}" class="quest-block__form form">
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

                    @foreach($this->blocks->firstWhere('slug', 'slider-banners')->siteElements->first()->siteElementImages as $image )
                        <a href="{{ $image->href }}" class="partner__slide swiper-slide">
                            <div class="partner__slide-img">
                                <picture>
                                    <source media="(max-width: 621px)" data-src="{{ $image->imageUrl }}" data-srcset="{{ $image->imageUrl }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="{{ $image->alt }}">
                                    <img data-src="{{ $image->imageUrl }}" data-srcset="{{ $image->imageUrl }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="{{ $image->alt }}">
                                </picture>
                            </div>
                        </a>
                    @endforeach
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
                <a href="{{ setting('site_telegram') }}" class="admission__link btn btn--blue btn--icon" style='--icon:url("/img/icons/07.svg")'>Подпишитесь</a>
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
                            <time datetime="{{ $item->starts_at ?? $item->created_at }}" class="card-product__time">
                                {{ $item->starts_at ?? $item->created_at }}
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

    @livewire('components.blocks.manufacturers')

    <section class="location animate-block">
        <div class='location__container'>
            <div class="location__top fade-up" data-watch data-watch-once>
                <div class="location__top-content">
                    <h2 class="location__top-title">{{ setting('site_address') }}</h2>
                    <div class="location__top-info">
                        <a href="tel:+74957397210" class="location__top-phone">{{ setting('site_phone') }}</a>
                        <div class="location__top-socials">
                            <a href="#" class="location__top-social" style='--icon:url("{{ asset('img/icons/012.svg') }}")'></a>
                            <a href="#" class="location__top-social" style='--icon:url("{{ asset('img/icons/02.svg') }}")'></a>
                        </div>
                        <time datetime="2016-11-18T09:54" class="location__top-title">{{ setting('site_working_hours') }}</time>
                    </div>
                </div>
                <a href="{{ route('popup.callback') }}" data-popup="#callback-popupTwo" class="location__top-btn btn btn--alt btn--icon" style='--icon:url("{{ asset('img/icons/03.svg') }}")'>Перезвоните нам</a>
            </div>
            <div class="location__inner">
                <div class="location__info fade-up" data-watch data-watch-once>
                    <div class="location__slider swiper js-slider-location">
                        <div class="location__swiper swiper-wrapper">
                            @foreach($this->blocks->firstWhere('slug', 'slider-footer-banners')->siteElements->first()->siteElementImages as $image )
                                <div class="location__slide swiper-slide">
                                    <div class="location__slide-img">
                                        <picture>
                                            <img src="{{ $image->imageUrl }}" srcset="{{ $image->imageUrl }} 2x" alt="">
                                        </picture>
                                    </div>
                                </div>
                            @endforeach
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
                            <div class="location__column-text">{{ setting('site_parking') }}</div>
                        </div>
                        <div class="location__column">
                            <div class="location__column-title">Как добраться</div>
                            <div class="location__column-text">{{ setting('site_how_to_get') }}</div>
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
