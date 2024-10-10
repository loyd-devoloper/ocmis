<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class Services extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?string $maxHeight = '70svh';
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [10],
                    'backgroundColor'=> [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                      ],
                ],
            ],
            'labels' => ['Jan'],

        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
