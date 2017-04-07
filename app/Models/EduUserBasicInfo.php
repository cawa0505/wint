<?php

namespace App\Models;

/**
 * App\Models\EduUserBasicInfo
 *
 * @property int $id
 * @property int $user_id
 * @property string $student_id 学号
 * @property string $real_name 真实姓名
 * @property bool $sex 性别，0男1女
 * @property string $photo_url 皂片
 * @property int $type 0学生，1老师，还没确定要有啥区别为好
 * @property int $class_id 班级
 * @property int $year 入学年份
 * @property string $term 入学学期
 * @property string $user_auth_info 用户授权信息，json数组，不同网站对应不同信息
 * @property string $cookies 用户已登录的session信息，json数组，更新时稍微麻烦一些
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ListClass $classes
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserBasicInfo whereClassId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserBasicInfo whereCookies($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserBasicInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserBasicInfo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserBasicInfo wherePhotoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserBasicInfo whereRealName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserBasicInfo whereSex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserBasicInfo whereStudentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserBasicInfo whereTerm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserBasicInfo whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserBasicInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserBasicInfo whereUserAuthInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EduUserBasicInfo whereUserId($value)
 * @mixin \Eloquent
 */
class EduUserBasicInfo extends BaseModel
{
    protected $fillable = ['name', 'user_id', 'class_id', 'student_id', 'year', 'term', 'user_auth_info', 'cookies','photo_url', 'real_name','sex','type','created_at', 'updated_at'];

    public function classes(){
        return $this->belongsTo('App\Models\ListClass','class_id');
    }

    /**
     * @param $uid integer 用户id
     * @param $info array 该绑定的各种信息
     */
    public function bind($uid,$info){
        $data['user_id']=$uid;
        $temp=self::where($data)->first();
        if($temp){
            return $temp;
        }
        $data['class_id']=$info['class_id'];
        $data['student_id']=$info['student_id'];
        $data['year']=$info['year'];
        $data['term']=$info['term'];
        $data['user_auth_info']=isset($info['user_auth_info'])?json_encode($info['user_auth_info']):'';
        return self::firstOrCreate($data);
    }

    /**
     * @param $uid integer
     * @return int
     */
    public function unbind($uid){
        $temp=self::where(['user_id'=>$uid])->first();
        if($temp)
            return $this->destroy($temp->id);
        return 0;
    }

    /**
     * @param $id integer 原id
     * @param $info array 新信息
     * @return bool
     */
    public function edit($id,$info){
        if($info['user_id'])
            unset($info['user_id']);
        return self::where('id',$id)->update($info);

    }

    /**
     * @param $id integer 用户id
     * 此方法是核心。。获取并初始化用户的所有数据
     */
    public function init($uid){
        //获取本次所用的全部cookie
        $jar=self::login($uid);
        //获取当前年月及学期
        $year=date('Y',time());
        $term=date('m')>1&&date('m'<7)?'S':'A';

    }

    /**
     * @param $uid integer 重新初始化 就是执行init
     */
    public function reInit($uid){
        return $this->init($uid);
    }

}
