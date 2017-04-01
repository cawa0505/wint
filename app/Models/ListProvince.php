<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ListProvince extends Model
{
    public function city(){
        return $this->hasMany('App\Models\ListCity');
    }

}
