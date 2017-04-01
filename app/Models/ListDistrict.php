<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListDistrict extends Model
{
    public function city(){
        return $this->belongsTo('App\Models\ListCity');
    }

    public function university(){
        return $this->hasMany('App\Models\ListUniversity');
    }
}
