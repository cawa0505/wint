<?php

namespace App\Models;


/**
 * App\Models\EduTeacher
 *
 * @property int $id
 * @property string $name
 * @property bool $sex 性别
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduTeacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduTeacher whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduTeacher whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduTeacher whereSex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduTeacher whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EduTeacher extends EduModel
{

    protected $fillable=['id','name','university_id'];

    public function university(){
        return $this->belongsTo('App\Models\ListUniversity','university_id');
    }

    /**
     * @param $teacher_name string
     * @param $university_id integer
     */
    public static function updateTeacher($teacher_name, $university_id)
    {
        $data['name']=$teacher_name;
        $data['university_id']=$university_id;
        $result=self::firstOrCreate($data);
        if($result)
            return $result->id;
        else
            return false;
    }
}
