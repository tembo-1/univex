<footer class="footer">
    <div class="footer__container">
        <div class="footer__inner">
            <div class="footer__content">
                <div data-spollers="992, max" class="footer__spollers spollers">
                    @foreach($menus as $menu)
                        @if(!$menu->menuItems->isEmpty())
                            <details class="spollers__item">
                                <summary class="spollers__title" style='--icon:url("/img/icons/04.svg")'>{{ $menu->name }}</summary>
                                <div class="spollers__body">
                                    <div class="spollers__inner">
                                        <ul class="spollers__list">
                                            @foreach($menu->menuItems as $menuItem)
                                                @php
                                                    try {
                                                        $url = route($menuItem->sitePage->slug);
                                                    } catch (\Exception $e) {
                                                        $url = route('page', $menuItem->sitePage->slug);
                                                    }
                                                @endphp

                                                <li class="spollers__page">
                                                    <a href="{{ $url }}" class="spollers__page-link">{{ $menuItem->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </details>
                        @endif
                    @endforeach
                </div>
                <div class="footer__bottom">
                    <div class="footer__bottom-info">
                        <div class="footer__bottom-company" style='--icon:url("/img/icons/01.svg")'>{{ now()->year }} ООО «АвтопартУнивекс»</div>
                        <a href="{{ $privacyPolicyUrl }}" class="footer__bottom-policy">Политика конфиденциальности</a>
                    </div>
                    <div class="footer__bottom-development">
                        <span>JW</span>
                        сайт разработан
                    </div>
                </div>
            </div>
            <div class="footer__info">
                <div class="footer__info-items">
                    <div class="footer__info-item">
                        <div class="footer__info-connection">
                            <a href="tel:{{ setting('site_phone') }}" class="footer__info-phone">{{ setting('site_phone') }}</a>
                            <div class="footer__info-socials">
                                <a href="#" class="footer__info-social" style='--icon:url("/img/icons/012.svg")'></a>
                                <a href="#" class="footer__info-social" style='--icon:url("/img/icons/02.svg")'></a>
                            </div>
                        </div>
                    </div>
                    <div class="footer__info-item">
                        <div class="footer__info-row">
                            <a href="mailto:{{ setting('site_email') }}" class="footer__info-column">{{ setting('site_email') }}</a>
                            <address class="footer__info-column">
                                {{ setting('site_address') }}
                            </address>
                        </div>
                    </div>
                    <div class="footer__info-item">
                        <div class="footer__info-title">Мы в соцсетях:</div>
                        <div class="footer__info-links">
                            <a href="{{ setting('site_vk') }}" class="footer__info-link">
                                <picture>
                                    <img src="/img/footer/01.webp" srcset="/img/footer/01@2x.webp 2x" alt="">
                                </picture>
                            </a>
                            <a href="{{ setting('site_telegram') }}" class="footer__info-link">
                                <picture>
                                    <img src="/img/footer/02.webp" srcset="/img/footer/02@2x.webp 2x" alt="">
                                </picture>
                            </a>
                            <a href="{{ setting('site_max') }}" class="footer__info-link">
                                <picture>
                                    <img src="/img/footer/03.webp" srcset="/img/footer/03@2x.webp 2x" alt="">
                                </picture>
                            </a>
                        </div>
                    </div>
                    <div class="footer__info-item footer__info-item--mobile">
                        <a href="#" class="footer__info-btn btn btn--alt btn--icon" style='--icon:url("/img/icons/03.svg")'>Перезвоните нам</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
