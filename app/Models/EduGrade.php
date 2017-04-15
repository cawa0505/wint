<?php

namespace App\Models;


class EduGrade extends EduModel
{
    protected $fillable=['course_id','daily','end_term','daily_proportion','state','teacher_id','credit','grade','user_id','university_id','year','term'];

    //成绩

    /**
     * @param $uid
     *
     * @return array
     */
    public function getAllData ($uid) {
        $where['user_id'] = $uid;
        $where['year']=$this->_year?:'';
        $where['term']=$this->_term?:'';
        $credits = self::where($where)
            ->leftJoin('edu_courses', 'edu_courses.id', '=', 'edu_grades.course_id')
            ->select('edu_grades.*','edu_courses.name as course_name','edu_courses.is_common as course_common','edu_courses.is_required as course_required','edu_courses.code as course_code')
            ->get();

        return $credits->toArray();
    }


    public function saveData ($data) {
        for ($i = 0; $i < count($data); $i++) {
            $grade['course_id']=EduCourse::updateCourse($data[$i]['course_name'], $data[$i]['university_id'],
                null,null,$data[$i]['code']);
            $grade['credit']=$data[$i]['credit'];  //学分
            $grade1['daily']=$data[$i]['daily'];    //平时
            $grade1['end_term']=$data[$i]['end_term'];    //期末
            $grade1['grade']=is_numeric($data[$i]['grade'])?$data[$i]['grade']:strip_tags($data[$i]['grade']);    //成绩
            $grade1['daily_proportion']=$data[$i]['daily_proportion'];    //平时占比
            $grade['year']=$data[$i]['year'];
            $grade['term']=$data[$i]['term']=='春'?'S':'A';
            $grade1['teacher_id']=EduTeacher::updateTeacher($data[$i]['teacher_name'],$data[$i]['university_id']);
            switch ($data[$i]['state']){
                case '':$grade['state']=0;break;
                case '补考':$grade['state']=1;break;
                case '重修':$grade['state']=2;break;
                case '免修':$grade['state']=3;break;
                case '缓考':$grade['state']=4;break;
                default:$grade['state']=0;
            }
            $grade['user_id']=$data[$i]['uid'];
            $result=self::updateOrCreate($grade,$grade1);
            if(!$result)
                return false;
        }
        return true;
    }
}
