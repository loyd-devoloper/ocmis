<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Filament\Tables\Table;
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
                ->state(fn($record) => "$record->fname $record->mname $record->lname"),
                TextColumn::make('username'),
                TextColumn::make('email'),
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
    public function render()
    {
        return view('livewire.admin.users');
    }
}
