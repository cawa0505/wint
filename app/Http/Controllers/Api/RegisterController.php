<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use SmsManager;
use Validator;

class RegisterController extends ApiController
{
    public function register(Request $request){
        $this->validateCode($request->all());
        return $this->insertData($request->all());
    }

    protected function validateCode(array $data){
        //验证数据
        Validator::make($data, [
            'mobile'     => 'required|confirm_mobile_not_change|confirm_rule:mobile_required|unique:users,phone',
            'verifyCode' => 'required|verify_code',
            'password'  => 'required|min:6',
        ],[
            'mobile.required'=>'请填写手机号码！',
            'mobile.confirm_rule'=>'请填写正确的中国大陆手机号码！',
            'mobile.confirm_mobile_not_change'=>'请与发送验证码时填写的手机一致',
            'mobile.unique'=>'手机号已被注册，请直接登录',
            'verifyCode.verify_code'=>'验证码错误',
            'verifyCode.required'=>'请填写验证码',
            'password.required'=>'请填写密码！',
            'password.min'=>'密码长度必须大于6位！'
        ])->validate();
        SmsManager::forgetState();
    }

    protected function insertData(array $data){
        return User::create([
            'phone'=>$data['mobile'],
            'password'=>bcrypt($data['password']),
        ]);
    }

}
