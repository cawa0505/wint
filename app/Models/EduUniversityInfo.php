<?php

namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

/**
 * App\Models\EduUniversityInfo
 *
 * @mixin \Eloquent
 */
class EduUniversityInfo extends BaseModel
{
    /**
     * @param $uid integer 用户登录，获取cookie
     */
    public function login($uid){
        $edu_user_basic_info=EduUserBasicInfo::where('user_id','=',$uid)->value('university_id');
        $func=$this->getFuncInfo($edu_user_basic_info->id,'login');
        if($func){
            $client = new Client();
            $jar = new CookieJar;
            $response = $client->request('POST', $func['url'], [
                'headers'=>[
                    //'Content-Type'=>'application/x-www-form-urlencoded',
                    'User-Agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2970.0 Safari/537.36',
//                    'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
//                    'Accept-Encoding'=>'gzip, deflate',
//                    'Accept-Language'=>'zh-CN,zh;q=0.8',
//                    'Cache-Control'=>'max-age=0',
//                    'Connection'=>'keep-alive',
                    'Content-Type'=>'application/x-www-form-urlencoded',
//                    //'Content-Length'=>'65',
//                    'Host'=>'jxxx.ncut.edu.cn',
//                    'Origin'=>'http://jxxx.ncut.edu.cn',
                    'Referer'=>$func['referer'],
                    //'Upgrade-Insecure-Requests'=>'1',

                ],
                'form_params' => [
                    $func['category']=>$edu_user_basic_info->category,
                    $func['uid']=>$edu_user_basic_info->uid,
                    $func['password']=>$edu_user_basic_info->password,
                ],
                'allow_redirects'=>false,
                'cookies'=>$jar
            ]);
            //TODO 确认登录成功，保存cookie，返回true
        }
    }

    /**
     * @param $university_id integer 学校id
     * @param $type string 所需的信息字符串 哥哥我就不用数字代替了 太累
     * @return bool|array 就是找到的那条信息咯
     */
    public static function getFuncInfo($university_id,$type){
        $university=self::where('university_id','=',$university_id)->first();
        $func=json_decode($university->functions,true);
        if(!in_array($type,$func)){
            return false;
        }
        return $func[$type];
    }
}
