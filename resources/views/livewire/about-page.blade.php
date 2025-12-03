<div>
    <div class="breadcrumb">
        <ul class="breadcrumb__list breadcrumb__container">
            <li class="breadcrumb__item" style='--icon:url("/img/icons/10.svg")'>
                <span>
                    <a href="{{ route('home') }}">
                        <span>Главная</span>
                    </a>
                </span>
            </li>
            <li class="breadcrumb__item breadcrumb__item--active">
                <span>
                    <span>О компании</span>
                </span>
            </li>
        </ul>
    </div>

    <!-- Секция "О компании" -->
    <section class="about animate-block fade-up" data-watch data-watch-once>
        <div class='about__container'>
            <h2 class="about__title block-title">О компании</h2>

            <div class="about__description">
                <div class="about__description-text">
                    {!! $about->description ?? 'Загрузка...' !!}
                </div>
            </div>

            <!-- Слайдер с фотографиями -->
            @if(isset($about->slider_images) && count($about->slider_images) > 0)
                <div class="about__slider swiper js-slider-about">
                    <div class="about__swiper swiper-wrapper">
                        @foreach($about->slider_images as $image)
                            <div class="about__slide swiper-slide">
                                <div class="about__slide-img">
                                    <picture>
                                        <img src="{{ $image['src'] }}"
                                             srcset="{{ $image['srcset'] ?? '' }}"
                                             alt="{{ $image['alt'] ?? 'Фото компании' }}">
                                    </picture>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if(count($about->slider_images) > 1)
                        <div class="about__arrows swiper-arrows">
                            <button type="button" class="about__arrow about__arrow--prev swiper-arrow swiper-arrow--prev"
                                    style='--icon:url("/img/icons/08.svg")'></button>
                            <button type="button" class="about__arrow about__arrow--next swiper-arrow swiper-arrow--next"
                                    style='--icon:url("/img/icons/09.svg")'></button>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Секция "Бренды" -->
    <section class="spares animate-block fade-up" data-watch data-watch-once>
        <div class='spares__container'>
            <div class="spares__top">
                <h2 class="spares__title spares__title--two block-title">
                    Наша компания является официальным дистрибьютором следующих брендов
                </h2>
            </div>

            @if(isset($about->brands) && count($about->brands) > 0)
                <div class="spares__row">
                    @foreach($about->brands as $brand)
                        <a href="{{ $brand['link'] ?? 'javascript:void(0)' }}" class="spares__column">
                            <div class="spares__column-img">
                                <picture>
                                    <img data-src="{{ $brand['src'] }}"
                                         data-srcset="{{ $brand['srcset'] ?? '' }}"
                                         src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                                         alt="{{ $brand['alt'] ?? 'Бренд' }}"
                                         loading="lazy">
                                </picture>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            <a href="{{ route('manufacturers') }}" class="spares__btn btn btn--showmore">
                Просмотреть весь каталог
            </a>
        </div>
    </section>

    <!-- Секция "Направления деятельности" -->
    <section class="direction animate-block fade-up" data-watch data-watch-once>
        <div class='direction__container'>
            <h2 class="direction__title block-title">
                Основные направления<br>деятельности компании
            </h2>

{{--            @if(isset($about->directions) && count($about->directions) > 0)--}}
{{--                <div class="direction__row">--}}
{{--                    @foreach($about->directions as $direction)--}}
{{--                        <a href="{{ $direction['link'] ?? 'javascript:void(0)' }}" class="direction__column">--}}
{{--                            <div class="direction__column-text">--}}
{{--                                {{ $direction['description'] ?? $direction['title'] ?? '' }}--}}
{{--                            </div>--}}
{{--                            <div class="direction__column-bottom">--}}
{{--                                <div class="direction__column-number"></div>--}}
{{--                                <div class="direction__column-arrow"--}}
{{--                                     style='--icon:url("/img/icons/71.svg")'></div>--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            @endif--}}
        </div>
    </section>

    <!-- Секция "Контакты и локация" -->
    <section class="location animate-block">
        <div class='location__container'>
            <div class="location__top fade-up" data-watch data-watch-once>
                <div class="location__top-content">
                    <h2 class="location__top-title">
                        {{ $about->address ?? 'Адрес не указан' }}
                    </h2>
                    <div class="location__top-info">
                        <a href="tel:{{ preg_replace('/[^0-9\+]/', '', $about->phone ?? '') }}"
                           class="location__top-phone">
                            {{ $about->phone ?? '' }}
                        </a>
                        <div class="location__top-socials">
                            <a href="javascript:void(0)" class="location__top-social"
                               style='--icon:url("/img/icons/012.svg")'></a>
                            <a href="javascript:void(0)" class="location__top-social"
                               style='--icon:url("/img/icons/02.svg")'></a>
                        </div>
                        <time datetime="2016-11-18T09:54" class="location__top-title">
                            {{ $about->work_hours ?? '' }}
                        </time>
                    </div>
                </div>

                <!-- Форма обратного звонка -->
                <button type="button"
                        class="location__top-btn btn btn--alt btn--icon"
                        style='--icon:url("/img/icons/03.svg")'
                        data-popup="#popup-callback">
                    Перезвоните нам
                </button>
            </div>

            <div class="location__inner">
                <div class="location__info fade-up" data-watch data-watch-once>
                    <!-- Слайдер локации -->
{{--                    @if(isset($about->location_images) && count($about->location_images) > 0)--}}
{{--                        <div class="location__slider swiper js-slider-location">--}}
{{--                            <div class="location__swiper swiper-wrapper">--}}
{{--                                @foreach($about->location_images as $image)--}}
{{--                                    <div class="location__slide swiper-slide">--}}
{{--                                        <div class="location__slide-img">--}}
{{--                                            <picture>--}}
{{--                                                <img src="{{ $image['src'] }}"--}}
{{--                                                     srcset="{{ $image['srcset'] ?? '' }}"--}}
{{--                                                     alt="{{ $image['alt'] ?? 'Локация' }}">--}}
{{--                                            </picture>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                            @if(count($about->location_images) > 1)--}}
{{--                                <div class="location__arrows swiper-arrows">--}}
{{--                                    <button type="button" class="location__arrow location__arrow--prev swiper-arrow swiper-arrow--prev"--}}
{{--                                            style='--icon:url("/img/icons/05.svg")'></button>--}}
{{--                                    <button type="button" class="location__arrow location__arrow--next swiper-arrow swiper-arrow--next"--}}
{{--                                            style='--icon:url("/img/icons/06.svg")'></button>--}}
{{--                                </div>--}}
{{--                                <div class="location__pagging swiper-pagging"></div>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    @endif--}}

                    <!-- Информация о парковке и как добраться -->
                    <div class="location__row">
{{--                        @if($about->parking_info ?? false)--}}
{{--                            <div class="location__column">--}}
{{--                                <div class="location__column-title">Парковка</div>--}}
{{--                                <div class="location__column-text">--}}
{{--                                    {{ $about->parking_info }}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                        @if($about->how_to_get ?? false)--}}
{{--                            <div class="location__column">--}}
{{--                                <div class="location__column-title">Как добраться</div>--}}
{{--                                <div class="location__column-text">--}}
{{--                                    {{ $about->how_to_get }}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}
                    </div>

                    <!-- Соцсети и кнопка -->
                    <div class="location__bottom">
{{--                        @if(isset($about->social_links) && count($about->social_links) > 0)--}}
{{--                            <div class="location__bottom-info">--}}
{{--                                <div class="location__bottom-title">Мы в соцсетях:</div>--}}
{{--                                <div class="location__bottom-items">--}}
{{--                                    @foreach($about->social_links as $social)--}}
{{--                                        <a href="{{ $social['link'] ?? 'javascript:void(0)' }}"--}}
{{--                                           class="location__bottom-item">--}}
{{--                                            <picture>--}}
{{--                                                <img src="{{ $social['icon'] }}"--}}
{{--                                                     srcset="{{ $social['srcset'] ?? '' }}"--}}
{{--                                                     alt="{{ $social['alt'] ?? 'Соцсеть' }}">--}}
{{--                                            </picture>--}}
{{--                                        </a>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                        @if($about->latitude && $about->longitude)--}}
{{--                            <a href="https://yandex.ru/maps/?pt={{ $about->longitude }},{{ $about->latitude }}&z=16&l=map"--}}
{{--                               target="_blank"--}}
{{--                               class="location__bottom-btn btn btn--icon btn--org"--}}
{{--                               style='--icon:url("/img/icons/03.svg")'>--}}
{{--                                Проложить маршрут--}}
{{--                            </a>--}}
{{--                        @endif--}}
                    </div>
                </div>

                <!-- Карта -->
                <div class="location__map map fade-up"
                     data-watch
                     data-watch-once
                     id="about-map"
                     data-lat="{{ $about->latitude ?? 55.779324 }}"
                     data-lng="{{ $about->longitude ?? 37.581623 }}"
                     data-address="{{ $about->address ?? '' }}">
                </div>
            </div>
        </div>
    </section>
</div>
