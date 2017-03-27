<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const STATUS_NORMAL = 0;
    const STATUS_DISABLED = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param $username 用户名，可能是邮箱，手机或普通用户
     * @return mixed
     */
    public function findForPassport($username){
        $where=[];
        if(preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/',$username)){
            $where['email']=$username;
        }elseif(preg_match('/^1[3578]\d{9}$/',$username)){
            $where['phone']=$username;
        }else{
            $where['name']=$username;
        }
        return self::normal()
            ->where($where)
            ->first();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNormal($query){
        return $query->where('status', self::STATUS_NORMAL);
    }


}
