<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ListCity extends Model
{
    public function province(){
        return $this->belongsTo('App\Models\ListProvince');
    }

    public function district(){
        return $this->hasMany('App\Models\ListDistrict');
    }
}
