<?php

namespace App\Livewire\admin\forecast;

use Carbon\Carbon;
use Filament\Tables;
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
use Illuminate\Support\Facades\Redirect;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class SalesShop extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderItem::query()->where('status', \App\Enums\StatusEnum::Paid->value))
            ->heading('SALES BY SHOP')
            ->deferFilters()
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('name')->label('Product Name'),
                TextColumn::make('price'),
                TextColumn::make('quantity'),
                TextColumn::make('created_at')->label('Date')->formatStateUsing(fn($state) => Carbon::parse($state)->format('F d, Y')),
                TextColumn::make('status'),
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

                    return Redirect::away(route('admin.forecast.printshop'))->with('records',$records);
                })
                ,

                BulkAction::make('CSV')
                    ->label('CSV')
                    ->action(function ($records) {
                        // Create a new export instance and pass the selected records
                        return Excel::download(new \App\Exports\shopExport($records->toArray()), 'SALES BY SHOP.csv', \Maatwebsite\Excel\Excel::CSV, [
                            'Content-Type' => 'text/csv',
                        ]);
                    }),
                BulkAction::make('export')
                    ->label('EXCEL')
                    ->action(function ($records) {
                        // Create a new export instance and pass the selected records
                        return Excel::download(new \App\Exports\shopExport($records->toArray()), 'SALES BY SHOP.xlsx');
                    }),

            ]);
    }

    public function render(): View
    {
        return view('livewire.admin.forecast.sales-shop');
    }
}
