<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Schedule
 *
 * @mixin \Eloquent
 */
class EduSchedule extends EduModel
{
    protected $fillable=['id','course_id','year','term','start_week','end_week','turning','day','time','duration','teacher_id','classroom_id'];
}
