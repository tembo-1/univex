<?php

namespace App\Filament\Resources\MailingCampaigns\Pages;

use App\Filament\Resources\MailingCampaigns\MailingCampaignResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMailingCampaigns extends ListRecords
{
    protected static string $resource = MailingCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
