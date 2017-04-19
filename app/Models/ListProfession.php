<?php

namespace App\Models;


class ListProfession extends BaseModel
{

    protected $fillable=['name','university_id','college_id'];

    public function classes () {
        return $this->hasMany('App\Models\ListClass', 'class_id');
    }

    public function college () {
        return $this->belongsTo('App\Models\ListCollege');
    }

    public static function updateProfession ($profession, $university_id) {
        $data['name'] = $profession;
        $data['university_id'] = $university_id;
        $result = self::firstOrCreate($data);

        return $result->id;

    }
}
