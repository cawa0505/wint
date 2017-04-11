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

    protected $year;
    protected $term;

    /**
     * @param $university_id integer 学校id
     * @param $type string 所需的信息字符串 哥哥我就不用数字代替了 太累
     * @return bool|array 就是找到的那条信息咯
     */
    public function getFuncInfo($university_id,$type){
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
    public function login($uid){
        $edu_user_basic_info=EduUserBasicInfo::where('user_id','=',$uid)->first();
        $params=json_decode($edu_user_basic_info->user_auth_info);
        $func=$this->getFuncInfo($edu_user_basic_info->classes->profession->college->university_id,'login');
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
            $content=$this->handing($response->getBody());
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

    /**
     * @param $uid integer 用户id
     * @param $year string 年份
     * @param $term string 季节
     * @param null|CookieJar $jar 默认为null，若传过来了jar对象，则从教学系统获取并存入 嗯
     * @return boolean|array 有数据就成功，false就失败了
     */
    public function fetch($uid, $year, $term, $jar = null,$funcType)
    {
        $this->term=$term;
        $this->year=$year;
        if ($jar) {
            //有cookieJar则从教务系统拿数据
            $university = User::find($uid)->eduBasicInfo->classes->profession->college->university;
            $universityInfo=EduUniversityInfo::where('university_id','=',$university->id)->first();
            $func = json_decode($universityInfo->function_content, true);
            $func = $func[$funcType];
            $data = $this->curl($jar, $func['curl']);
            if ($data) {
                //获取到数据解析
                $resolvedData = $this->resolve($data, $uid, $university->id, $func['regex']);
                if ($resolvedData) {
                    $result = $this->saveData($resolvedData);
                    if (!$result)
                        return false;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        return $this->getAllData($uid);
    }

    public function curl($jar,$func){
        $client = new Client();
        $response = $client->request($func['method'], $func['url'], [
            'form_params' => [
                $func['year']=$this->year,
                $func['term']=$this->term,
            ],
            'cookies'=>$jar
        ]);
        if($response->getStatusCode()==200)
            return $this->handing($response->getBody());
    }

    /**在这里解析 curlData返回回来的数据，处理为标准数组形式，可供直接处理后（补充课程数据等）写入数据库的
     * @param $data string 未经任何具体处理的数据
     * @param $university_id
     * @param $func
     * @return array 返回解析后的数据，其实还是存不进去的。
     */
    public function resolve($data, $uid, $university_id, $func)
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

    /** 就是转编码，剔除无用字符串
     * @param $content string 待处理数据
     * @return mixed
     */
    public function handing($content){
        return str_replace('&nbsp;','',iconv(mb_detect_encoding($content, ['ASCII','GB2312','GBK','UTF-8']), "utf-8",$content));
    }

    public function getAllData($uid){

    }

    public function saveData($data){

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