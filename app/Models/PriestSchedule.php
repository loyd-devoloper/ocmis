<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriestSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'priest_id',
        'date',
        'start_time',
        'end_time',
        'status'
    ];
}
