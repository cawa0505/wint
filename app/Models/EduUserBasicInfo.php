<?php

namespace App\Models;

class EduUserBasicInfo extends EduModel
{
    protected $fillable = ['user_id', 'class_id', 'student_id', 'year', 'term', 'user_auth_info', 'cookies', 'photo_url', 'real_name', 'sex', 'type', 'university_id', 'created_at', 'updated_at'];


    public function classes()
    {
        return $this->belongsTo('App\Models\ListClass', 'class_id');
    }


    /**
     * @param $uid  integer 用户id
     * @param $info array 该绑定的各种信息
     */
    public function bind($uid, $info)
    {
        $temp['user_id'] = $uid;
        foreach ($info as $k => $v) {
            if (!$v)
                unset($info[$k]);

        }
        if (isset($info['user_auth_info'])) {
            $info['user_auth_info'] = json_encode($info['user_auth_info']);
        }

        return self::updateOrCreate($temp, $info);
    }

    /**
     * @param $uid integer
     *
     * @return int
     */
    public function unbind($uid)
    {
        $temp = self::where('user_id', '=', $uid)->first();
        if ($temp) {
            return $this->destroy($temp->id);
        }

        return 0;
    }

    /**
     * @param $id   integer 原id
     * @param $info array 新信息
     *
     * @return bool
     */
    public function edit($id, $info)
    {
        if (isset($info['user_id'])) {
            unset($info['user_id']);
        }
        foreach ($info as $k => $v) {
            if (!$v)
                unset($info[$k]);

        }
        if (isset($info['user_auth_info'])) {
            $info['user_auth_info'] = json_encode($info['user_auth_info']);
        }
        return self::where('id', $id)->update($info);

    }

    /**
     * @param $uid integer 用户id
     *             此方法是核心。。获取并初始化用户的所有数据
     */
    public function init($uid)
    {
        //获取当前年月及学期
        $this->_year = date('Y', time());
        $this->_term = date('m') > 1 && date('m' < 8) ? 'S' : 'A';
        //获取本次所用的全部cookies
        $jar = $this->login($uid);
        if ($jar['status'] == 1) {
            return $jar;
        }
        $this->_jar=$jar;
        //首先拿到用户基本信息吧
        $user_basic_info = $this->initData($uid, 'basic_info', $this->_year, $this->_term);
        //最先获取绩点，因为绩点里的信息最全
        $credit = $this->initData($uid, 'credit',  $this->_year, $this->_term);
        //获取课表
        $schedule = $this->initData($uid, 'schedule',  $this->_year, $this->_term);
        //获取成绩
        $grade = $this->initData($uid, 'grade', $this->_year, $this->_term);
        $coursetake = $this->initData($uid, 'coursetake',  $this->_year, $this->_term);
        //$Exam = new EduExam();
        //$exam = $Exam->fetch($uid, 'exam', true, $this->_year, $this->_term);
    }

    /**
     * @param $uid integer 重新初始化 就是执行init
     */
    public function reInit($uid)
    {
        return $this->init($uid);
    }

    /**在这里解析 用户基本信息
     *
     * @param $data string 未经任何具体处理的数据
     * @param $university_id
     * @param $func
     *
     * @return array 返回解析后的数据，其实还是存不进去的。
     */
    public function resolve($data, $uid, $university_id, $func)
    {
        preg_match_all('/' . $func['pattern'] . '/', $data, $new);
        $resolved = [];
        foreach ($func['order'] as $k => $v) {
            $resolved[$k] = $new[1][$v];
        }
        $resolved['user_id'] = $uid;
        $resolved['university_id'] = $university_id;
        //$resolved['photo_url'] = $func['photo_url'];

        return $resolved;
    }

    //保存用户信息
    public function saveData($data)
    {
        $uid=$data['user_id'];
        unset($data['user_id']);
        $bi['student_id'] = $data['student_id'];
        $bi['real_name'] = $data['real_name'];
        $bi['sex'] = $data['sex']=='男'?'1':'2';
        $bi['year'] = $data['year'];
        $bi['term'] = $data['term'] == '春' ? 'S' : 'A';
        $bi['photo_url'] = $this->uploadFile($data['photo_url'] . $data['student_id']);
        $bi['class_id'] = ListClass::updateClass($data['class_name'], $data['profession'], $data['university_id']);
        return self::where('user_id','=',$uid)->update($bi);
    }

    public function getAllData($uid)
    {
        return self::where('user_id','=',$uid)->first()->toArray();
    }


}
