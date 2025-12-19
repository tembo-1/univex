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
									<span>Контаткты</span>
								</span>
            </li>
        </ul>
    </div>
    <section class="cooperation  animate-block">
        <div class='cooperation__container'>
            <div class="cooperation__top fade-up" data-watch data-watch-once>
                <h2 class="cooperation__title block-title">Контакты</h2>
                <div class="cooperation__text">Условия сотрудничества вы можете обсудить с сотрудниками компании
                </div>
            </div>
            <div class="cooperation__row fade-up" data-watch data-watch-once>
                @foreach($contactGroups as $contactGroup)
                    <div class="cooperation__column">
                        <h3 class="cooperation__column-title">{{ $contactGroup->name }}</h3>
                        <div class="cooperation__column-items">
                            @foreach($contactGroup->contacts as $contact)
                                <div class="cooperation__column-item">
                                    <div class="cooperation__column-name">{{ $contact->name }}</div>
                                    <div class="cooperation__column-blocks">
                                        <a href="javascript:void(0)" class="cooperation__column-block" style='--icon:url(&quot;/img/icons/11.svg&quot;)'>
                                            <b>{{ $contact->phone }}</b>
                                        </a>
                                        <a href="javascript:void(0)" class="cooperation__column-block" style='--icon:url(&quot;/img/icons/12.svg&quot;)'>
                                            {{ $contact->email }}
                                        </a>
                                        <time datetime="2016-11-18T09:54" class="cooperation__column-block" style='--icon:url(&quot;/img/icons/13.svg&quot;)'>
                                            {{ $contact->working_hours }}
                                        </time>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="location  animate-block">
        <div class='location__container'>
            <div class="location__top fade-up" data-watch data-watch-once>
                <div class="location__top-content">
                    <h2 class="location__top-title">Москва, район Троицк,
                        <br>
                        Чароитовая улица, 5, стр. 49
                    </h2>
                    <div class="location__top-info">
                        <a href="javascript:void(0)" class="location__top-phone">+7 495 739-72-10</a>
                        <div class="location__top-socials">
                            <a href="javascript:void(0)" class="location__top-social" style='--icon:url(&quot;/img/icons/01.svg&quot;)'></a>
                            <a href="javascript:void(0)" class="location__top-social" style='--icon:url(&quot;/img/icons/02.svg&quot;)'></a>
                        </div>
                        <time datetime="2016-11-18T09:54" class="location__top-title">Пн–Пт 8:00 до 17:00</time>
                    </div>
                </div>
                <a href="{{ route('popup.callback') }}" data-popup="#callback-popupTwo" class="location__top-btn btn btn--alt btn--icon" style='--icon:url(&quot;/img/icons/03.svg&quot;)'>Перезвоните нам</a>
            </div>
            <div class="location__inner">
                <div class="location__info fade-up" data-watch data-watch-once>
                    <div class="location__slider swiper js-slider-location">
                        <div class="location__swiper swiper-wrapper">
                            <div class="location__slide swiper-slide">
                                <div class="location__slide-img">
                                    <picture>
                                        <img src="./img/location/01.webp" srcset="./img/location/01@2x.webp 2x" alt="">
                                    </picture>
                                </div>
                            </div>
                            <div class="location__slide swiper-slide">
                                <div class="location__slide-img">
                                    <picture>
                                        <img src="./img/location/01.webp" srcset="./img/location/01@2x.webp 2x" alt="">
                                    </picture>
                                </div>
                            </div>
                        </div>
                        <div class="location__arrows swiper-arrows">
                            <button type="button" class="location__arrow location__arrow--prev swiper-arrow swiper-arrow--prev" style='--icon:url(&quot;/img/icons/05.svg&quot;)'></button>
                            <button type="button" class="location__arrow location__arrow--next swiper-arrow swiper-arrow--next" style='--icon:url(&quot;/img/icons/06.svg&quot;)'></button>
                        </div>
                        <div class="location__pagging swiper-pagging"></div>
                    </div>
                    <div class="location__row">
                        <div class="location__column">
                            <div class="location__column-title">Парковка</div>
                            <div class="location__column-text">Парковка: пн–вс, кроме праздников, с 8:00 до 21:00 ч — 450 ₽/ч;
                                <br>
                                с 21:00 до 8:00 ч — 200 ₽/ч
                            </div>
                        </div>
                        <div class="location__column">
                            <div class="location__column-title">Как добраться</div>
                            <div class="location__column-text">Двигаясь по внутренней стороне Садового кольца свернуть направо на улицу Спиридоновка.</div>
                        </div>
                    </div>
                    <div class="location__bottom">
                        <div class="location__bottom-info">
                            <div class="location__bottom-title">Мы в соцсетях:</div>
                            <div class="location__bottom-items">
                                <a href="javascript:void(0)" class="location__bottom-item">
                                    <picture>
                                        <img src="./img/footer/01.webp" srcset="./img/footer/01@2x.webp 2x" alt="">
                                    </picture>
                                </a>
                                <a href="javascript:void(0)" class="location__bottom-item">
                                    <picture>
                                        <img src="./img/footer/02.webp" srcset="./img/footer/02@2x.webp 2x" alt="">
                                    </picture>
                                </a>
                                <a href="javascript:void(0)" class="location__bottom-item">
                                    <picture>
                                        <img src="./img/footer/03.webp" srcset="./img/footer/03@2x.webp 2x" alt="">
                                    </picture>
                                </a>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="location__bottom-btn btn btn--icon btn--org" style='--icon:url(&quot;/img/icons/03.svg&quot;)'>Проложить маршрут</a>
                    </div>
                </div>
                <div class="location__map map fade-up" data-watch data-watch-once id="map" data-key="Ваш API ключ" data-center="[55.779324, 37.581623]" data-icon="Ссылка на иконку"></div>
            </div>
        </div>
    </section>
</div>
