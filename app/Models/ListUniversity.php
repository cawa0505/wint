<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListUniversity extends Model
{
    public function district(){
        return $this->belongsTo('App\Models\ListDistrict');
    }

    public function college(){
        return $this->hasMany('App\Models\ListCollege');
    }
}
