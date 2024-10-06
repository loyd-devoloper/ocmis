<?php

namespace App\Livewire\Admin\Niches;

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
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Urn extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Urn::query()->with(['nicheInfo'=>function($q){
                $q->with('buildingInfo');
            }]))
            ->headerActions([
                Action::make('create')
                    ->label('Add Urn')
                    ->icon('heroicon-o-plus-circle')
                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::Medium)

                    ->form([

                        Select::make('niche_id')
                            ->label('Building')
                            ->options(function () {
                                $niches =  \App\Models\Niche::with('buildingInfo')->get();
                                $allNiches = [];

                                foreach ($niches as $niche) {
                                    $allNiches[$niche->id] = $niche->buildingInfo?->name . " - " . $niche->level . " - " . $niche->niche_number;
                                }
                                return  $allNiches;
                            }),
                        TextInput::make('urn_number')->numeric(),
                    ])
                    ->action(function ($data) {
                        \App\Models\Urn::create($data);
                        Notification::make()
                            ->title('Created successfully')
                            ->success()
                            ->send();
                    })
            ])
            ->columns([
                TextColumn::make('id')->searchable(),
                TextColumn::make('Niche')->state(function($record){
                    return $record->nicheInfo?->buildingInfo?->name . " - " . $record->nicheInfo?->level . " - " . $record->nicheInfo?->niche_number;
                }),
                TextColumn::make('urn_number'),
            ])

            ->actions([
                EditAction::make('edit')


                ->color(Color::Green)
                ->modalWidth(MaxWidth::Medium)

                ->form([

                    Select::make('niche_id')
                        ->label('Building')
                        ->options(function () {
                            $niches =  \App\Models\Niche::with('buildingInfo')->get();
                            $allNiches = [];

                            foreach ($niches as $niche) {
                                $allNiches[$niche->id] = $niche->buildingInfo?->name . " - " . $niche->level . " - " . $niche->niche_number;
                            }
                            return  $allNiches;
                        }),
                    TextInput::make('urn_number')->numeric(),
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
    #[Title('Urn')]
    public function render()
    {
        return view('livewire.admin.niches.urn');
    }
}
