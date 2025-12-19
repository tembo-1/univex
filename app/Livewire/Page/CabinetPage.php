<?php

namespace App\Livewire\Page;

use App\Models\Employee;
use App\Models\Notification;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class CabinetPage extends Component
{
    use WithPagination;

    public string $name;
    public string $id;
    public string $inn;
    public string $phone;
    public string $email;
    public Employee $manager;
    public Collection $notifications;

    public int $page = 1;

    public function mount()
    {
        $this->name     = auth()->user()->client->short_name;
        $this->id       = auth()->id();
        $this->inn      = auth()->user()->client->inn;
        $this->phone    = auth()->user()->client->phone ?? '';
        $this->email    = auth()->user()->email;
        $this->manager = auth()->user()->client->employee;

        $this->loadNotifications();
    }

    public function loadNotifications(): void
    {
        $this->notifications = Notification::query()
            ->where('is_active', true)
            ->where('notification_type_id', 3)
            ->latest()
            ->limit($this->page * 3)
            ->get();
    }

    public function loadMore(): void
    {
        $this->page++;
        $this->loadNotifications();
    }

    public function getHasMoreProperty()
    {
        $query = Notification::query()
            ->where('is_active', true)
            ->where('notification_type_id', 3);

        $total = $query->count();
        $shown = count($this->notifications);

        return $total > $shown;
    }

    public function render()
    {
        return view('livewire.page.cabinet-page', [
            'hasMore' => $this->hasMore,
        ]);
    }
}
