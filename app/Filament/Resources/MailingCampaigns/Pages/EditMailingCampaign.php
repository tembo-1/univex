<?php

namespace App\Filament\Resources\MailingCampaigns\Pages;

use App\Filament\Resources\MailingCampaigns\MailingCampaignResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMailingCampaign extends EditRecord
{
    protected static string $resource = MailingCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
