<?php

namespace App\Models;

class EduSchedule extends EduModel
{
    protected $fillable = ['id', 'course_id', 'year', 'term', 'start_week', 'end_week', 'turning', 'day', 'time', 'duration', 'teacher_id', 'classroom_id'];

    /**直接从数据库获取信息，获取所有课表，无论以什么方式，最后获取信息一定是通过fetchCourse，其他接口均为返回数据用的，此处应用联合查询
     *
     * @param $uid  integer
     * @param $year string
     * @param $term string
     *
     * @return array
     */
    public function getAllData ($uid) {
        $where['user_id'] = $uid;
        $where['year']=$this->year?:'';
        $where['term']=$this->term?:'';
        $schedule_ids = EduUserSchedule::where($where)->pluck('schedule_id');
        $schedules = self::whereIn('edu_schedules.id', $schedule_ids)
            ->leftJoin('edu_courses', 'edu_schedules.course_id', '=', 'edu_courses.id')
            ->leftJoin('edu_teachers', 'edu_schedules.teacher_id', '=', 'edu_teachers.id')
            ->leftJoin('list_classrooms', 'edu_schedules.classroom_id', '=', 'list_classrooms.id')
            ->leftJoin('list_buildings', 'edu_schedules.building_id', '=', 'list_buildings.id')
            ->select('edu_schedules.*', 'edu_courses.name', 'edu_teachers.name as teacher_name', 'list_classrooms.name as classroom_name', 'list_buildings.name as building_name')
            ->get();

        return $schedules->toArray();
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
            $schedule['course_id'] = EduCourse::updateCourse($data[$i]['course_name'], $data[$i]['university_id']);
            $schedule['start_week'] = $data[$i]['start_week'];
            $schedule['end_week'] = $data[$i]['end_week'];
            if ($data[$i]['turning'] == '周') {
                $schedule['turning'] = 0;
            }
            else {
                if ($data[$i]['turning'] == '单周') {
                    $schedule['turning'] = 1;
                }
                else {
                    if ($data[$i]['turning'] == '双周') {
                        $schedule['turning'] = '2';
                    }
                }
            }
            //周几
            $schedule['day'] = $data[$i]['day'];
            //第几节
            $schedule['time'] = $data[$i]['time'];
            //上多久
            $schedule['duration'] = $data[$i]['duration'];
            $schedule['teacher_id'] = isset($data[$i]['teacher_name']) ? EduTeacher::updateTeacher($data[$i]['teacher_name'], $data[$i]['university_id']) : '';
            $schedule['classroom_id'] = isset($data[$i]['classroom']) ? ListClassroom::updateClassroom($data[$i]['classroom'], $data[$i]['university_id']) : '';
            $result = self::firstOrCreate($schedule);
            if ($result) {
                EduUserSchedule::firstOrCreate([
                    'user_id'     => $data[$i]['uid'],
                    'schedule_id' => $result->id,
                    'year'        => $this->year,
                    'term'        => $this->term,
                ]);
            }
            $schedule = NULL;
        }

        return true;
    }

}
