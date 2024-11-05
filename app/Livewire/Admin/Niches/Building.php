<?php

namespace App\Livewire\Admin\Niches;

use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Filament\Actions\CreateAction;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Building extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Building::query())
            ->headerActions([
                Action::make('create')
                    ->label('Add Building')
                    ->icon('heroicon-o-plus-circle')
                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::Medium)

                    ->form([
                        TextInput::make('name'),
                        FileUpload::make('image')->directory('/niches/building')->image(),
                    ])
                    ->action(function ($data) {
                        \App\Models\Building::create($data);
                        Notification::make()
                            ->title('Created successfully')
                            ->success()
                            ->send();
                    })
            ])
            ->columns([
                // TextColumn::make('id')->searchable(),
                TextColumn::make('name')->searchable(),
                ImageColumn::make('image')->width(100)->height(100)

            ])

            ->actions([
                EditAction::make('edit')
                ->label('Edit')

                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::Medium)

                    ->form([
                        TextInput::make('name'),
                        FileUpload::make('image')->directory('/niches/building')->image(),
                    ])
                    ->action(function ($data,$record) {
                        $record->update($data);
                        Notification::make()
                            ->title('Updated successfully')
                            ->success()
                            ->send();
                    }),
                DeleteAction::make()
            ])
        ;
    }
    #[Title('Buildings')]
    public function render()
    {
        return view('livewire.admin.niches.building');
    }
}
