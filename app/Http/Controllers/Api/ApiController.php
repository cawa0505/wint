<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected function success($data=['msg'=>'操作成功'], $status = 200){
        return response()->json($data, $status);
    }

    protected function error($data=['msg'=>'操作失败'], $status=403){
        return response()->json($data,$status);
    }
}
