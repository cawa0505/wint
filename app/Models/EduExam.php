<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EduExam
 *
 * @property int            $id
 * @property int            $course_id    课程id
 * @property int            $classroom_id 教室id
 * @property string         $date         考试时间
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
class EduExam extends EduModel
{
    protected $fillable=['course_id','classroom_id','date','start_time','end_time'];

    //考试排表

    /**直接从数据库获取信息，获取所有课表，无论以什么方式，最后获取信息一定是通过fetch，其他接口均为返回数据用的，此处应用联合查询
     *
     * @param $uid  integer
     * @param $year string
     * @param $term string
     *
     * @return array
     */
    public function getAllData ($uid) {
        $where['user_id'] = $uid;
        $where['year'] = $this->_year;
        $where['term'] = $this->_term;
        $exam_ids = EduUserExam::where($where)->pluck('exam_id');
        $exams = EduExam::whereIn('edu_exams.id', $exam_ids)
            ->leftJoin('edu_courses', 'edu_exams.course_id', '=', 'edu_courses.id')
            ->leftJoin('list_classrooms', 'edu_exams.classroom_id', '=', 'list_classrooms.id')
            ->leftJoin('list_buildings', 'edu_exams.building_id', '=', 'list_buildings.id')
            ->select('edu_exams.*', 'edu_courses.name', 'list_classrooms.name as classroom_name', 'list_buildings.name as building_name')
            ->get();

        return $exams->toArray();
    }


    /**上面整合完，在这里批量写入数据库及对应关系以及校验数据准确性
     * Override
     *
     * @param $data
     *
     * @return bool true Or false
     */
    public function saveData ($data) {
        for ($i = 0; $i < sizeof($data); $i++) {
            $exam['course_id'] = EduCourse::updateCourse($data[$i]['course_name'], $data[$i]['university_id']);
            $exam['date'] = $data[$i]['date'];
            $exam['start_time'] = $data[$i]['start_time'];
            $exam['end_time'] = $data[$i]['end_time'];
            $exam['classroom_id'] = isset($data[$i]['classroom']) ? ListClassroom::updateClassroom($data[$i]['classroom'], $data[$i]['university_id']) : '';
            $result = self::firstOrCreate($exam);
            if ($result) {
                EduUserExam::firstOrCreate([
                    'user_id' => $data[$i]['uid'],
                    'exam_id' => $result->id,
                    'year'    => $this->_year,
                    'term'    => $this->_term,
                    'remark'  => $this->remark ?: '',
                ]);
            }
            $exam = NULL;
        }

        return true;
    }

}
