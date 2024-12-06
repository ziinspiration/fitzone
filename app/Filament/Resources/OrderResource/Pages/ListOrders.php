<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Widgets\OrderStats;
use Filament\Actions;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Infolists\Components\Tabs\Tab as TabsTab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return[ 
            OrderStats::class
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            OrderStats::class
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
           'new' => Tab::make()->query(fn ($query) => $query->where('status', 'new')),
           'processing' => Tab::make()->query(fn ($query) => $query->where('status', 'processing')),
           'shipped' => Tab::make()->query(fn ($query) => $query->where('status', 'shipped')),
           'delivered' => Tab::make()->query(fn ($query) => $query->where('status', 'delivered')),
        ];
    }
}
