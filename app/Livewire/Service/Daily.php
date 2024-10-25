<?php

namespace App\Livewire\Service;

use Carbon\Carbon;
use App\Models\UserService;
use Filament\Widgets\ChartWidget;

class Daily extends ChartWidget
{
    protected static ?string $heading = 'Daily Sales';

    protected static ?string $maxHeight = '70svh';
    protected function getData(): array
    {
        //
        $top = UserService::with('category')->where('status',\App\Enums\StatusEnum::Paid->value)->get()->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('M d, Y'); // Format to 'Y-m-d' to group by date only
        });


        $label = [];
        $data = [];
        foreach ($top as $key => $v) {

            // Add the key to the label array
            $label[] = $key;

           $data[] = $v->sum('price');
        }

        // Define the date range (e.g., last 30 days)
        $startDate = Carbon::parse('01-10-2024');
        $endDate = Carbon::now();


        $dateRange = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dateRange[$currentDate->format('M d, Y')] = 0; // Initialize with 0
            $currentDate->addDay();
        }

        // Merge fetched sales data into the date range array
        foreach ($top as $date => $totalSales) {
            $dateRange[$date] = $totalSales->sum('price'); // Replace 0 with actual sales count
        }

        // Prepare data for the chart
        $labels = array_keys($dateRange);
        $values = array_values($dateRange);

        return [
            'datasets' => [
                [
                    'label' =>'Daily Sales',
                    'data' => $values,
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                ],
            ],
            'labels' => $labels,

        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
