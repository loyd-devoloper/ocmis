<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\UserService;
use Filament\Widgets\ChartWidget;

class NicheSales extends ChartWidget
{
    protected static ?string $heading = 'Daily Sales';
    protected static ?string $pollingInterval = null;


    protected static ?string $maxHeight = '70svh';
    public ?string $filter = 'daily';
    private array $colors = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 99, 132, 0.5)',
        'rgba(54, 162, 235, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(75, 192, 192, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)',
        'rgba(255, 99, 132, 0.8)',
        'rgba(54, 162, 235, 0.8)',
        'rgba(255, 206, 86, 0.8)',
        'rgba(75, 192, 192, 0.8)',
        'rgba(153, 102, 255, 0.8)',
        'rgba(255, 159, 64, 0.8)',
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
    ];

    protected function getData(): array
    {
        // Get the selected filter (default to 'daily')
        $filter = $this->filter;

        $startDate = Carbon::parse('01-01-2024');
        $endDate = Carbon::parse('03-12-2025');
//        $endDate = Carbon::now();

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

        $datasets = [];
        $labels = array_keys($top->toArray());
        $colorCount = count($this->colors);
        foreach ($top as $date => $niches) {
            foreach ($niches as $niche) {
                $buildingId = $niche->building_id;
                $totalPaid = $niche->total_paid; // Get the total_paid for the niche

                // Initialize dataset for building_id if not exists
                if (!isset($datasets[$buildingId])) {
                    $datasets[$buildingId] = [
                        'label' => 'Building ' . $buildingId,
                        'data' => array_fill(0, count($labels), 0), // Initialize data array
                        'backgroundColor' => $this->colors[count($datasets) % $colorCount],
                            'borderColor' => 'rgba(0, 0, 0, 1)',
                        'borderWidth' => 1,
                    ];
                }

                // Increment the total_paid for the specific date
                $dateIndex = array_search($date, $labels);
                if ($dateIndex !== false) {
                    $datasets[$buildingId]['data'][$dateIndex] += $totalPaid; // Sum the total_paid
                }
            }
        }

        // Convert datasets to array
        $datasets = array_values($datasets);

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }


    private function randomColor(): string
    {
        $r = rand(0, 255);
        $g = rand(0, 255);
        $b = rand(0, 255);
        $a = 0.2; // Set alpha for transparency
        return "rgba($r, $g, $b, $a)";
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

    protected function getType(): string
    {
        return 'bar';
    }
}
