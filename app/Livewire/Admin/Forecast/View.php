<?php

namespace App\Livewire\Admin\Forecast;

use Livewire\Component;

class View extends Component
{
    public $niche_id;
    public function mount($niche_id)
    {
        $this->niche_id = $niche_id;
    }
    public function render()
    {
        return view('livewire.admin.forecast.view');
    }
}
