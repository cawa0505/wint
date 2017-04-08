<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name 登录用户名
 * @property string $phone
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $last_login_time
 * @property string $last_login_ip
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \App\Models\EduUserBasicInfo $eduBasicInfo
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User normal()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLastLoginTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
     * @param $username string 用户名，可能是邮箱，手机或普通用户
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
     * @param $query User
     * @return mixed
     */
    public function scopeNormal($query){
        return $query->where('status', self::STATUS_NORMAL);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function register($data){
        $username=$data['username'];
        $where=[];
        if(preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/',$username)){
            $where['email']=$username;
        }
        if(preg_match('/^1[3578]\d{9}$/',$username)){
            $where['phone']=$username;
        }
        if(preg_match('/^[A-Za-z_][A-Za-z_0-9]*$/',$username)){
            $where['name']=$username;
        }
        if(!isset($where)){
            return false;
        }
        $where['password']=bcrypt($data['password']);
        return self::create($where);
    }

    public function eduBasicInfo(){
        return $this->hasOne('App\Models\EduUserBasicInfo');
    }

}
