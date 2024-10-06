<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Users extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\User::query())
            ->columns([
                TextColumn::make('fullname')
                ->label('Fullname')
                ->state(fn($record) => "$record->fname $record->mname $record->lname")->searchable(['fname','lname','mname']),
                TextColumn::make('username')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('contact')->label('Contact Number'),

                TextColumn::make('address'),

            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
           ;
    }

    #[Title('Users')]
    public function render()
    {
        return view('livewire.admin.users');
    }
}
