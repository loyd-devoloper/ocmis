<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\UserService;
use Filament\Widgets\ChartWidget;

class NicheSales extends ChartWidget
{
    protected static ?string $heading = 'Daily Sales';

    protected static ?string $maxHeight = '70svh';
    public ?string $filter = 'daily';


    protected function getData(): array
    {
        // Get the selected filter (default to 'daily')
        $filter = $this->filter;

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
                $startDate->startOfWeek();
                $endDate->endOfWeek();
                break;
            default:
                $startDate->startOfDay();
                $endDate->endOfDay();
                break;
        }

        // Fetch data based on the selected time frame
        $top = \App\Models\Niche::where('status', 'Occupied')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->orderBy('updated_at', 'asc')
            ->get()
            ->groupBy(function ($item) use ($filter) {
                switch ($filter) {
                    case 'weekly':
                        return Carbon::parse($item->updated_at)->format('W Y'); // Group by week number and year
                    case 'monthly':
                        return Carbon::parse($item->updated_at)->format('M Y'); // Group by month
                    case 'yearly':
                        return Carbon::parse($item->updated_at)->format('Y'); // Group by year
                        case 'annually':
                            return Carbon::parse($item->updated_at)->format('Y'); // Group by year (same as yearly)
                    case 'daily':
                    default:
                        return Carbon::parse($item->updated_at)->format('M d, Y'); // Group by date
                }
            });

        $labels = [];
        $values = [];

        foreach ($top as $key => $v) {
            // Add the key to the label array
            $labels[] = $key;
            $values[] = $v->sum('total_paid'); // Assuming 'total_paid' is the field you want to sum
        }

        return [
            'datasets' => [
                [
                    'label' => ucfirst($filter) . ' Sales',
                    'data' => $values,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    // protected function getData(): array
    // {
    //     //
    //     $top = \App\Models\Niche::where('status','Occupied')->get()->groupBy(function ($item) {
    //         return Carbon::parse($item->created_at)->format('M d, Y'); // Format to 'Y-m-d' to group by date only
    //     });


    //     $label = [];
    //     $data = [];
    //     foreach ($top as $key => $v) {

    //         // Add the key to the label array
    //         $label[] = $key;

    //        $data[] = $v->sum('total_paid');
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
    //         $dateRange[$date] = $totalSales->sum('price'); // Replace 0 with actual sales count
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

    protected function getType(): string
    {
        return 'bar';
    }
}
