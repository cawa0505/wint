<?php

namespace App\Models;


class EduGrade extends EduModel
{
    protected $fillable=['course_id','credit','grade','user_id','university_id','year','term'];

    //成绩

    /**
     * @param $uid
     *
     * @return array
     */
    public function getAllData ($uid) {
        $where['user_id'] = $uid;
        $where['year']=$this->year?:'';
        $where['term']=$this->term?:'';
        $credits = self::where($where)
            ->leftJoin('edu_courses', 'edu_courses.id', '=', 'edu_grades.course_id')
            ->select('edu_grades.*','edu_courses.name as course_name','edu_courses.is_common as course_common','edu_courses.is_required as course_required','edu_courses.code as course_code')
            ->get();

        return $credits->toArray();
    }


    public function saveData ($data) {
        for ($i = 0; $i < count($data); $i++) {
            $grade['course_id']=EduCourse::updateCourse($data[$i]['course_name'],$data[$i]['university_id'],
                $data[$i]['is_common'],$data[$i]['is_required
            '],$data[$i]['code']);
            $grade['credit']=$data[$i]['credit'];  //学分
            $grade['daily']=$data[$i]['daily'];    //平时
            $grade['end_term']=$data[$i]['end_term'];    //期末
            $grade['grade']=$data[$i]['grade'];    //成绩
            $grade['daily_proportion']=$data[$i]['daily_proportion'];    //平时占比
            $grade['year']=$data[$i]['year'];
            $grade['term']=$data[$i]['term'];
            $grade['teacher_id']=EduTeacher::updateTeacher($data[$i]['teacher_name'],$data[$i]['university_id']);
            $grade['state']=$data[$i]['state'];
            $grade['user_id']=$data[$i]['uid'];
            $result=self::firstOrCreate($grade);
            if(!$result)
                return false;
        }
        return true;
    }
}
