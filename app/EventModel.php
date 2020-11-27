<?php

namespace App;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventModel extends Model
{
    use SoftDeletes;

    public $table = 'event_models';
    protected $guarded=[];

    public function dow()
    {
        return $this->hasMany('App\DayOfWeekModel','eventid');
    }


}
