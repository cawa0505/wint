<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EduCredit
 *
 * @property int $id
 * @property int $user_id
 * @property float $credit 学分
 * @property int $course_id 课程id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCredit whereCourseId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCredit whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCredit whereCredit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCredit whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCredit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCredit whereUserId($value)
 * @mixin \Eloquent
 */
class EduCredit extends Model
{
    //
}
