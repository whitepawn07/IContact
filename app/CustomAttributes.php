<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class CustomAttributes extends Model
{
    // use SoftDeletes;

    protected $table = 'custom_attributes';
    protected $guarded = [];
    public function contacts()
    {
        return $this->belongsTo(Contacts::class);
    }
}
