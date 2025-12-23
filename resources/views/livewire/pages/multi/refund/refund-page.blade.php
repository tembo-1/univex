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
                    <h2 class="notebook__title block-title">заявка на возврат №245 от 16.08.2025</h2>
                </div>
            </div>
            <div class="notebook__table table-block">
                <div class="table-block__title">ТОВАРЫ ДЛЯ ВОЗВРАТА</div>
                <div class="table-block__scroll">
                    <div class="table-block__items">
                        <div class="table-block__item table-block__item--head">
                            <div class="table-block__row table-block__row--five">
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
                                        <div class="table-block__category">Причина возврата</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach($refundItems as $refundItem)
                            <div class="table-block__item table-block__item--color">
                                <div class="table-block__row table-block__row--five">
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <a href="javascript:void(0)" class="table-block__text">{{ $refundItem->orderItem->product_id }}</a>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">ONYARBI</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $refundItem->orderItem->product_sku }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column table-block__column--big">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $refundItem->orderItem->product_name }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $refundItem->total_amount }}</div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div data-quantity class="table-block__quantity quantity">
                                                <div class="quantity__input">
                                                    <input disabled data-quantity-value autocomplete="off" type="number" name="form[]" value="{{ $refundItem->quantity }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-block__column">
                                        <div class="table-block__info">
                                            <div class="table-block__text">{{ $refundItem->refundType->name }}</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <form action="#" class="notebook__content">
                <div class="notebook__content-blocks">
                    <div class="notebook__content-block block-notebook">
                        <div class="block-notebook__top">
                            <div class="block-notebook__title">ПРИКРЕПленные ФАЙЛЫ</div>
                        </div>
                        <div class="block-notebook__row">
                            @foreach($images as $image)
                                <div class="block-notebook__column">
                                    <div class="block-notebook__img">
                                        <picture>
                                            <img src="{{ $image['url'] }}" srcset="{{ $image['url'] }} 2x" alt="">
                                        </picture>
                                    </div>
                                    <div class="block-notebook__subtext">Фото стикер на упаковке</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="notebook__content-blocks">
                    <div class="notebook__content-block block-notebook">
                        <div class="block-notebook__top">
                            <div class="block-notebook__title">Коментарий к заявке</div>
                        </div>
                        <div class="block-notebook__items"
                             style='--icon:url(&quot;/img/icons/28.svg&quot;)'
                             wire:poll.10s="updateConversations">

                            @if($refundConversations->isEmpty())
                                <div class="text-gray-500 text-center py-4">
                                    Нет сообщений
                                </div>
                            @else
                                @foreach($refundConversations as $refundConversation)
                                    <div class="block-notebook__item item-notebook" wire:key="conversation-{{ $refundConversation->id }}-{{ $refundConversation->updated_at->timestamp }}">
                                        <div class="item-notebook__top">
                                            <div class="item-notebook__title">
                                                {{ $refundConversation->user->email ?? 'Пользователь' }}
                                            </div>
                                            <time datetime="{{ $refundConversation->created_at->format('Y-m-d\TH:i') }}"
                                                  class="item-notebook__time">
                                                {{ $refundConversation->created_at->format('d.m.Y H:i') }}
                                            </time>
                                        </div>
                                        <div class="item-notebook__text">
                                            {{ $refundConversation->message }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="notebook__content-block block-notebook" wire:ignore>
                        <div class="block-notebook__top">
                            <div class="block-notebook__title">Новый Коментарий к заявке</div>
                        </div>
                        <div class="block-notebook__inner js-file">
                            <div class="block-notebook__info">
                                <div class="block-notebook__textarea">
                                    <textarea wire:model="message" class="input" placeholder="Введите что-то..." data-autoheight data-autoheight-min="120" data-autoheight-max="120"></textarea>
                                </div>
                                <a href="javascript:void(0)" class="block-notebook__download js-click-file" style='--icon:url(&quot;/img/icons/27.svg&quot;)'></a>
                            </div>
                            <div class="block-notebook__new file-loader file-loader--text" data-type='files'>
                                <div class="file-loader__inner">
                                    <div class="file-loader__content">
                                        <div class="file-loader__row">
                                            <div class="file-loader__info">
                                                <div class="file-loader__icon" style='--icon:url(&quot;/img/icons/25.svg&quot;)'></div>
                                                <input id="file-upload" class="file-loader__input visually-hidden js-file-doc" type="file" name="file" multiple accept=".png,.jpg,.jpeg">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="file-loader__files"></div>
                                    <div class="file-loader__error"></div>

                                </div>

                            </div>
                        </div>
                        <button wire:click="$dispatch('collect-form-data')"
                                wire:target="submit,photos"
                                type="button"
                                class="block-notebook__btn btn btn--blue">
                            Отправить комментрий
                        </button>
                    </div>
                </div>
            </form>
    </section>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('collect-form-data', async () => {
                console.log('Собираем данные формы с файлами...');

                // 1. Собираем файлы из input с multiple
                const fileInput = document.getElementById('file-upload');

                // Функция для чтения файла в base64
                function readFileAsBase64(file) {
                    return new Promise((resolve, reject) => {
                        const reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onload = () => resolve(reader.result);
                        reader.onerror = error => reject(error);
                    });
                }

                // Собираем ВСЕ файлы из инпута
                const files = [];
                if (fileInput && fileInput.files.length > 0) {
                    // Читаем каждый файл
                    for (let i = 0; i < fileInput.files.length; i++) {
                        const file = fileInput.files[i];
                        try {
                            const base64 = await readFileAsBase64(file);

                            // Определяем тип файла (фото или видео)
                            const isVideo = file.type.startsWith('video/');
                            const fileType = isVideo ? 'video' : 'photo';

                            files.push({
                                index: i + 1,
                                name: file.name,
                                type: file.type,
                                size: file.size,
                                file_type: fileType, // Добавляем тип для разделения
                                data: base64
                            });
                        } catch (error) {
                            console.error(`Error reading file ${file.name}:`, error);
                        }
                    }
                }

                // 2. Собираем остальные данные
                const data = {
                    files: files, // Все файлы в одном массиве
                };

                // 3. Отправляем данные в Livewire
            @this.call('processFormData', data);

                if (fileInput) {
                    let closeBtns;
                    while ((closeBtns = document.querySelectorAll('.file-loader__result .close')).length > 0) {
                        closeBtns[0].click();
                    }
                }
            });
        });
    </script>
</div>
