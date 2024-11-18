<?php

namespace App\Livewire\Shop;

use Carbon\Carbon;
use App\Models\ShopOrder;
use Filament\Widgets\ChartWidget;

class Daily extends ChartWidget
{
    protected static ?string $heading = 'SALES';


    protected static ?string $maxHeight = '70svh';
    public ?string $filter = 'daily';
    protected function getData(): array
    {
        // Get the selected filter (default to 'daily')
        $filter = $this->filter;

        // Define start and end dates based on the selected filter
        $startDate = Carbon::parse('01-01-2024');
        $endDate = Carbon::now();

        switch ($filter) {
            case 'weekly':
                $startDate->startOfWeek();
                $endDate->endOfWeek();
                break;
            case 'monthly':
                $startDate->startOfMonth();
                $endDate->endOfMonth();
                break;
            case 'yearly':
                $startDate->startOfYear();
                $endDate->endOfYear();
                break;
            case 'annually':
                $startDate->startOfDecade(); // Start from the beginning of the current decade
                $endDate->endOfDecade(); // End at the end of the current decade
                break;
            case 'daily':
            default:
                $startDate->startOfDay();
                $endDate->endOfDay();
                break;
        }

        // Fetch ShopOrder data filtered by status and date range
        $top = ShopOrder::where('status', \App\Enums\StatusEnum::Paid->value)
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->orderBy('updated_at','asc')
            ->get()
            ->groupBy(function ($item) use ($filter) {
                switch ($filter) {
                    case 'weekly':
                        return Carbon::parse($item->updated_at)->format('W Y'); // Group by week number and year
                    case 'monthly':
                        return Carbon::parse($item->updated_at)->format('M Y'); // Group by month and year
                    case 'yearly':
                        return Carbon::parse($item->updated_at)->format('Y'); // Group by year
                    case 'annually':
                        return Carbon::parse($item->updated_at)->format('Y'); // Group by year (same as yearly)
                    case 'daily':
                    default:
                        return Carbon::parse($item->updated_at)->format('M d, Y'); // Group by date
                }
            });

        // Prepare data for the chart
        $labels = [];
        $values = [];
        foreach ($top as $key => $v) {
            // Add the key to the label array
            $labels[] = $key;
            $values[] = $v->sum('total'); // Assuming 'total_paid' is the field you want to sum
        }

        // Initialize date range for the selected period
        // $currentDate = $startDate->copy();
        // while ($currentDate->lte($endDate)) {
        //     $formattedDate = $currentDate->format($filter === 'weekly' ? 'W Y' : ($filter === 'monthly' ? 'M Y' : 'M d, Y'));
        //     $labels[] = $formattedDate; // Add formatted date to labels
        //     $values[] = $top->get($formattedDate, collect())->sum('total'); // Sum total for the corresponding date/group
        //     $currentDate->addDay(); // Increment the date
        // }

        return [
            'datasets' => [
                [
                    'label' => ucfirst($filter) . ' Sales',
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

    protected function getFilters(): ?array
    {
        return [
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
            'annually' => 'Annually',
        ];
    }
    // protected function getData(): array
    // {
    //     //
    //     $top = \App\Models\ShopOrder::where('status',\App\Enums\StatusEnum::Paid->value)->get()->groupBy(function ($item) {
    //         return Carbon::parse($item->created_at)->format('M d, Y'); // Format to 'Y-m-d' to group by date only
    //     });


    //     $label = [];
    //     $data = [];
    //     foreach ($top as $key => $v) {

    //         // Add the key to the label array
    //         $label[] = $key;

    //        $data[] = $v->sum('price');
    //     }

    //     // Define the date range (e.g., last 30 days)
    //     $startDate = Carbon::parse('01-10-2024');
    //     $endDate = Carbon::now();


    //     $dateRange = [];
    //     $currentDate = $startDate->copy();

    //     while ($currentDate->lte($endDate)) {
    //         $dateRange[$currentDate->format('M d, Y')] = 0; // Initialize with 0
    //         $currentDate->addDay();
    //     }

    //     // Merge fetched sales data into the date range array
    //     foreach ($top as $date => $totalSales) {
    //         $dateRange[$date] = $totalSales->sum('total'); // Replace 0 with actual sales count
    //     }

    //     // Prepare data for the chart
    //     $labels = array_keys($dateRange);
    //     $values = array_values($dateRange);

    //     return [
    //         'datasets' => [
    //             [
    //                 'label' =>'Daily Sales',
    //                 'data' => $values,
    //                 'backgroundColor' => [
    //                     'rgb(255, 99, 132)',
    //                     'rgb(54, 162, 235)',
    //                     'rgb(255, 205, 86)'
    //                 ],
    //             ],
    //         ],
    //         'labels' => $labels,

    //     ];
    // }


    protected function getType(): string
    {
        return 'bar';
    }
}
