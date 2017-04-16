<?php

namespace App\Models;


class EduCredit extends EduModel
{

    protected $fillable = ['course_id', 'credit', 'grade', 'user_id', 'university_id', 'remark'];

    //学分绩点

    /**
     * @param $uid
     *
     * @return array
     */
    public function getAllData($uid)
    {
        $where['user_id'] = $uid;
        $credits = self::where($where)
            ->leftJoin('edu_courses', 'edu_courses.id', '=', 'edu_credits.course_id')
            ->select('edu_credits.*', 'edu_courses.name as course_name', 'edu_courses.is_common as course_common', 'edu_courses.is_required as course_required', 'edu_courses.code as course_code')
            ->get();

        return $credits->toArray();
    }

    public function saveData($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $credit1['course_id'] = EduCourse::updateCourse($data[$i]['course_name'], $data[$i]['university_id'],
                $data[$i]['is_common'] == '公共' ? 1 : 2, $data[$i]['is_required'] == '必修' ? 1 : 2, $data[$i]['code']);
            $credit['credit'] = $data[$i]['credit'];
            $credit['grade'] = (isset($data[$i]['grade']) && is_numeric($data[$i]['grade'])) ? $data[$i]['grade'] : NULL;
            $credit1['user_id'] = $data[$i]['uid'];
            $credit['remark'] = $data[$i]['remark'];
            $result = self::updateOrCreate($credit1, $credit);
            if (!$result) {
                return false;
            }
            $credit = NULL;
            $credit1 = NULL;
        }

        return true;
    }


    //获取单个课程的详情
    public function getDetail($id){
        return self::find($id)->toArray();
    }

}
