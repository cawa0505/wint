<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ListClassroom
 *
 * @property int $id
 * @property string $name 教室名
 * @property int $building_id 教学楼名
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListClassroom whereBuildingId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListClassroom whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListClassroom whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListClassroom whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListClassroom whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ListClassroom extends BaseModel
{

    protected $fillable=['id','name','building_id'];

    public function building()
    {
        return $this->belongsTo('App\Models\ListBuilding', 'building_id');
    }

    /**把教室名拆成教学楼名和教室名 拆开哦 记得更新教学楼，这里就先写死了 中文+数字表示教学楼+classroom
     * @param $classroom string
     * @param $university_id integer
     * @return integer
     */
    public static function updateClassroom($classroom, $university_id)
    {
        preg_match('/(.*?)(\d+)/',$classroom,$preg);
        $c['building_id']=ListBuilding::updateBuilding($preg[1],$university_id);
        $c['name']=$preg[2];
        $result=self::firstOrCreate($c);
        if($result)
            return $result->id;
    }
}
