<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class Services extends ChartWidget
{
    protected static ?string $heading = 'Top Sales';
    protected static ?string $maxHeight = '70svh';
    protected function getData(): array
    {
        // $top = \App\Models\UserService::with('category')->where('status',\App\Enums\StatusEnum::Paid->value)->get()->groupBy('category.name');
        $top = \App\Models\Category::withCount(['transactions' => function ($q) {
            $q->where('status', \App\Enums\StatusEnum::Paid->value);
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
                    'label' => 'Blog posts created',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                ],
            ],
            'labels' => $label,

        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
