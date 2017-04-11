<?php

namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

/**
 * App\Models\EduCourse
 *
 * @property int $id
 * @property string $name 课程名
 * @property string $code 课程编码
 * @property int $university_id 开课学校
 * @property bool $is_common 1公共 0专业
 * @property bool $is_required 1必修 0选修
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereUniversityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereIsCommon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereIsRequired($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduCourse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EduCourse extends BaseModel
{

    protected $fillable=['name','university_id','code','is_common','is_required'];

    public static function fetch($uid, $year, $term, $jar = null, $funcType)
    {
        return parent::fetch($uid, $year, $term, $jar, $funcType);
    }

    /**直接从数据库获取信息，获取所有课表，无论以什么方式，最后获取信息一定是通过fetchCourse，其他接口均为返回数据用的，此处应用联合查询
     * @param $uid integer
     * @param $year string
     * @param $term string
     * @return array
     */
    public static function getAllData($uid, $year, $term)
    {
        $where['user_id']=$uid;
        $where['year']=$year;
        $where['term']=$term;
        $schedule_ids=EduUserSchedule::where($where)->pluck('schedule_id');
        $schedules=EduSchedule::whereIn('edu_schedules.id',$schedule_ids)
            ->leftJoin('edu_courses','edu_schedules.course_id','=','edu_courses.id')
            ->leftJoin('edu_teachers','edu_schedules.teacher_id','=','edu_teachers.id')
            ->leftJoin('list_classrooms','edu_schedules.classroom_id','=','list_classrooms.id')
            ->leftJoin('list_buildings','edu_schedules.building_id','=','list_buildings.id')
            ->select('edu_schedules.*','edu_courses.name','edu_teachers.name as teacher_name','list_classrooms.name as classroom_name','list_buildings.name as building_name')->get();
        return $schedules->toArray();
    }


    /**上面整合完，在这里批量写入数据库及对应关系以及校验数据准确性
     * @param $data
     * @return bool true Or false
     */
    public static function saveData($data,$year,$term)
    {
        for($i=0;$i<sizeof($data);$i++){
            $schedule['course_id']=self::updateCourse($data[$i]['course_name']?:'',$data[$i]['university_id']?:'',isset($data[$i]['is_common'])?$data[$i]['is_common']:2,isset($data[$i]['is_required'])?$data[$i]['is_required']:2,isset($data[$i]['is_required'])?$data[$i]['is_required']:2);
            $schedule['start_week']=$data[$i]['start_week'];
            $schedule['end_week']=$data[$i]['end_week'];
            if($data[$i]['turning']=='周')
                $schedule['turning']=0;
            elseif($data[$i]['turning']=='单周')
                $schedule['turning']=1;
            elseif($data[$i]['turning']=='双周')
                $schedule['turning']='2';
            //周几
            $schedule['day']=$data[$i]['day'];
            //第几节
            $schedule['time']=$data[$i]['time'];
            //上多久
            $schedule['duration']=$data[$i]['duration'];
            $schedule['teacher_id']=isset($data[$i]['teacher_name'])?EduTeacher::updateTeacher($data[$i]['teacher_name'],$data[$i]['university_id']):'';
            $schedule['classroom_id']=isset($data[$i]['classroom'])?ListClassroom::updateClassroom($data[$i]['classroom'],$data[$i]['university_id']):'';
            $result=EduSchedule::firstOrCreate($schedule);
            if($result)
                EduUserSchedule::firstOrCreate([
                    'user_id'=>$data[$i]['uid'],
                    'schedule_id'=>$result->id,
                    'year'=>$year,
                    'term'=>$term
                ]);
        }
        return true;
    }

    /**输入课程基本信息，判断数据库里有没有，firstOrCreate
     * @param $name
     * @param $code
     * @param $is_common
     * @param $is_required
     * @param $university_id
     * @return int 课程id
     */
    public function updateCourse($name,$university_id,$is_common,$is_required,$code){
        $data['name']=$name;
        $data['university_id']=$university_id;
        $data['code']=$code;
        $data['is_common']=$is_common;
        $data['is_required']=$is_required;
        $result=EduCourse::firstOrCreate($data);
        if($result)
            return $result->id;
        else
            return false;
    }
}
