<?php

namespace App\Livewire\Admin\Shop;

use Filament\Tables;
use Livewire\Component;
use App\Models\ShopOrder;
use Filament\Tables\Table;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Transaction extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
        ->query(ShopOrder::query()->with('userInfo'))
            ->columns([
                TextColumn::make('id')->label('#Ref'),

                TextColumn::make('userInfo.username')->label('User')->searchable(['username']),
                TextColumn::make('payment_method'),
                TextColumn::make('status')->searchable(),
                TextColumn::make('created_at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('approved')
                ->color(Color::Green)->icon('heroicon-o-check')
                ->hidden(fn($record) => $record->payment_method == 'Cash' ? false : true)
                ->action(function($record){
                    $record->update(['status' => \App\Enums\StatusEnum::Paid->value]);
                    Notification::make()
                    ->title('Updated successfully')
                    ->success()
                    ->send();
                }),
                Action::make('cancelled')->color(Color::Red)
                ->icon('heroicon-o-x-mark')
                ->hidden(fn($record) => $record->payment_method == 'Cash' || $record->status == \App\Enums\StatusEnum::Paid->value ? false : true)
                ->action(function($record){
                    $record->update(['status' => \App\Enums\StatusEnum::Cancelled->value]);
                    Notification::make()
                    ->title('Updated successfully')
                    ->success()
                    ->send();
                }),
            ]);
    }

    public function render(): View
    {
        return view('livewire.admin.shop.transaction');
    }
}
