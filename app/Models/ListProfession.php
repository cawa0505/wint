<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListProfession extends Model
{
    public function classes(){
        return $this->hasMany('App\Models\ListClass','class_id');
    }

    public function college(){
        return $this->belongsTo('App\Models\ListCollege');
    }
}
