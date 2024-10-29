<?php

namespace App\Exports;

use App\Models\Niche;

use Carbon\Carbon;
use App\Models\UserService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NicheExport implements FromCollection, WithMapping, WithHeadings,ShouldAutoSize
{
    protected $records;

    public function __construct(array $records)
    {

        $this->records = $records;
    }

    public function map($record): array
    {

            $date = Carbon::parse($record['created_at'])->format('F d, Y');

        return [
            $record['id'],
            $record['building_info']['name'],
            $record['niche_number'],
            $record['level'],
            $record['status'],
            $record['customer_info']['username'],
            $record['price'],
            $record['total_paid'],


        ];
    }
    public function collection()
    {
        // Return the collection of records
        return collect($this->records);
    }

    public function headings(): array
    {
        return [
            'ID',
            'BUILDING NAME',
            'NICHE NUMBER',
            'LEVEL',
            'STATUS',
            'CUSTOMER',
            'PRICE',
            'TOTAL PAID',


        ];

    }
}
