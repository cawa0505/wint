<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EduCourse
 *
 * @property int $id
 * @property string $name 课程名
 * @property string $code 课程编码
 * @property int $college_id 开课学院
 * @property bool $is_common 1公共 0专业
 * @property bool $is_required 1必修 0选修
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereCollegeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereIsCommon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereIsRequired($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EduCourse extends Model
{
    //
}
