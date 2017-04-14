<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ListClass extends Model
{

    protected $fillable = ['name', 'profession_id', 'college_id'];

    public function UserBasicInfo()
    {
        return $this->hasMany('App\Models\EduUserBasicInfo', 'class_id');
    }

    public function profession()
    {
        return $this->belongsTo('App\Models\ListProfession');
    }

    public static function updateClass($class_name, $profession, $university_id)
    {
        $data['name'] = $class_name;
        $data['profession_id'] = ListProfession::updateProfession($profession, $university_id);
        $result = self::firstOrCreate($data);

        return $result->id;
    }
}
