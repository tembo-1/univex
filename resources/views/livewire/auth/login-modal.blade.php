{{-- resources/views/livewire/auth/login-modal.blade.php --}}
<div wire:ignore id="callback-popupThree" aria-hidden="true" role="dialog" class="popup popup--two">
    <div class="popup__wrapper">
        <div class="popup__content">
            <div class="popup__inner">
                <button data-close type="button" class="popup__close" style='--icon:url(&quot;/img/icons/73.svg&quot;)'></button>

                <div class="popup__top">
                    <div class="popup__title">Вход</div>
                </div>

                <div id="livewire-container">
                    @livewire('auth.login-form')
                </div>
            </div>
        </div>
    </div>
</div>
