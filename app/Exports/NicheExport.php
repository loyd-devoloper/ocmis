<?php

namespace App\Exports;

use App\Models\Niche;
use Maatwebsite\Excel\Concerns\FromCollection;

class NicheExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Niche::all();
    }
}
