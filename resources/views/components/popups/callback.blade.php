<div id="callback-popupTwo" wire:ignore.self aria-hidden="true" role="dialog" class="popup popup--two">
    <div class="popup__wrapper">
        <div class="popup__content">
            <div class="popup__inner">
                <button data-close type="button" class="popup__close" style='--icon:url(&quot;/img/icons/73.svg&quot;)'></button>
                <div class="popup__top">
                    <div class="popup__title">Заказать звонок</div>
                </div>
                <form wire:submit.prevent="submit" class="popup__form form">
                    <div class="form__blocks">
                        <div class="form__block">
                            <div class="form__block-items">
                                <div class="form__block-item">
                                    <div class="form__block-input">
                                        <label for="" class="form__block-label">ФИО</label>
                                        <input wire:model="name" autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Иванво Иван Иванович" class="input" data-validate data-required>
                                    </div>
                                </div>
                                <div class="form__block-item">
                                    <div class="form__block-input">
                                        <label for="" class="form__block-label">Номера телефона</label>
                                        <input wire:model="phone" autocomplete="off" type="tel" name="form[]" data-error="Ошибка" placeholder="" class="input" data-validate data-required="tel">
                                    </div>
                                </div>
                            </div>
                            <div class="form__block-connection">
                                <div class="form__block-text">
                                    Как вам удобнее получить обратную связь?</div>
                                <div class="form__block-checkboxs">
                                    <div class="form__block-checkbox checkbox">
                                        <input wire:model="method" id="czz_1" data-error="Ошибка" class="checkbox__input" type="radio" value="phone" name="form[]" data-validate checked>
                                        <label for="czz_1" class="checkbox__label">
                                            <span class="checkbox__text checkbox__text--icon" style='--icon:url(&quot;/img/icons/74.svg&quot;)'>На мой номер</span>
                                        </label>
                                    </div>
                                    <div class="form__block-checkbox checkbox">
                                        <input wire:model="method" id="czz_2" data-error="Ошибка" class="checkbox__input" type="radio" value="telegram" name="form[]" data-validate>
                                        <label for="czz_2" class="checkbox__label">
                                            <span class="checkbox__text checkbox__text--icon" style='--icon:url(&quot;/img/icons/75.svg&quot;)'>Телеграмм</span>
                                        </label>
                                    </div>
                                    <div class="form__block-checkbox checkbox">
                                        <input wire:model="method" id="czz_3" data-error="Ошибка" class="checkbox__input" type="radio" value="whatsapp" name="form[]" data-validate>
                                        <label for="czz_3" class="checkbox__label">
                                            <span class="checkbox__text checkbox__text--icon" style='--icon:url(&quot;/img/icons/76.svg&quot;)'>Watsapp</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form__block-bottom">

                                <div class="form__block-checkbox checkbox">
                                    <input wire:model="privacy" id="cddd_1" data-error="Ошибка" class="checkbox__input" type="checkbox" value="1" name="form[]" data-validate data-required>
                                    <label for="cddd_1" class="checkbox__label">
										<span class="checkbox__text">Нажимая кнопку «Отправить», я соглашаюсь с условиями
											<a href="javascript:void(0)">
												политики конфиденциальности</a>
											и
											<a href="javascript:void(0)">
												пользовательского соглашения</a>
											.
										</span>
                                    </label>
                                </div>
                                <button type="submit" class="form__block-btn btn">Отправить</button>

                                @if($errors->any())
                                    <div class="form__error-message" style="color: #ff3b30; text-align: center; margin: 10px 0; padding: 10px; background: #ffeaea; border-radius: 5px;">
                                        @foreach($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

