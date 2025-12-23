<div wire:poll.10s="loadNotifications">
    @if($notifications->count() > 0)
        <div class="notifications-container" style="min-width: 350px;">
            @foreach($notifications as $notification)
                <div wire:key="notification-{{ $notification->id }}"
                     class="notification-item"
                     style="border-left-color: {{ $notification->color }}; width: 350px;"
                     x-data="{ show: true }"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-full"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform translate-x-0"
                     x-transition:leave-end="opacity-0 transform translate-x-full">

                    <div class="notification-header">
                        <div class="notification-title">{{ $notification->title }}</div>
                        <button
                            type="button"
                            class="notification-close"
                            @click="
                                show = false;
                                setTimeout(() => {
                                    @this.hideNotification({{ $notification->id }});
                                }, 300);
                            "
                            title="Закрыть">
                            <svg class="close-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="notification-content">{{ $notification->content }}</div>

                    @if($notification->starts_at)
                        <div class="notification-time">
                            {{ $notification->starts_at }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
