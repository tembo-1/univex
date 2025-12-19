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
									<span>Блокнот</span>
								</span>
            </li>
        </ul>
    </div>
    <section class="notebook  animate-block" data-watch data-watch-once>
        <div class='notebook__container'>
            <div class="notebook__top">
                <div class="notebook__info">
                    <a href="javascript:void(0)" class="notebook__back" style='--icon:url(&quot;/img/icons/back.svg&quot;)'></a>
                    <h2 class="notebook__title block-title">блокнот</h2>
                </div>
            </div>
            <div class="notebook__quest quest-block quest-block--alt">
                <div class="quest-block__info">
                    <h2 class="quest-block__title block-title">поиск
                        <br>
                        по Блокноту
                    </h2>
                </div>
                <div class="quest-block__content">
                    <form action="#" class="quest-block__form form">
                        <div class="form__search">
                            <div class="form__search-input">
                                <input
                                    wire:model.live.debounce.300ms="search"
                                    autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Название..." class="input">
                            </div>
                            <button type="button" class="form__search-icon" style='--icon:url(&quot;/img/icons/15.svg&quot;)'></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="notebook__constructor">
                <form wire:ignore class="notebook__constructor-form form" data-one-select>
                    <div class="form__row">
                        <div class="form__column">
                            <div class="form__column-title">Сортировать:</div>
                            <div class="form__column-items form__column-items--two">
                                <div class="form__column-item">
                                    <div class="form__column-select">
                                        <select id="period-select" name="period" class="form">
                                            <option value="1">За день</option>
                                            <option value="2">За неделю</option>
                                            <option value="3">За месяц</option>
                                            <option value="4">За 3 месяца</option>
                                            <option value="5">За 6 месяцев</option>
                                            <option value="6" selected>По дате</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form__column-item">
                                    <div class="form__column-select">
                                        <select id="sort-select" name="sort" class="form">
                                            <option selected value="4">Наименованию</option>
                                            <option value="3">Дате создания</option>
                                            <option value="5">От старого к новому</option>
                                            <option value="6">От нового к старому</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="notebook__sample sample-notebook">
                <div class="sample-notebook__row">
                    <a
                        href="{{ route('popup.notepad', ['productSlug' => $productSlug ?? null]) }}"
                        data-popup="#callback-popupThree"
                        class="sample-notebook__column sample-notebook__column--new">
                        <div class="sample-notebook__inner">
                            <div class="sample-notebook__create">
                                <div class="sample-notebook__subtitle">СОЗДАТЬ
                                    <br>
                                    НОВЫЙ БЛОКНОТ
                                </div>
                                <div class="sample-notebook__plus">
                                    <span>+</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @foreach($notepads as $notepad)
                        <a wire:click="addToNotepad({{$notepad->id}})" class="sample-notebook__column">
                            <div class="sample-notebook__inner">
                                <div class="sample-notebook__number"></div>
                                <div class="sample-notebook__bottom">
                                    <div class="sample-notebook__info">
                                        <div class="sample-notebook__title">Блокнот</div>
                                        <div class="sample-notebook__name">
                                            <span>{{ $notepad->name }}</span>
                                        </div>
                                    </div>
                                    <div class="sample-notebook__btn" style='--icon:url(&quot;/img/icons/46.svg&quot;)'></div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <a href="javascript:void(0)" class="sample-notebook__link btn btn--showmore">загрузить еще БЛОКНОТЫ</a>
            </div>
        </div>
    </section>

    @if($productSlug)
        <div wire:init="showToast"></div>
    @endif

    <script>
        document.addEventListener("selectCallback", function(e) {
            console.log('selectCallback fired', e);

            // Обрабатываем оба селекта
            const periodSelect = document.getElementById('period-select');
            const sortSelect = document.getElementById('sort-select');

            if (periodSelect) {
            @this.set('period', periodSelect.value);
            }

            if (sortSelect) {
            @this.set('sort', sortSelect.value);
            }
        });

        // На случай если обычные события тоже работают
        document.addEventListener('change', function(e) {
            if (e.target && e.target.id === 'period-select') {
            @this.set('period', e.target.value);
            }

            if (e.target && e.target.id === 'sort-select') {
            @this.set('sort', e.target.value);
            }
        });
    </script>

</div>
