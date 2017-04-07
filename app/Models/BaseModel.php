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
        if(!in_array($type,$func)){
            return false;
        }
        return json_decode($university->function_content,true);
    }

    /**
     * @param $uid integer 用户登录，获取cookie
     * @return array status=0成功，1失败并返回失败原因，成功返回cookies为jar对象
     */
    public static function login($uid){
        $edu_user_basic_info=EduUserBasicInfo::where('user_id','=',$uid)->value('university_id');
        $func=self::getFuncInfo($edu_user_basic_info->id,'login');
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
                    $func['params']['category']=>$edu_user_basic_info->category,
                    $func['params']['uid']=>$edu_user_basic_info->uid,
                    $func['params']['password']=>$edu_user_basic_info->password,
                ],
                'allow_redirects'=>false,
                'cookies'=>$jar
            ]);
            if($response->getStatusCode()!='200'){
                return ['status'=>1,'msg'=>'学校服务器出错~'];
            }
            $content=self::dataHanding($response->getBody());
            if(preg_match($func['failed'],$content)||!isset($jar)){
                return ['status'=>1,'msg'=>'用户名密码错误~'];
            }else{
                return ['status'=>0,'cookies'=>$jar];
            }
        }
        else{
            return ['status'=>1,'msg'=>'当前学校不支持该功能~'];
        }
    }

    /** 就是转编码，剔除无用字符串，留下个td tr正则用
     * @param $content string 待处理数据
     * @return mixed
     */
    public static function dataHanding($content){
        return strip_tags(str_replace('&nbsp;','',iconv(mb_detect_encoding($content, ['ASCII','GB2312','GBK','UTF-8']), "utf-8",$content)),'<table>,<td>,<tr>');
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
}