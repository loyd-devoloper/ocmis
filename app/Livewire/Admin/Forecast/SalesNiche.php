<?php

namespace App\Livewire\admin\forecast;

use Carbon\Carbon;
use Filament\Tables;
use App\Models\Niche;
use Livewire\Component;
use App\Models\OrderItem;
use App\Models\ShopOrder;
use Filament\Tables\Table;

use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;

use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;

use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Contracts\HasTable;

use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Redirect;

use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class SalesNiche extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Niche::query()->where('status', 'Occupied'))
            ->heading('SALES BY NiCHE')
            ->deferFilters()
            ->columns([
                TextColumn::make('id')->searchable(),

                TextColumn::make('buildingInfo.name')->label('Buinding Name')->searchable(),
                TextColumn::make('niche_number'),
                TextColumn::make('capacity'),

                TextColumn::make('status')->searchable(),
                TextColumn::make('customerInfo.username')->searchable(['username']),
                TextColumn::make('level'),
                TextColumn::make('payment_method'),
                TextColumn::make('payment_type'),
                TextColumn::make('plan')->formatStateUsing(fn($state) => "$state Months"),

                TextColumn::make('price')->label('Niche Price'),
                TextColumn::make('price_checkout')->label('Total'),
                TextColumn::make('total_paid')->label('Total Paid'),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date)
                            );
                    })
            ])

            ->actions([
                //
            ])
            ->bulkActions([
                BulkAction::make('PRINT')
                ->label('PRINT')

                ->action(function ($records) {

                    return Redirect::away(route('admin.forecast.printNiche'))->with('records',$records);
                })
                ,

                BulkAction::make('CSV')
                    ->label('CSV')
                    ->action(function ($records) {
                        // Create a new export instance and pass the selected records
                        return Excel::download(new \App\Exports\NicheExport($records->toArray()), 'SALES BY NICHE.csv', \Maatwebsite\Excel\Excel::CSV, [
                            'Content-Type' => 'text/csv',
                        ]);
                    }),
                BulkAction::make('export')
                    ->label('EXCEL')
                    ->action(function ($records) {
                        // Create a new export instance and pass the selected records
                        return Excel::download(new \App\Exports\NicheExport($records->toArray()), 'SALES BY NICHE.xlsx');
                    }),

            ]);
    }
    public function render(): View
    {
        return view('livewire.admin.forecast.sales-niche');
    }
}
