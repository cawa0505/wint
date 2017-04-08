<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EduUserCourse
 *
 * @property int $id
 * @property int $user_id
 * @property int $schedule_id 课程排表id
 * @property string $year
 * @property string $term
 * @property string $remark 备注
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserCourse whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserCourse whereRemark($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserCourse whereScheduleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserCourse whereTerm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserCourse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserCourse whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserCourse whereYear($value)
 * @mixin \Eloquent
 */
class EduUserCourse extends Model
{
    //
}
