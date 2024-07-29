<?php

namespace App\Filament\Resources\InventoriesResource\Pages;

use App\Filament\Resources\InventoriesResource;
use App\Imports\ContentsImport;
use App\Imports\InventoriesImport;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;
use YOS\FilamentExcel\Actions\Import;

class ListInventories extends ListRecords
{
    protected static string $resource = InventoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Import::make()
            ->import(InventoriesImport::class)
            ->type(\Maatwebsite\Excel\Excel::XLSX)
            ->label('Import Excel')
            ->hint('Upload xlsx type')
            ->icon('heroicon-o-arrow-up-tray')
            ->color('success')
            ->form([
                FileUpload::make('hmm'),
            ])
            ->action(function (array $data) {
                $file = public_path('storage/' . $data['hmm']);
                Excel::import(new InventoriesImport, $file);
                Notification::make()
                ->title('Inventori ter-Import')
                ->success()
                ->send();
            }),
        ];
    }
}
