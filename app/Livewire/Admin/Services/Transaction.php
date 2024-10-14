<?php

namespace App\Livewire\Admin\Services;

use Carbon\Carbon;
use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Filament\Actions\CreateAction;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Transaction extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\UserService::query()->with(['category','userInfo','schedule','priest']))


            ->columns([
                TextColumn::make('id'),

                TextColumn::make('category.name'),
                TextColumn::make('priest')->state(fn($record) => !!$record->priest_id ? $record?->priest?->name : 'Own Priest'),
                TextColumn::make('userInfo.username')->label('User')->searchable(['username']),
                TextColumn::make('date')->state(function($record){
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
                EditAction::make('change_status')


                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::Medium)

                    ->form([

                        Select::make('status')
                            ->options(\App\Enums\StatusEnum::class),


                    ])
                    ->action(function ($data,$record) {
                       $record->update($data);
                        Notification::make()
                            ->title('Updated successfully')
                            ->success()
                            ->send();
                    }),

            ])
        ;
    }
    #[Title('Category')]
    public function render()
    {
        return view('livewire.admin.services.transaction');
    }
}
