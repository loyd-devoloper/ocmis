<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ServicePrintTable extends Component
{
    public $records = [];

    public function mount($records)
    {
        $this->records = $records;
    }
    public function render()
    {
        return view('livewire.admin.service-print-table');
    }
}
