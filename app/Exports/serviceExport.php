<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\UserService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class serviceExport implements FromCollection, WithMapping, WithHeadings,ShouldAutoSize
{
    protected $records;

    public function __construct(array $records)
    {

        $this->records = $records;
    }

    public function map($record): array
    {

        if($record['own_priest'])
        {
            $date = Carbon::parse($record['date'])->format('F d, Y h:i:s A');
        }else{
            $mydate = Carbon::parse($record['schedule']['date'])->format('F d, Y');
            $mytime = Carbon::parse($record['schedule']['start_time'])->format('h:i:s A');
            $date = "$mydate $mytime";
        }
        return [
            $record['id'],
            $record['category']['name'],
            $record['category']['price'],
            $record['deceasedname'],
            $date,
            $record['user_info']['username'],
            $record['payment_method'],
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
            'CATEGORY',
            'PRICE',
            'DEACEASED NAME',
            'DATE & TIME',
            'CUSTOMER NAME',
            'PAYMENT_TYPE',
            'STATUS',


        ];
    }
    //    public function collection()
    // {
    //     return UserService::all();
    // }
}
