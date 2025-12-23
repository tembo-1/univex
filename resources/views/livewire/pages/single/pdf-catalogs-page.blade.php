<div>
    <section class="manufacturer  animate-block" data-watch data-watch-once>
        <div class='manufacturer__container'>
            <h2 class="manufacturer__title block-title">Каталоги в PDF</h2>
            <div class="manufacturer__quest quest-block quest-block--alt">
                <div class="quest-block__info">
                    <h2 class="quest-block__title block-title">поиск
                        <br>
                        по каталогу
                    </h2>
                </div>
                <div class="quest-block__content">
                    <form wire:submit.prevent="Catalogs" class="quest-block__form form">
                        <div class="form__search">
                            <div class="form__search-input">
                                <input
                                    wire:model.live.debounce.300ms="search"
                                    autocomplete="off"
                                    type="text"
                                    name="search"
                                    data-error="Ошибка"
                                    placeholder="Название производителя или файла"
                                    class="input"
                                >
                            </div>
                            <button type="submit" class="form__search-icon" style='--icon:url("/img/icons/15.svg")'></button>
                        </div>
                    </form>
                </div>

            </div>
            <div class="manufacturer__items">
                @foreach($catalogs as $catalog)
                    <div class="manufacturer__item item-quest">
                        <div class="item-quest__title">{{ $catalog->name }}</div>
                        <ul class="item-quest__list">
                            @foreach($catalog->catalogFiles as $file)
                                <li class="item-quest__column">
                                    <a href="http://localhost:3377/documents/{{ $file->file_path }}" class="item-quest__link">{{ $file->name }}
                                    </a>(12.5 мб)
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
