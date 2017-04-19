<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EduUserSchedule
 *
 * @property int $id
 * @property int $user_id
 * @property int $schedule_id 课程排表id
 * @property string $year
 * @property string $term
 * @property string $remark 备注
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserSchedule whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserSchedule whereRemark($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserSchedule whereScheduleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserSchedule whereTerm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserSchedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserSchedule whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserSchedule whereYear($value)
 * @mixin \Eloquent
 */
class EduUserSchedule extends Model
{
    protected $fillable=['user_id','schedule_id','year','term'];
}
