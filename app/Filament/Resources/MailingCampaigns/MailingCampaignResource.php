<?php

namespace App\Filament\Resources\MailingCampaigns;

use App\Filament\Resources\MailingCampaigns\Pages\CreateMailingCampaign;
use App\Filament\Resources\MailingCampaigns\Pages\EditMailingCampaign;
use App\Filament\Resources\MailingCampaigns\Pages\ListMailingCampaigns;
use App\Filament\Resources\MailingCampaigns\Schemas\MailingCampaignForm;
use App\Filament\Resources\MailingCampaigns\Tables\MailingCampaignsTable;
use App\Models\MailingCampaign;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MailingCampaignResource extends Resource
{
    protected static ?string $model = MailingCampaign::class;
    protected static string|null|UnitEnum $navigationGroup = 'Рассылки';
    protected static ?string $navigationLabel = 'Почтовые рассылки';
    protected static ?string $modelLabel = 'Почтовую рассылку';
    protected static ?string $pluralModelLabel = 'Почтовые рассылки';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'MailingCampaign';

    public static function form(Schema $schema): Schema
    {
        return MailingCampaignForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MailingCampaignsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMailingCampaigns::route('/'),
            'create' => CreateMailingCampaign::route('/create'),
            'edit' => EditMailingCampaign::route('/{record}/edit'),
        ];
    }
}
