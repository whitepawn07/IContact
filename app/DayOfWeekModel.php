<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayOfWeekModel extends Model
{

    use SoftDeletes;

    public $table = 'day_of_week_models';
    protected $guarded=[];
    public function event()
    {
    return $this->belongsTo('App\EventModel','eventid');
    }
}
