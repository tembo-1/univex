<div id="callback-popupFour" wire:ignore.self aria-hidden="true" role="dialog" class="popup ">
    <div class="popup__wrapper">
        <div class="popup__content">
            <div class="popup__inner">
                <button data-close type="button" class="popup__close" style='--icon:url(&quot;/img/icons/73.svg&quot;)'></button>
                <div class="popup__top">
                    <div class="popup__title">Восстановление
                        <br>
                        аккаунта
                    </div>
                </div>
                <form wire:submit.prevent="submit" class="popup__form form">
                    <div class="form__blocks">
                        <div class="form__block">
                            <div class="form__block-items">
                                <div class="form__block-item">
                                    <div class="form__block-input">
                                        <label for="" class="form__block-label">e-mail</label>
                                        <input wire:model="email" autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="info@gmail.com" class="input" data-validate data-required="email">
                                    </div>
                                </div>
                            </div>

                            <div class="form__block-bottom">
                                <button type="submit" class="form__block-btn btn">Восстановить</button>
                            </div>

                            @if($errors->any())
                                <div class="form__error-message" style="width:100%; color: #ff3b30; text-align: center; margin: 10px 0; padding: 10px; background: #ffeaea; border-radius: 5px;">
                                    @foreach($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
