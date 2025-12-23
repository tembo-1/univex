<div>
    <section class="about animate-block fade-up" data-watch data-watch-once>
        <div class='about__container'>
            <h2 class="about__title block-title">{{ $siteBlocks->firstWhere('slug', 'about-text-up')->name }}</h2>

            <div class="about__description">
                <div class="about__description-text">
                    {!! $siteBlocks->firstWhere('slug', 'about-text-up')->siteElements->first()->content !!}
                </div>
            </div>

            <div class="about__slider swiper js-slider-about">
                <div class="about__swiper swiper-wrapper">
                    @foreach($this->siteBlocks->firstWhere('slug', 'about-slider')->siteElements->first()->siteElementImages as $image )
                        <div class="about__slide swiper-slide">
                            <div class="about__slide-img">
                                <picture>
                                    <img src="{{ $image->imageUrl }}" srcset="{{ $image->imageUrl }} 2x" alt="">
                                </picture>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="about__arrows swiper-arrows">
                    <button type="button" class="about__arrow about__arrow--prev swiper-arrow swiper-arrow--prev" style='--icon:url(&quot;/img/icons/08.svg&quot;)'></button>
                    <button type="button" class="about__arrow about__arrow--next swiper-arrow swiper-arrow--next" style='--icon:url(&quot;/img/icons/09.svg&quot;)'></button>
                </div>
            </div>
        </div>
    </section>

    <section class="spares animate-block fade-up" data-watch data-watch-once>
        <div class='spares__container'>
            <div class="spares__top">
                <h2 class="spares__title spares__title--two block-title">
                    Наша компания является официальным дистрибьютором следующих брендов
                </h2>
            </div>

            <div class="spares__row fade-up" data-watch data-watch-once>
                @foreach($manufacturers as $manufacturer)
                    <a href="#" class="spares__column">
                        <div class="spares__column-img">
                            <picture>
                                <img data-src="{{ $manufacturer->imageUrl ?? asset('img/spares/01.webp') }}" data-srcset="{{ asset('img/spares/01@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                            </picture>
                        </div>
                    </a>
                @endforeach
            </div>
            <a href="{{ route('manufacturers') }}" class="spares__btn btn btn--showmore fade-up" data-watch data-watch-once>Просмотреть весь каталог</a>
        </div>
    </section>

    <section class="direction  animate-block fade-up" data-watch data-watch-once>
        <div class='direction__container'>
            <h2 class="direction__title block-title"> {{ $siteBlocks->firstWhere('slug', 'about-cards')->name }}
            </h2>
            <div class="direction__row">
                @foreach($siteBlocks->firstWhere('slug', 'about-cards')->siteElements as $siteElement )
                    <a href="javascript:void(0)" class="direction__column">
                        <div class="direction__column-text">{!! $siteElement->content !!}</div>
                        <div class="direction__column-bottom">
                            <div class="direction__column-number"></div>
                            <div class="direction__column-arrow" style='--icon:url(&quot;/img/icons/71.svg&quot;)'></div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

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
                            @foreach($siteBlocks->firstWhere('slug', 'about-slider-footer-banners')->siteElements->first()->siteElementImages as $image )
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
