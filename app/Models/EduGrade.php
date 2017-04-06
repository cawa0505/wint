<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EduGrade
 *
 * @property int $id
 * @property int $course_id
 * @property int $user_id
 * @property string $year
 * @property string $term
 * @property float $grade
 * @property bool $state 类型,0正常,1补考,2重修,3免修
 * @property int $teacher_id
 * @property int $credit 所占学分
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduGrade whereCourseId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduGrade whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduGrade whereCredit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduGrade whereGrade($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduGrade whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduGrade whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduGrade whereTeacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduGrade whereTerm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduGrade whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduGrade whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduGrade whereYear($value)
 * @mixin \Eloquent
 */
class EduGrade extends Model
{
    //
}
