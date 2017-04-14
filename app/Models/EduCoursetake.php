<?php

namespace App\Models;

class EduCoursetake extends EduModel
{


    protected $fillable = ['course_id', 'user_id', 'state', 'year', 'term', 'remark', 'university_id'];

    //学分绩点

    /**
     * @param $uid
     *
     * @return array
     */
    public function getAllData ($uid) {
        $where['user_id'] = $uid;
        $where['year'] = $this->_year ?: '';
        $where['term'] = $this->_term ?: '';
        $credits = self::where($where)
            ->leftJoin('edu_courses', 'edu_courses.id', '=', 'edu_coursetakes.course_id')
            ->select('edu_coursetakes.*', 'edu_courses.name as course_name', 'edu_courses.is_common as course_common',
                'edu_courses.is_required as course_required', 'edu_courses.code as course_code')
            ->get();

        return $credits->toArray();
    }

    /**在这里解析 curlData返回回来的数据，处理为标准数组形式，可供直接处理后（补充课程数据等）写入数据库的
     *
     * @param $data string 未经任何具体处理的数据
     * @param $university_id
     * @param $func
     *
     * @return array 返回解析后的数据，其实还是存不进去的。
     */
    public function resolve ($data, $uid, $university_id, $func) {
        preg_match_all('/' . $func['pattern'] . '/', $data, $new);
        $resolved = [];
        for ($j = 0; $j < sizeof($new[0]); $j++) {
            foreach ($func['order'] as $k => $v)
                $resolved[$j][$k] = $new[$v][$j];
            $resolved[$j]['uid'] = $uid;
            $resolved[$j]['university_id'] = $university_id;
            $resolved[$j]['year'] = $this->_year;
            $resolved[$j]['term'] = $this->_term;
        }

        return $resolved;
    }

    public function saveData ($data) {
        for ($i = 0; $i < count($data); $i++) {
            $coursetake['course_id'] = EduCourse::updateCourse($data[$i]['course_name'], $data[$i]['university_id'],
                $data[$i]['is_common'], $data[$i]['is_required
            '], $data[$i]['code']);
            $coursetake['remark'] = $data[$i]['remark'];
            $coursetake['state'] = $data[$i]['state'];
            $coursetake['user_id'] = $data[$i]['uid'];
            $coursetake['year'] = $data[$i]['year'];
            $coursetake['term'] = $data[$i]['term'];
            $result = self::firstOrCreate($coursetake);
            if (!$result) {
                return false;
            }
        }

        return true;
    }
}
