<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EduExam
 *
 * @property int $id
 * @property int $course_id 课程id
 * @property int $classroom_id 教室id
 * @property string $date 考试时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduExam whereClassroomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduExam whereCourseId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduExam whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduExam whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduExam whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduExam whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EduExam extends Model
{
    //考试排表
}
