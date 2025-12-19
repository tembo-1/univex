<div id="callback-popupThree" wire:ignore.self aria-hidden="true" role="dialog" class="popup popup--two">
    <div class="popup__wrapper">
        <div class="popup__content">
            <div class="popup__inner">
                <button data-close type="button" class="popup__close" style='--icon:url(&quot;/img/icons/73.svg&quot;)'></button>
                <div class="popup__top">
                    <div class="popup__title">Новый блокнот</div>
                </div>
                <form class="popup__form form" wire:submit.prevent="submit">
                    <div class="form__blocks">
                        <div class="form__block">
                            <div class="form__block-items">
                                <div class="form__block-item">
                                    <div class="form__block-input">
                                        <label for="" class="form__block-label">Название блокнота</label>
                                        <input wire:model="name" autocomplete="off" type="text" name="form[]" data-error="Ошибка" class="input">
                                    </div>
                                </div>
                            </div>

                            <div class="form__block-bottom form__block-bottom--two">
                                <button type="submit" class="form__block-btn btn">Создать</button>
                            </div>

                            @if($error)
                                <div class="form__error-message" style="color: #ff3b30; text-align: center; margin: 10px 0; padding: 10px; background: #ffeaea; border-radius: 5px;">
                                    {{ $error }}
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
