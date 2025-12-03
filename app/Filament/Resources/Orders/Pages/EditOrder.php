<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected static ?string $title = 'Просмотр заказа';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Выгрузка')
                ->label('Выгрузка заказа'),
            Action::make('save')
                ->label('Сохранить')
                ->action(function () {
                    $this->save();
                })
                ->color('primary'),
            DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }

    public function fillForm(): void
    {
        $data = $this->record;

        $data['user_email'] = $data->user->email;
        $data['quantity'] = $data->quantity;
        $data['order_status'] = $data->orderStatus;
        $data['total_amount'] = $data->total_amount;
        $data['user_phone'] = $data->user->client->phone;
        $data['user_client_short_name'] = $data->user->client->short_name;

        $this->form->fill($data->toArray());
    }
}
