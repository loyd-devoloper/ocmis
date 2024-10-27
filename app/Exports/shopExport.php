<?php

namespace App\Exports;

use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use App\Models\UserService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class shopExport implements  FromCollection, WithMapping, WithHeadings,ShouldAutoSize
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
            $record['name'],
            $record['price'],
            $record['quantity'],
            $date,
            $record['status'],


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
            'PRODUCT NAME',
            'PRICE',
            'QUANTITY',
            'DATE',
            'STATUS',


        ];

    }
}
