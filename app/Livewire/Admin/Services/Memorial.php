<?php

namespace App\Livewire\Admin\Services;


use Carbon\Carbon;
use Filament\Tables;
use Livewire\Component;
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

class Memorial extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Memorial::query()->with('userInfo'))
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('userInfo.username')->label('User'),

                TextColumn::make('deceased_name'),
                TextColumn::make('message'),
                TextColumn::make('price')->state('10000'),
                TextColumn::make('payment_method'),
                TextColumn::make('date_time')->state(function($record){
                    if($record->own_priest)
                    {
                        $date = Carbon::parse($record->date)->format('F d, Y h:i:s A');
                    }else{
                        $mydate = Carbon::parse($record->schedule?->date)->format('F d, Y');
                        $mytime = Carbon::parse($record->schedule?->start_time)->format('h:i:s A');
                        $date = "$mydate $mytime";
                    }
                    return $date;
                }),
                TextColumn::make('status')->searchable(),
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
            ])
           ;
    }

    public function render(): View
    {
        return view('livewire.admin.services.memorial');
    }
}
