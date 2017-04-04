<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListClass extends Model
{
    public function UserBasicInfo(){
        return $this->hasMany('App\Models\EduUserBasicInfo','class_id');
    }

    public function profession(){
        return $this->belongsTo('App\Models\ListProfession');
    }
}
