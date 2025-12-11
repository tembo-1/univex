<div>
    <div class="breadcrumb">
        <ul class="breadcrumb__list breadcrumb__container">
            <li class="breadcrumb__item" style='--icon:url("/img/icons/10.svg")'>
                <span>
                    <a href="/">
                        <span>Главная</span>
                    </a>
                </span>
            </li>
            <li class="breadcrumb__item breadcrumb__item--active">
                <span>Реквизиты</span>
            </li>
        </ul>
    </div>

    <section class="notebook animate-block" data-watch data-watch-once>
        <div class='notebook__container'>
            <div class="notebook__top">
                <div class="notebook__info">
                    <h2 class="notebook__title block-title">Реквизиты</h2>
                </div>
                <div class="notebook__btns">
                    <button wire:click="downloadDocx"
                            class="notebook__link notebook__link--two btn btn--blue btn--icon"
                            style='--icon:url("/img/icons/70.svg")'>
                        Скачать реквизиты в формате .docx
                    </button>
                </div>
            </div>

            <div class="notebook__table table-block">
                <div class="table-block__scroll">
                    <div class="table-block__items">
                        @foreach($settings as $key => $setting)
                            @if($key % 2)
                                <div class="table-block__item">
                                    <div class="table-block__row table-block__row--thirteen">
                                        <div class="table-block__column table-block__column--color table-block__column--big" style='--bg: #FFF'>
                                            <div class="table-block__info">
                                                <div class="table-block__text table-block__text--bold">{{ $setting->description }}</div>
                                            </div>
                                        </div>
                                        <div class="table-block__column table-block__column--color table-block__column--big" style='--bg: #FFF'>
                                            <div class="table-block__info">
                                                <div class="table-block__text">{{ $setting->value }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="table-block__item">
                                    <div class="table-block__row table-block__row--thirteen">
                                        <div class="table-block__column table-block__column--color table-block__column--big" style='--bg: #D6DBE3'>
                                            <div class="table-block__info">
                                                <div class="table-block__text table-block__text--bold">{{ $setting->description }}</div>
                                            </div>
                                        </div>
                                        <div class="table-block__column table-block__column--color table-block__column--big" style='--bg: #EDF0F4'>
                                            <div class="table-block__info">
                                                <div class="table-block__text">{{ $setting->value }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
