<?php

namespace App\Livewire\Forecast;

use Carbon\Carbon;
use League\Csv\Reader;
use Filament\Widgets\ChartWidget;
use Phpml\Regression\LeastSquares;

class Niche extends ChartWidget
{
    protected static ?string $heading = 'Forecast';
    public $records = '';
    protected function getData(): array
    {

        $niche = \App\Models\Niche::where('id',$this->records)->first();
        $csv = Reader::createFromPath(public_path('Columbarium-Prices.csv'));
        $data = $csv->setHeaderOffset(0)->getRecords();

        $samples = [];
        $targets = [];
        foreach ($data as $row) {

            $samples[] = [(int)$row['Level'], (int)$row['Size']];
            $targets[] = (int)$row['Price'];
        }
        $regression = new LeastSquares();
        $regression->train($samples, $targets);

        $datas = [];
        $labels = [];
        $current_month = Carbon::now();
        $current_month->subMonth();
        $yers = [];

        for ($i = 1; $i <= 24 ; $i++) {

            // $prediction = $regression->predict([[(float)$curentPrice, (int)$property->land_size, (int)$property->floor_area, (int)$property->floor_number]]);
            $l = rand(1, 5);
            $s = rand(1, 5);
            $prediction = $regression->predict([[explode('Level ',$niche->level)[1],explode('Level ',$niche->level)[1]]]);
            // $yers[] = $current_month + $i;



             $labels[] = $current_month->addMonth()->isoFormat('MMMM YYYY');
             $datas[] = isset($prediction[0]) ? ($prediction[0] * ($i / 100)) + $prediction[0] : null;
            // $curentPrice = isset($prediction[0]) ? ($prediction[0] * ($percent / 100)) + $prediction[0] : (float)$property->price;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Forecast',
                    'data' => $datas,
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
