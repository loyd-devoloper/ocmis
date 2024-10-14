<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    use HasFactory;

    protected $fillable = [

        'own_priest',

        'service_id',

        'schedule_id',

        'priest_id',

        'user_id',

        'message',

        'deceasedname',

        'status',

        'date',

        'payment_ref',

    ];

    public function category()
    {
        return $this->hasOne(\App\Models\Category::class, 'id','service_id');
    }
    public function userInfo()
    {
        return $this->hasOne(\App\Models\User::class, 'id','user_id');
    }
    public function schedule()
    {
        return $this->hasOne(\App\Models\PriestSchedule::class, 'id','schedule_id');
    }
    public function priest()
    {
        return $this->hasOne(\App\Models\Priest::class, 'id','priest_id');
    }
}
