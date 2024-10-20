<?php

namespace App\Livewire\Customer;

use Carbon\Carbon;
use Livewire\Component;

use Filament\Tables\Table;
use App\Models\Shop\Product;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class MyTransaction extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\UserService::query()->with(['category','userInfo','schedule','priest'])->where('user_id',Auth::id())->orderByDesc('id'))
            ->columns([
                TextColumn::make('id'),

                TextColumn::make('category.name'),
                TextColumn::make('category.price'),
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
                Action::make('cancel')
                ->color(Color::Red)
                ->modalWidth(MaxWidth::Medium)
                ->action(function ($data,$record) {
                   $record->update([
                    'status'=>\App\Enums\StatusEnum::Cancelled->value
                   ]);
                    Notification::make()
                        ->title('Updated successfully')
                        ->success()
                        ->send();
                }),

            ])
           ;
    }
    #[Title('My Transaction')]
    public function render()
    {
        return view('livewire.customer.my-transaction');
    }
}
