<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\HasMany;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Contacts extends Model
{   
    // use SoftDeletes;
    
    protected $table = 'contacts';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customAttributes()
    {
        return $this->hasMany('App\CustomAttributes', 'contact_id');
    }
}
