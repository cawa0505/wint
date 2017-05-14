<?php

namespace App\Models;

class EduCoursetake extends EduModel
{


    protected $fillable = ['course_id', 'user_id', 'state', 'year', 'term', 'credit', 'remark', 'university_id', 'start_week', 'end_week'];

    //学分绩点

    /**
     * @param $uid
     *
     * @return array
     */
    public function getAllData($uid)
    {
        $where['user_id'] = $uid;
        if(isset($this->_year))
		$where['year'] = $this->_year ?: '';
        if(isset($this->_term))
		$where['term'] = $this->_term ?: '';
        $credits = self::where($where)
            ->leftJoin('edu_courses', 'edu_courses.id', '=', 'edu_coursetakes.course_id')
            ->select('edu_coursetakes.*', 'edu_courses.name as course_name', 'edu_courses.is_common as course_common',
                'edu_courses.is_required as course_required', 'edu_courses.code as course_code')
            ->get();

        return $credits;
    }


    public function saveData($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $coursetake['course_id'] = EduCourse::updateCourse($data[$i]['course_name'], $data[$i]['university_id'],
                $data[$i]['is_common']=='公共'?1:2, $data[$i]['is_required']=='必修'?1:2, $data[$i]['code']);
            $coursetake1['state'] = $data[$i]['state']=='中签'?1:2;
            $coursetake['user_id'] = $data[$i]['uid'];
            $coursetake['year'] = isset($data[$i]['year'])?$data[$i]['year']:$this->_year;
            $coursetake['term'] = isset($data[$i]['term'])?$data[$i]['term']:$this->_term;
            $coursetake1['start_week'] = $data[$i]['start_week'];
            $coursetake1['end_week'] = $data[$i]['end_week'];
            $coursetake1['credit'] = $data[$i]['credit'];

            $result = self::updateOrCreate($coursetake,$coursetake1);
            if (!$result) {
                return false;
            }
        }

        return true;
    }


    //获取单个课程的详情
    public function getDetail($id)
    {
        return self::find($id)->toArray();
    }
}
