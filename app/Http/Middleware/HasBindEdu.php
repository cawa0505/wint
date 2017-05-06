<?php

namespace App\Http\Middleware;

use App\Models\EduUserBasicInfo;
use Closure;

/**
 * Created by PhpStorm.
 * User: Li Jian
 * Date: 2017/5/6
 * Time: 14:11
 */
class HasBindEdu
{

    public function handle($request, Closure $next)
    {
        if (!EduUserBasicInfo::where('user_id', '=', \Auth::id())->first())
            return response()->json("还未绑定所在高校的教学系统", 403);
        return $next($request);
    }
}