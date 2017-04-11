<?php

namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BaseModel
 *
 * @mixin \Eloquent
 */
class BaseModel extends Model{

    /**
     * @param $university_id integer 学校id
     * @param $type string 所需的信息字符串 哥哥我就不用数字代替了 太累
     * @return bool|array 就是找到的那条信息咯
     */
    public static function getFuncInfo($university_id,$type){
        $university=EduUniversityInfo::where('university_id','=',$university_id)->first();
        $func=json_decode($university->function_list,true);
        if(!array_key_exists($type,$func)){
            return false;
        }
        $result=json_decode($university->function_content,true);
        return $result[$type];
    }

    /**
     * @param $uid integer 用户登录，获取cookie
     * @return array status=0成功，1失败并返回失败原因，成功返回cookies为jar对象
     */
    public static function login($uid){
        $edu_user_basic_info=EduUserBasicInfo::where('user_id','=',$uid)->first();
        $params=json_decode($edu_user_basic_info->user_auth_info);
        $func=self::getFuncInfo($edu_user_basic_info->classes->profession->college->university_id,'login');
        if($func){
            $client = new Client();
            $jar = new CookieJar;
            $response = $client->request('POST', $func['url'], [
                'headers'=>[
                    //以后需要再添加
                    'User-Agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2970.0 Safari/537.36',
                    'Content-Type'=>'application/x-www-form-urlencoded',
                    'Referer'=>$func['referer'],
                ],
                'form_params' => [
                    $func['params']['category']=>$params->category,
                    $func['params']['uid']=>$params->uid,
                    $func['params']['password']=>$params->password,
                ],
                'allow_redirects'=>true,
                'cookies'=>$jar
            ]);
            if($response->getStatusCode()!='200'){
                return ['status'=>1,'msg'=>'学校服务器出错~'];
            }
            $content=self::dataHanding($response->getBody());
            if(preg_match('/'.$func['failed'].'/',$content)||!isset($jar)){
                return ['status'=>1,'msg'=>'用户名密码错误~'];
            }else{
                return ['status'=>0,'cookies'=>$jar];
            }
        }
        else{
            return ['status'=>1,'msg'=>'当前学校不支持该功能~'];
        }
    }

    /** 就是转编码，剔除无用字符串
     * @param $content string 待处理数据
     * @return mixed
     */
    public static function dataHanding($content){
        return str_replace('&nbsp;','',iconv(mb_detect_encoding($content, ['ASCII','GB2312','GBK','UTF-8']), "utf-8",$content));
    }

    /**
     * @param $university_id integer 学校id
     * @return array 第一个值是第几周 第二个值 1单2双
     */
    public function whichWeek($university_id){
        $new_term=EduUniversityInfo::where('university_id','=',$university_id)->value('new_term');
        $today=time();
        $yesterday=strtotime($new_term);
        $second=(int)$today-(int)$yesterday;
        $day=(int)($second/86400);
        $week=$day/7;
        $whichDay=date("w");
        if((int)$whichDay/2==0)
            $sex=2;
        else
            $sex=1;
        return ['day'=>$week,'type'=>$sex];
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