<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'pid',
        'full_name',
        'position_id',
        'employment_start',
        'salary',
        'photo'
    ];

    public $timestamps = false;

    public function position()
    {
        return $this->belongsTo('App\Position');
    }
}
