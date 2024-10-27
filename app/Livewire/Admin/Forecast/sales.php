<?php

namespace App\Livewire\admin\forecast;

use Carbon\Carbon;
use Filament\Tables;
use App\Models\Service;
use Livewire\Component;
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
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Exports\Models\Export;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class sales extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\UserService::query()->with(['category', 'userInfo', 'schedule', 'priest'])->where('status', \App\Enums\StatusEnum::Paid->value))
            ->heading('SALES BY SERVICE')
            ->deferFilters()
            ->columns([
                TextColumn::make('id')->label('ID'),


                TextColumn::make('category.name'),
                TextColumn::make('deceasedname')->label('Deceased Name'),
                TextColumn::make('category.price')->label('Price'),
                TextColumn::make('priest')->state(fn($record) => !!$record->priest_id ? $record?->priest?->name : 'Own Priest'),
                TextColumn::make('userInfo.username')->label('User'),
                TextColumn::make('date')

                ->state(function ($record) {
                    if ($record->own_priest) {
                        $date = Carbon::parse($record->date)->format('F d, Y h:i:s A');
                    } else {
                        $mydate = Carbon::parse($record->schedule?->date)->format('F d, Y');
                        $mytime = Carbon::parse($record->schedule?->start_time)->format('h:i:s A');
                        $date = "$mydate $mytime";
                    }
                    return $date;
                })
                ,
                TextColumn::make('payment_method'),
                TextColumn::make('status'),
            ])

            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->required()->rules('required'),
                        DatePicker::make('created_until')->required()->rules('required'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereHas('schedule', function (Builder $query) use ($date) {
                                    $query->whereDate('date', '>=', $date);
                                })->orWhereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereHas('schedule', function (Builder $query) use ($date) {
                                    $query->whereDate('date', '<=', $date);
                                })->orWhereDate('date', '<=', $date)
                            );
                    })
            ])

            ->bulkActions([
                BulkAction::make('PRINT')
                ->label('PRINT')

                ->action(function ($records) {

                    return Redirect::away(route('admin.forecast.print'))->with('records',$records);
                })
                ,

                BulkAction::make('CSV')
                    ->label('CSV')
                    ->action(function ($records) {
                        // Create a new export instance and pass the selected records
                        return Excel::download(new \App\Exports\serviceExport($records->toArray()), 'SALES BY SERVICE.csv', \Maatwebsite\Excel\Excel::CSV, [
                            'Content-Type' => 'text/csv',
                        ]);
                    }),
                BulkAction::make('export')
                    ->label('EXCEL')
                    ->action(function ($records) {
                        // Create a new export instance and pass the selected records
                        return Excel::download(new \App\Exports\serviceExport($records->toArray()), 'SALES BY SERVICE.xlsx');
                    }),


            ]);
    }

    public function render(): View
    {
        return view('livewire.admin.forecast.sales');
    }
}
