<?php

namespace App\Livewire\Admin\Services;

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

class Category extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Category::query())
            ->headerActions([
                Action::make('create')
                    ->label('Add Category')
                    ->icon('heroicon-o-plus-circle')
                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::Medium)

                    ->form([
                        TextInput::make('name')->label('Category Name'),
                        TextInput::make('price')->numeric(),
                        Select::make('status')
                            ->options([
                              'Active' => 'Active',
                                'InActive' => 'InActive',
                            ])->default('1'),
                            FileUpload::make('image')->directory('/servies/category')->image(),

                    ])
                    ->action(function ($data) {
                        \App\Models\Category::create($data);
                        Notification::make()
                            ->title('Created successfully')
                            ->success()
                            ->send();
                    })
            ])
            ->columns([
                TextColumn::make('id')->searchable(),
                ImageColumn::make('image')->width(100)->height(100),
                TextColumn::make('name')->searchable(),
                TextColumn::make('price'),
                TextColumn::make('status'),
            ])

            ->actions([
                EditAction::make('edit')
                    ->label('Edit')

                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::Medium)

                    ->form([
                        TextInput::make('name')->label('Category Name'),
                        TextInput::make('price')->numeric(),
                        Select::make('status')
                            ->options([
                                'Active' => 'Active',
                                'InActive' => 'InActive',
                            ])->default('1'),
                            FileUpload::make('image')->directory('/servies/category')->image(),

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
    #[Title('Category')]
    public function render()
    {
        return view('livewire.admin.services.category');
    }
}
