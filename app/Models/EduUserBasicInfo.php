<?php

namespace App\Models;

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
    }

    /**
     * @param $id integer 原id
     * @param $info array 新信息
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

    }



}
