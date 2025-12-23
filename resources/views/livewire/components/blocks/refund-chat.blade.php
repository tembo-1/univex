{{-- resources/views/livewire/refund-chat.blade.php --}}
<div style="display: flex; flex-direction: column; gap: 1rem; width: 100%;">
    @if($refund)
        <!-- Заголовок -->
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.5rem 0.75rem; background: var(--chat-header-bg, #f8fafc); border: 1px solid var(--chat-border, #e2e8f0); border-radius: 0.5rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 1.75rem; height: 1.75rem; background: #6366f1; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 0.875rem; height: 0.875rem; color: white;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 style="font-weight: 600; color: var(--chat-text, #1e293b); margin: 0; font-size: 0.875rem;">Чат по возврату</h3>
                    <p style="font-size: 0.7rem; color: var(--chat-muted, #64748b); margin: 0;">#{{ $refund->id }}</p>
                </div>
            </div>
        </div>

        <!-- Сообщения -->
        <div style="background: var(--chat-bg, white); border: 1px solid var(--chat-border, #e2e8f0); border-radius: 0.5rem; height: 16rem; overflow-y: auto; padding: 0.5rem; display: flex; flex-direction: column; gap: 0.5rem;">
            @foreach($conversations as $message)
                <div style="display: flex; {{ $message->user_id === auth()->id() ? 'justify-content: flex-end' : 'justify-content: flex-start' }};">
                    <div style="max-width: 85%; min-width: 0; width: fit-content;">
                        @if($message->user_id !== auth()->id())
                            <div style="display: flex; align-items: center; gap: 0.375rem; margin-bottom: 0.125rem;">
                                <span style="font-size: 0.7rem; font-weight: 500; color: var(--chat-text, #374151);">
                                    {{ $message->user->name ?? 'Система' }}
                                </span>
                                <span style="font-size: 0.7rem; color: var(--chat-muted, #64748b);">
                                    {{ $message->created_at?->format('H:i') }}
                                </span>
                            </div>
                        @endif

                        <div style="padding: 0.375rem 0.625rem; border-radius: 0.75rem; font-size: 0.9125rem; line-height: 1.2;
                                  overflow-wrap: break-word;
                                  {{ $message->user_id === auth()->id()
                                     ? 'background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border-bottom-right-radius: 0.25rem;'
                                     : 'background: var(--chat-message-bg, #f1f5f9); color: var(--chat-text, #1e293b); border-bottom-left-radius: 0.25rem; border: 1px solid var(--chat-border, #e2e8f0);' }}">
                            {{ $message->message }}
                        </div>

                        @if($message->user_id === auth()->id())
                            <div style="margin-top: 0.125rem; display: flex; justify-content: flex-end;">
                                <span style="font-size: 0.7rem; color: var(--chat-muted, #64748b);">
                                    {{ $message->created_at?->format('H:i') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            @if($conversations->isEmpty())
                <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: var(--chat-muted, #64748b);">
                    <div style="text-align: center;">
                        <svg style="width: 2.5rem; height: 2.5rem; margin: 0 auto 0.375rem; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p style="font-size: 0.8rem; margin: 0;">Нет сообщений</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Форма отправки -->
        <div style="display: flex; gap: 0.5rem;">
            <input
                    type="text"
                    wire:model="newMessage"
                    placeholder="Введите сообщение..."
                    style="flex: 1; padding: 0.375rem 0.625rem; border: 1px solid var(--chat-border, #cbd5e1); border-radius: 0.375rem; background: var(--chat-input-bg, white); color: var(--chat-text, #1e293b); outline: none; transition: border-color 0.2s; font-size: 0.875rem;"
                    wire:keydown.enter="sendMessage"
                    onfocus="this.style.borderColor='#6366f1'"
                    onblur="this.style.borderColor='var(--chat-border, #cbd5e1)'"
            >
            <button
                    wire:click="sendMessage"
                    wire:loading.attr="disabled"
                    style="padding: 0.375rem 0.875rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none; border-radius: 0.375rem; display: flex; align-items: center; gap: 0.25rem; cursor: pointer; transition: all 0.2s; font-weight: 500; font-size: 0.875rem;"
                    onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'"
            >
                <svg style="width: 0.875rem; height: 0.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </div>

        <!-- Статус авто-обновления -->
        <div style="display: flex; align-items: center; justify-content: center; gap: 0.375rem;">
            <div style="width: 0.4rem; height: 0.4rem; background: #10b981; border-radius: 50%; animation: pulse 2s infinite;"></div>
            <span style="font-size: 0.7rem; color: var(--chat-muted, #64748b);">Авто-обновление каждые 10 секунд</span>
        </div>

        <style>
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.5; }
            }

            /* Светлая тема по умолчанию */
            :root {
                --chat-bg: #ffffff;
                --chat-header-bg: #f8fafc;
                --chat-input-bg: #ffffff;
                --chat-message-bg: #f1f5f9;
                --chat-border: #e2e8f0;
                --chat-text: #1e293b;
                --chat-muted: #64748b;
                --chat-hover: #f1f5f9;
            }

            /* Темная тема */
            .dark {
                --chat-bg: #1e293b;
                --chat-header-bg: #334155;
                --chat-input-bg: #475569;
                --chat-message-bg: #475569;
                --chat-border: #475569;
                --chat-text: #f1f5f9;
                --chat-muted: #94a3b8;
                --chat-hover: #374151;
            }
        </style>

        <!-- Скрипт для авто-прокрутки -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Прокрутка вниз при загрузке
                setTimeout(() => {
                    const container = document.querySelector('[wire\\:id="{{ $this->getId() }}"] [style*="overflow-y: auto"]');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                }, 100);

                // Авто-обновление
                setInterval(() => {
                    @this.loadMessages();
                }, 5000);

                // Прокрутка после отправки сообщения
                Livewire.hook('message.processed', (message) => {
                    if (message.component.fingerprint.name === 'refund-chat') {
                        setTimeout(() => {
                            const container = document.querySelector('[wire\\:id="{{ $this->getId() }}"] [style*="overflow-y: auto"]');
                            if (container) {
                                container.scrollTop = container.scrollHeight;
                            }
                        }, 100);
                    }
                });
            });
        </script>

    @else
        <!-- Состояние когда возврат не создан -->
        <div style="text-align: center; padding: 1.5rem; color: var(--chat-muted, #64748b); background: var(--chat-bg, white); border: 1px solid var(--chat-border, #e2e8f0); border-radius: 0.5rem;">
            <svg style="width: 2.5rem; height: 2.5rem; margin: 0 auto 0.5rem; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <p style="font-size: 0.8rem; margin: 0;">Чат будет доступен после создания возврата</p>
        </div>
    @endif
</div>
