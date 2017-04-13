<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ListClass
 *
 * @property int $id
 * @property string $name
 * @property int $profession_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EduUserBasicInfo[] $UserBasicInfo
 * @property-read \App\Models\ListProfession $profession
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListClass whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListClass whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListClass whereProfessionId($value)
 * @mixin \Eloquent
 */
class ListClass extends Model
{

    public function UserBasicInfo(){
        return $this->hasMany('App\Models\EduUserBasicInfo','class_id');
    }

    public function profession(){
        return $this->belongsTo('App\Models\ListProfession');
    }

    public static function updateClass ($class_name, $profession, $university_id) {
        $data['name']=$class_name;
        $data['profession_id']=ListProfession::updateProfession($profession,$university_id);
        $result=self::firstOrCreate($data);
        return $result->id;
    }
}
