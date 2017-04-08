<?php

namespace App\Models;

use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Database\Eloquent\Model;

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
     * @return boolean true成功 false失败
     */
    public static function fetchCourse($uid, $year, $term, $jar = null){
        if($jar){
            //有cookieJar则从教务系统拿数据
            $university=User::find($uid)->eduBasicInfo->university->id;
            $university=json_decode($university->function_content,true);
            $func=$university['course'];
            $data=self::curlData($year,$term,$jar,$func['curl']);
            if($data){
                //获取到数据解析
                $resolvedData=self::resolveData($data,$uid,$func['regex']);
                if($resolvedData){
                    $result=self::saveData($resolvedData);
                    if(!$result)
                        return false;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        return self::getData($uid,$year,$term);
    }

    /**直接从数据库获取信息，无论以什么方式，最后获取信息一定是通过fetchCourse，其他接口均为返回数据用的，此处应用联合查询
     * @param $uid integer
     * @param $year string
     * @param $term string
     */
    public function getData($uid,$year,$term){

    }

    /** 从教学信息网，curl获取原始只经过基本解析的数据
     * @param $year
     * @param $term
     * @param $jar
     */
    public function curlData($year,$term,$jar,$func){

    }

    /**在这里解析 curlData返回回来的数据，处理为标准数组形式，可供直接处理后（补充课程数据等）写入数据库的
     * @param $data string 未经任何具体处理的数据
     * @param $uid
     */
    public function resolveData($data,$uid,$func){

    }

    /**上面整合完，在这里批量写入数据库及对应关系以及校验数据准确性
     * @param $data
     */
    public function saveData($data){

    }
}
