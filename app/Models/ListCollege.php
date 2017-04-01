<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListCollege extends Model
{
    public function university(){
        return $this->belongsTo('App\Models\ListUniversity');
    }

    public function profession(){
        return $this->hasMany('App\Models\ListProfession');
    }
}
