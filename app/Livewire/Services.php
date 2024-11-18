<?php

namespace App\Livewire;

use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class Services extends ChartWidget
{
    protected static ?string $heading = 'Top Sales';
    protected static ?string $maxHeight = '70svh';

    public ?string $filter = 'daily';

    protected function getData(): array
    {
        // Get the selected filter (default to 'daily')
        $filter = $this->filter;


        // Define start and end dates based on the selected filter
        $startDate = Carbon::now();
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

        // Fetch categories with transaction counts based on the selected time frame
        $top = \App\Models\Category::withCount(['transactions' => function ($q) use ($startDate, $endDate) {
            $q->where('status', \App\Enums\StatusEnum::Paid->value)
                ->whereBetween('created_at', [$startDate, $endDate]); // Filter by date range
        }])->get()->pluck('transactions_count', 'name');

        $label = [];
        $data = [];
        foreach ($top as $key => $v) {
            $label[] = $key;
            $data[] = $v;
        }

        return [
            'datasets' => [
                [
                    'label' => ucfirst($filter) . ' Sales',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                    ],
                ],
            ],
            'labels' => $label,
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
    //     // $top = \App\Models\UserService::with('category')->where('status',\App\Enums\StatusEnum::Paid->value)->get()->groupBy('category.name');
    //     $top = \App\Models\Category::withCount(['transactions' => function ($q) {
    //         $q->where('status', \App\Enums\StatusEnum::Paid->value);
    //     }])->get()->pluck('transactions_count', 'name');
    //     $label = [];
    //     $data = [];
    //     foreach ($top as $key => $v) {
    //         $label[] = $key;
    //         $data[] = $v;
    //     }


    //     return [
    //         'datasets' => [
    //             [
    //                 'label' => 'Blog posts created',
    //                 'data' => $data,
    //                 'backgroundColor' => [
    //                     'rgb(255, 99, 132)',
    //                     'rgb(54, 162, 235)',
    //                     'rgb(255, 205, 86)'
    //                 ],
    //             ],
    //         ],
    //         'labels' => $label,

    //     ];
    // }

    protected function getType(): string
    {
        return 'bar';
    }
}
