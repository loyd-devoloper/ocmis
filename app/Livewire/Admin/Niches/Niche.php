<?php

namespace App\Livewire\Admin\Niches;

use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Title;

use Filament\Support\Colors\Color;
use Filament\Forms\Components\Grid;
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
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Niche extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Niche::query()->with('buildingInfo'))
            ->headerActions([
                Action::make('create')
                    ->label('Add Niche')
                    ->icon('heroicon-o-plus-circle')
                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::ScreenExtraLarge)

                    ->form([
                       Grid::make([
                        'default'=>2,
                        'sm'=>1,
                        'md'=>2
                       ])->schema([
                        TextInput::make('niche_number')->numeric(),
                        Select::make('building_id')
                        ->label('Building')
                        ->options(\App\Models\Building::all()->pluck('name', 'id')),
                        TextInput::make('capacity')->numeric(),
                        Select::make('level')
                        ->options([
                            'Level 1' => 'Level 1',
                            'Level 2' => 'Level 2',
                            'Level 3' => 'Level 3',
                            'Level 4' => 'Level 4',
                            'Level 5' => 'Level 5',
                            'Level 6' => 'Level 6',
                        ]),
                        TextInput::make('price')->numeric(),
                        FileUpload::make('image')->directory('/niches/niche')->image()->previewable(false),
                        RichEditor::make('description')->columnSpanFull()
                        ->toolbarButtons([

                            'blockquote',
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                       ])
                    ])
                    ->action(function ($data) {
                        \App\Models\Niche::create($data);
                        Notification::make()
                            ->title('Created successfully')
                            ->success()
                            ->send();
                    })
            ])
            ->columns([
                TextColumn::make('id')->searchable(),
                TextColumn::make('buildingInfo.name')->label('Buinding Name')->searchable(),
                TextColumn::make('niche_number'),
                TextColumn::make('capacity'),
                TextColumn::make('status'),
                TextColumn::make('customer_id'),
                TextColumn::make('level'),
                ImageColumn::make('image')->width(100)->height(100),
                TextColumn::make('price'),

            ])

            ->actions([
                EditAction::make('edit')

                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::ExtraLarge)

                    ->form([
                       Grid::make([
                        'default'=>2,
                        'sm'=>1,
                        'md'=>2
                       ])->schema([
                        TextInput::make('niche_number')->numeric(),
                        Select::make('building_id')
                        ->label('Building')
                        ->options(\App\Models\Building::all()->pluck('name', 'id')),
                        TextInput::make('capacity')->numeric(),
                        Select::make('level')
                        ->options([
                            'Level 1' => 'Level 1',
                            'Level 2' => 'Level 2',
                            'Level 3' => 'Level 3',
                            'Level 4' => 'Level 4',
                            'Level 5' => 'Level 5',
                            'Level 6' => 'Level 6',
                        ]),
                        TextInput::make('price')->numeric(),
                        FileUpload::make('image')->directory('/niches/niche')->image()->previewable(false),
                        RichEditor::make('description')->columnSpanFull()
                        ->toolbarButtons([

                            'blockquote',
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                       ])
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
    #[Title('Niche')]
    public function render()
    {
        return view('livewire.admin.niches.niche');
    }
}
