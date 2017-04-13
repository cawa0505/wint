<?php

namespace App\Models;


class EduCredit extends EduModel
{

    protected $fillable = ['course_id', 'credit', 'point', 'user_id', 'university_id'];

    //学分绩点

    /**
     * @param $uid
     *
     * @return array
     */
    public function getAllData ($uid) {
        $where['user_id'] = $uid;
        $credits = self::where($where)
            ->leftJoin('edu_courses', 'edu_courses.id', '=', 'edu_credits.course_id')
            ->select('edu_credits.*', 'edu_courses.name as course_name', 'edu_courses.is_common as course_common', 'edu_courses.is_required as course_required', 'edu_courses.code as course_code')
            ->get();

        return $credits->toArray();
    }

    public function saveData ($data) {
        for ($i = 0; $i < count($data); $i++) {
            $credit['course_id'] = EduCourse::updateCourse($data[$i]['course_name'], $data[$i]['university_id'],
                $data[$i]['is_common'], $data[$i]['is_required
            '], $data[$i]['code']);
            $credit['credit'] = $data[$i]['credit'];
            $credit['grade'] = $data[$i]['grade'];
            $credit['user_id'] = $data[$i]['uid'];
            $result = self::firstOrCreate($credit);
            if (!$result) {
                return false;
            }
        }

        return true;
    }
}
