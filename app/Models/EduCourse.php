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

    /**
     * @param $uid integer 用户id
     * @param $year string 年份
     * @param $term string 季节
     * @param null|CookieJar $jar 默认为null，若传过来了jar对象，则从教学系统获取并存入 嗯
     * @return boolean|array 有数据就成功，false就失败了
     */
    public static function fetchCourse($uid, $year, $term, $jar = null)
    {
        if ($jar) {
            //有cookieJar则从教务系统拿数据
            $university = User::find($uid)->eduBasicInfo->classes->profession->college->university;
            $universityInfo=EduUniversityInfo::where('university_id','=',$university->id)->first();
            $func = json_decode($universityInfo->function_content, true);
            $func = $func['course'];
            $data = self::curlData($year, $term, $jar, $func['curl']);
            if ($data) {
                //获取到数据解析
                $resolvedData = self::resolveData($data, $uid, $university->id, $func['regex']);
                if ($resolvedData) {
                    $result = self::saveData($resolvedData,$year,$term);
                    if (!$result)
                        return false;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        return self::getAllData($uid, $year, $term);
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
            ->leftJoin('edu_courses','edu.schedules.course_id','=','edu_courses.id')
            ->leftJoin('edu_teachers','edu_schedules.teacher_id','=','edu_teachers.id')
            ->select('edu_schedules.*','edu_courses.name','edu_teachers.name as teacher_name')->get();
        return $schedules->toArray();
    }

    /** 从教学信息网，curl获取原始只经过基本解析的数据
     * @param $year
     * @param $term
     * @param $jar
     * @param $func
     * @return mixed
     */
    public static function curlData($year, $term, $jar, $func)
    {
        $client = new Client();
        $response = $client->request($func['method'], $func['url'], [
            'form_params' => [
                $func['year']=$year,
                $func['term']=$term,
            ],
            'cookies'=>$jar
        ]);
        if($response->getStatusCode()==200)
            return self::dataHanding($response->getBody());
    }

    /**在这里解析 curlData返回回来的数据，处理为标准数组形式，可供直接处理后（补充课程数据等）写入数据库的
     * @param $data string 未经任何具体处理的数据
     * @param $university_id
     * @param $func
     * @return array 返回解析后的数据，其实还是存不进去的。
     */
    public static function resolveData($data, $uid, $university_id, $func)
    {
        preg_match_all('/'.$func['pattern'].'/',$data,$new);
        $resolved=array();
        for ($j=0;$j<sizeof($new[0]);$j++){
            foreach ($func['order'] as $k=>$v)
                $resolved[$j][$k]=$new[$v][$j];
            $resolved[$j]['uid']=$uid;
            $resolved[$j]['university_id']=$university_id;
        }
        return $resolved;
    }

    /**上面整合完，在这里批量写入数据库及对应关系以及校验数据准确性
     * @param $data
     * @return bool true Or false
     */
    public static function saveData($data,$year,$term)
    {
        for($i=0;$i<sizeof($data);$i++){
            $schedule['course_id']=self::updateCourse($data[$i]['course_name']?:'',$data[$i]['university_id']?:'',$data[$i]['is_common']?:'',$data[$i]['is_common']?:'',$data[$i]['code']?:'');
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
            $schedule['teacher_id']=$data[$i]['teacher_name']?EduTeacher::updateTeacher($data[$i]['teacher_name'],$data[$i]['university_id']):'';
            $schedule['classroom_id']=$data[$i]['classroom']?ListClassroom::updateClassroom($data[$i]['classroom'],$data[$i]['university_id']):'';
            $result=EduSchedule::firstOrCreate($schedule);
            if($result)
                EduSchedule::firstOrCreate([
                    'user_id'=>$data[$i]['uid'],
                    'schedule_id'=>$result->id,
                    'year'=>$year,
                    'term'=>$term
                ]);
        }
        return true;
    }
}
