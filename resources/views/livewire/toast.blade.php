<div class="notifications-container">
    @foreach($toasts as $toast)
        <div wire:key="toast-{{ $toast['id'] }}"
             class="notification-item"
             style="
                 border-left-color: @if($toast['type'] === 'success') #10b981
                 @elseif($toast['type'] === 'error') #ef4444
                 @elseif($toast['type'] === 'warning') #f59e0b
                 @else #3b82f6 @endif;
                 width: 350px;
                 margin-bottom: 12px;
             "
             x-data="{ show: true }"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-x-full"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-x-0"
             x-transition:leave-end="opacity-0 transform translate-x-full">

            <div class="notification-header">
                <div class="notification-title">
                    @if($toast['title'])
                        {{ $toast['title'] }}
                    @else
                        @switch($toast['type'])
                            @case('success') Успех @break
                            @case('error') Ошибка @break
                            @case('warning') Внимание @break
                            @case('info') Информация @break
                        @endswitch
                    @endif
                </div>

                <button type="button"
                        class="notification-close"
                        @click="
                            show = false;
                            setTimeout(() => {
                                @this.hide('{{ $toast['id'] }}');
                            }, 300);
                        "
                        title="Закрыть">
                    <svg class="close-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="notification-content">{{ $toast['message'] }}</div>

            <!-- Автоматически скрыть через 5 секунд -->
            <div x-init="setTimeout(() => { show = false; setTimeout(() => @this.hide('{{ $toast['id'] }}'), 300) }, 5000)"></div>
        </div>
    @endforeach
</div>
