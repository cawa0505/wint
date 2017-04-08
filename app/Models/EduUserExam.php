<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EduUserExam
 *
 * @property int $id
 * @property int $user_id
 * @property int $exam_id
 * @property string $year 年份
 * @property string $term 季别
 * @property string $remark
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserExam whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserExam whereExamId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserExam whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserExam whereRemark($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserExam whereTerm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserExam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserExam whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserExam whereYear($value)
 * @mixin \Eloquent
 */
class EduUserExam extends Model
{
    //
}
