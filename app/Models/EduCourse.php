<?php

namespace App\Models;

class EduCourse extends EduModel
{

    protected $fillable = ['name', 'university_id', 'code', 'is_common', 'is_required'];


    /**输入课程基本信息，判断数据库里有没有，updateOrCreate，暂认课程名唯一
     *
     * @param $name
     * @param $code
     * @param $is_common
     * @param $is_required
     * @param $university_id
     *
     * @return int 课程id
     */
    public static function updateCourse ($name, $university_id, $is_common = NULL, $is_required = NULL, $code = NULL) {
        $data['name'] = $name;
        $data['university_id'] = $university_id;
        $data1['code'] = $code ?: '';
        $data1['is_common'] = $is_common ?: '';
        $data1['is_required'] = $is_required ?: '';
        if (!$data1['code']) {
            unset($data1['code']);
        }
        if (!$data1['is_common']) {
            unset($data1['is_common']);
        }
        if (!$data1['is_required']) {
            unset($data1['is_required']);
        }
        if ($data1) {
            $result = self::updateOrCreate($data, $data1);
        }
        else {
            $result = self::create($data);
        }
        if ($result) {
            return $result->id;
        }
        else {
            return false;
        }
    }
}
