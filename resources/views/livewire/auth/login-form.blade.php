<form wire:submit.prevent="submit" class="popup__form form">
    <div class="form__blocks">
        <div class="form__block">
            <div class="form__block-items">
                <div class="form__block-item">
                    <div class="form__block-input">
                        <label class="form__block-label">E-mail</label>
                        <input
                            wire:model="email"
                            type="text"
                            placeholder="info@gmail.com"
                            class="input @error('email') input--error @enderror"
                        >
                        @error('email')
                        <div class="form__error" style="color: #ff3b30; font-size: 12px; margin-top: 5px;">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form__block-item" style='--password:url(&quot;/img/icons/77.svg&quot;); --show:url(&quot;/img/icons/78.svg&quot;);'>
                    <div class="form__block-input js-password">
                        <label class="form__block-label">Пароль</label>
                        <input
                            wire:model="password"
                            placeholder="Ваш пароль"
                            class="input js-password-field"
                            type="password"
                        >
                        <button
                            type="button"
                            class="form__item-password js-password-toggle"
                        ></button>
                        @error('password')
                        <div class="form__error" style="color: #ff3b30; font-size: 12px; margin-top: 5px;">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Общая ошибка --}}
            @if($error)
                <div class="form__error-message" style="color: #ff3b30; text-align: center; margin: 10px 0; padding: 10px; background: #ffeaea; border-radius: 5px;">
                    {{ $error }}
                </div>
            @endif

            <div class="form__block-bottom form__block-bottom--two">
                <a
                    href="{{ route('popup.register') }}"
                    data-popup="#callback-popupSix"
                    class="form__block-link">Регистрация</a>
                <a
                    href="{{ route('popup.forgot') }}"
                    data-popup="#callback-popupFour"
                    class="form__block-link">Забыли пароль?</a>

                <button type="submit" class="form__block-btn btn" wire:loading.attr="disabled">
                    <span>Войти</span>
                </button>
            </div>
        </div>
    </div>
</form>

