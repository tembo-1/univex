<?php

namespace App\Livewire;

use App\Models\Refund;
use App\Models\RefundConversation;
use Livewire\Component;

class RefundChat extends Component
{
    public Refund $refund; // Текущий возврат
    public string $newMessage = ''; // Новое сообщение
    public $conversations = []; // Все сообщения

    // Инициализация при загрузке компонента
    public function mount(?Refund $record = null)
    {
        $this->refund = $record;

        if ($this->refund) {
            $this->loadMessages();
        }
    }

    // Загрузка всех сообщений для этого возврата
    public function loadMessages()
    {
        if (!$this->refund) return;

        $this->conversations = $this->refund->refundConversations()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function sendMessage()
    {
        if (!$this->refund) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Сначала сохраните возврат!'
            ]);
            return;
        }

        $this->validate([
            'newMessage' => 'required|min:1|max:1000'
        ]);

        RefundConversation::create([
            'refund_id' => $this->refund->id,
            'user_id' => auth()->id(),
            'message' => $this->newMessage
        ]);

        $this->newMessage = '';
        $this->loadMessages();

        // Уведомление об успехе
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Сообщение отправлено!'
        ]);
    }

    // Ручное обновление сообщений
    public function refreshMessages()
    {
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.refund-chat');
    }
}
