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
									<span>Создание заявки на возврат</span>
								</span>
            </li>
        </ul>
    </div>
    <section class="notebook  animate-block" data-watch data-watch-once>
        <div class='notebook__container'>
            <div class="notebook__top">
                <div class="notebook__info">
                    <a href="javascript:void(0)" class="notebook__back" style='--icon:url(&quot;/img/icons/back.svg&quot;)'></a>
                    <h2 class="notebook__title block-title">Создание заявки на возврат</h2>
                </div>
            </div>
            <div class="notebook__constructor">
                <form wire:ignore class="notebook__constructor-form form" data-one-select>
                    <div class="form__row form__row--two">
                        <div class="form__column">
                            <div class="form__column-title">Выберите номер заказа</div>
                            <div class="form__column-items">
                                <div class="form__column-item">
                                    <div class="form__column-select">
                                        <select name="form[]" class="form" id="orderId-select" name="orderId">
                                            <option selected>Все</option>
                                            @foreach($orders as $order)
                                                <option @if($orderId == $order->id) selected @endif value="{{ $order->id }}">{{ $order->id }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="notebook__table table-block">
                <div class="table-block__title">ВЫБРАТЬ ТОВАРЫ ДЛЯ ВОЗВРАТА</div>
                <div class="table-block__scroll" data-one-select>
                    <div class="table-block__items">
                        <div class="table-block__item table-block__item--head">
                            <div class="table-block__row table-block__row--four">
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">ID Товар</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Производитель</div>
                                    </div>
                                </div>
                                <div class="table-block__column ">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Артикул</div>
                                    </div>
                                </div>
                                <div class="table-block__column table-block__column--big">
                                    <div class="table-block__info">
                                        <div class="table-block__category">наименование</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Цена, ₽</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">количество</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">выбрать</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Сколько вернуть</div>
                                    </div>
                                </div>
                                <div class="table-block__column">
                                    <div class="table-block__info">
                                        <div class="table-block__category">Причина возврата</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach($orderItems as $orderItem)
                            <div class="table-block__item table-block__item--color" wire:key="item-{{ $orderItem->id }}">
                                <div class="table-block__row table-block__row--four">
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <a href="javascript:void(0)" class="table-block__text">{{ $orderItem->product_id }}</a>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $orderItem->product->manufacturer->name }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $orderItem->product_sku }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column table-block__column--big">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $orderItem->product_name }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $orderItem->total_amount / 100.0 }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $orderItem->quantity }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__checkbox checkbox">
                                                <input id="item_{{ $orderItem->id }}"
                                                       name="selected_items[{{ $orderItem->id }}]"
                                                       data-error="Ошибка"
                                                       class="checkbox__input"
                                                       type="checkbox"
                                                       value="1">
                                                <label for="item_{{ $orderItem->id }}" class="checkbox__label"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div data-quantity class="table-block__quantity quantity">
                                                <button data-quantity-minus type="button" class="quantity__button quantity__button--minus"></button>
                                                <div class="quantity__input">
                                                    <input data-quantity-value
                                                           autocomplete="off"
                                                           type="number"
                                                           name="quantities[{{ $orderItem->id }}]"
                                                           value="{{ $orderItem->quantity }}"
                                                           min="1"
                                                           max="{{ $orderItem->quantity }}">
                                                </div>
                                                <button data-quantity-plus type="button" class="quantity__button quantity__button--plus"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__select select-container" wire:ignore>
                                                <select class="form" name="reasons[{{ $orderItem->id }}]">
                                                    @foreach($refundTypes as $refundType)
                                                        <option value="{{ $refundType->id }}">{{ $refundType->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <form class="notebook__content">
                <div class="notebook__content-blocks">
                    <div class="notebook__content-block block-notebook">
                        <div class="block-notebook__top">
                            <div class="block-notebook__title">ПРИКРЕПИТЬ ФАЙЛЫ</div>
                            <div class="block-notebook__text">
                                Прикрепите фото и видео в формате
                                <br>
                                <span>JPEG / PNG / WebP / HEIC/MP4 / MOV / AVI / MKV / WEBM,</span>
                                вес файла 1,3 МБ
                            </div>
                        </div>
                        <div class="block-notebook__files">
                            <div class="block-notebook__file file-loader" data-type='files'>
                                <div class="file-loader__inner">
                                    <div class="file-loader__content">
                                        <div class="file-loader__row">
                                            <div class="file-loader__info">
                                                <div class="file-loader__icon" style='--icon:url(&quot;/img/icons/25.svg&quot;)'></div>
                                                <input id="file-upload1" class="file-loader__input visually-hidden" type="file" name="file" accept=".png, .jpg, .jpeg, .webp, .heic, image/png, image/jpeg, image/webp, image/heic">
                                                <div class="file-loader__files"></div>

                                            </div>
                                            <div class="file-loader__title">Фото стикер на упаковке</div>
                                        </div>
                                    </div>
                                    <div class="file-loader__error"></div>

                                </div>

                            </div>
                            <div class="block-notebook__file file-loader" data-type='files'>
                                <div class="file-loader__inner">
                                    <div class="file-loader__content">
                                        <div class="file-loader__row">
                                            <div class="file-loader__info">
                                                <div class="file-loader__icon" style='--icon:url(&quot;/img/icons/25.svg&quot;)'></div>
                                                <input id="file-upload2" class="file-loader__input visually-hidden" type="file" name="file" accept=".png, .jpg, .jpeg, .webp, .heic, image/png, image/jpeg, image/webp, image/heic">
                                                <div class="file-loader__files"></div>

                                            </div>
                                            <div class="file-loader__title">Фото стикер на упаковке</div>
                                        </div>
                                    </div>
                                    <div class="file-loader__error"></div>

                                </div>

                            </div>
                            <div class="block-notebook__file file-loader" data-type='files'>
                                <div class="file-loader__inner">
                                    <div class="file-loader__content">
                                        <div class="file-loader__row">
                                            <div class="file-loader__info">
                                                <div class="file-loader__icon" style='--icon:url(&quot;/img/icons/25.svg&quot;)'></div>
                                                <input id="file-upload3" class="file-loader__input visually-hidden" type="file" name="file" accept=".png, .jpg, .jpeg, .webp, .heic, image/png, image/jpeg, image/webp, image/heic">
                                                <div class="file-loader__files"></div>

                                            </div>
                                            <div class="file-loader__title">Фото стикер на упаковке</div>
                                        </div>
                                    </div>
                                    <div class="file-loader__error"></div>

                                </div>

                            </div>
                            <div class="block-notebook__file file-loader" data-type='files'>
                                <div class="file-loader__inner">
                                    <div class="file-loader__content">
                                        <div class="file-loader__row">
                                            <div class="file-loader__info">
                                                <div class="file-loader__icon" style='--icon:url(&quot;/img/icons/25.svg&quot;)'></div>
                                                <input id="file-upload1" class="file-loader__input visually-hidden" type="file" name="file" accept=".png, .jpg, .jpeg, .webp, .heic, image/png, image/jpeg, image/webp, image/heic">
                                                <div class="file-loader__files"></div>

                                            </div>
                                            <div class="file-loader__title">Фото стикер на упаковке</div>
                                        </div>
                                    </div>
                                    <div class="file-loader__error"></div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="notebook__content-blocks">
                    <div class="notebook__content-block block-notebook">
                        <div class="block-notebook__top">
                            <div class="block-notebook__title">Коментарий</div>
                        </div>
                        <div class="block-notebook__inner">
                            <div class="block-notebook__info">
                                <div class="block-notebook__textarea" wire:ignore>
                                    <textarea wire:model="comment" class="input" placeholder="Введите что-то..." data-autoheight data-autoheight-min="125" data-autoheight-max="300"></textarea>
                                </div>
                            </div>
                        </div>
                        <button wire:click="$dispatch('collect-form-data')"
                                wire:target="submit,photos,videos"
                                type="button"
                                class="block-notebook__btn btn btn--blue">
                            Оформить возврат
                        </button>
                    </div>
                </div>
            </form>
    </section>


    <script>
        window.addEventListener('init-selects', event => {
            setTimeout(() => {
                new window.select.constructor(null, '.table-block__select select');
            });
        });

        document.addEventListener("selectCallback", function(e) {
            if (e.detail.select.id === 'orderId-select') {
                const orderIdSelect = document.getElementById('orderId-select');
                if (orderIdSelect) {
                    if (orderIdSelect.value !== 'Все') {
                    @this.set('orderId', orderIdSelect.value);
                    }
                }
            }
        });

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('collect-form-data', async () => {
                // 1. Собираем файлы
                const photoInputs = [
                    document.getElementById('file-upload1'),
                    document.getElementById('file-upload2'),
                    document.getElementById('file-upload3')
                ];

                const videoInputs = [
                    document.querySelector('input[accept*="video"]')
                ];

                // Функция для чтения файла в base64
                function readFileAsBase64(file) {
                    return new Promise((resolve, reject) => {
                        const reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onload = () => resolve(reader.result);
                        reader.onerror = error => reject(error);
                    });
                }

                // Собираем фото в base64
                const photos = [];
                for (let i = 0; i < photoInputs.length; i++) {
                    const input = photoInputs[i];
                    if (input && input.files.length > 0) {
                        const base64 = await readFileAsBase64(input.files[0]);
                        photos.push({
                            index: i + 1,
                            name: input.files[0].name,
                            type: input.files[0].type,
                            size: input.files[0].size,
                            data: base64 // base64 строка с data:image/...
                        });
                    }
                }

                // Собираем видео в base64
                const videos = [];
                if (videoInputs[0] && videoInputs[0].files.length > 0) {
                    const base64 = await readFileAsBase64(videoInputs[0].files[0]);
                    videos.push({
                        name: videoInputs[0].files[0].name,
                        type: videoInputs[0].files[0].type,
                        size: videoInputs[0].files[0].size,
                        data: base64 // base64 строка с data:video/...
                    });
                }

                // 2. Собираем остальные данные
                const data = {
                    selected_items: {},
                    quantities: {},
                    reasons: {},
                    photos: photos, // Массив фото в base64
                    videos: videos  // Массив видео в base64
                };

                // Собираем чекбоксы
                document.querySelectorAll('input[name^="selected_items["]').forEach(input => {
                    const match = input.name.match(/selected_items\[(\d+)\]/);
                    if (match) {
                        data.selected_items[match[1]] = input.checked ? '1' : '0';
                    }
                });

                // Собираем количества
                document.querySelectorAll('input[name^="quantities["]').forEach(input => {
                    const match = input.name.match(/quantities\[(\d+)\]/);
                    if (match) {
                        data.quantities[match[1]] = input.value;
                    }
                });

                // Собираем причины
                document.querySelectorAll('select[name^="reasons["]').forEach(select => {
                    const match = select.name.match(/reasons\[(\d+)\]/);
                    if (match) {
                        data.reasons[match[1]] = select.value;
                    }
                });

                // 3. Отправляем ВСЕ данные в Livewire
            @this.call('processFormData', data);
            });
        });
    </script>
</div>
