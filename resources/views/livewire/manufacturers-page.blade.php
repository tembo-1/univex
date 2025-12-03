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
                    <span>Производители</span>
                </span>
            </li>
        </ul>
    </div>

    <section class="manufacturer animate-block">
        <div class='manufacturer__container'>
            <h2 class="manufacturer__title block-title @if($page == 1)  @endif" data-watch data-watch-once>
                Производители
            </h2>

            <div class="manufacturer__quest quest-block quest-block--alt @if($page == 1) @endif" data-watch data-watch-once>
                <div class="quest-block__info">
                    <h2 class="quest-block__title block-title">поиск<br>по производителю</h2>
                </div>
                <div class="quest-block__content">
                    <form action="#" class="quest-block__form form">
                        <div class="form__search">
                            <div class="form__search-input">
                                <input autocomplete="off" type="text" name="search"
                                       data-error="Ошибка" placeholder="Производитель"
                                       class="input"
                                       wire:model.live.debounce.300ms="search">
                            </div>
                            <button type="button" class="form__search-icon"
                                    style='--icon:url("/img/icons/15.svg")'></button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Основной контейнер с производителями -->
            <div class="manufacturers-container">
                <div class="manufacturer__row @if($page == 1) @endif"
                     @if($page == 1) data-watch data-watch-once @endif>
                    @foreach($manufacturers as $manufacturer)
                        <a href="#" class="manufacturer__column"
                           style='--icon:url("/img/icons/16.svg")'>
                            <div class="manufacturer__column-text">{{ $manufacturer->name }}</div>
                        </a>
                    @endforeach
                </div>
            </div>

            @if($hasMore)
                <button class="manufacturer__showmore btn btn--showmore"
                        @if($page == 1) data-watch data-watch-once @endif
                        wire:click="loadMore">
                    загрузить еще производителей
                </button>
            @endif
        </div>
    </section>
</div>
