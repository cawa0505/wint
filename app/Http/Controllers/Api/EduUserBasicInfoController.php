<?php

namespace App\Http\Controllers\Api;

use App\Models\EduUserBasicInfo;
use Illuminate\Http\Request;

class EduUserBasicInfoController extends ApiController
{
    protected $model;

    /**
     * EduUserBasicInfoController constructor.
     */
    public function __construct()
    {
        $this->model=new EduUserBasicInfo();
    }

    //查找绑定关系并返回用户所属直到学校的详情
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $result=$this->model->where('user_id',$request->user()->id)->first();
        if(!$result)
            return $this->error(['msg'=>'没有数据，请绑定']);
        return $this->success($result->toArray());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        if (!empty($request->user()->id)) {
            return $this->success($this->model->bind($request->user()->id,$request->all()));
        }
        return $this->error();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request){
        if (!empty($request->user()->id)){
            return $this->success($this->model->unbind($request->user()->id));
        }
        return $this->error();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request){
        return $this->success($this->model->edit($request->user()->id,$request->all()));
    }

    /**
     * @param Request $request
     */
    public function init(Request $request){
        $result=$this->model->init($request->user()->id);
        if($result['status']==0)
            $this->success(['msg'=>'初始化成功']);
        else
            $this->error($result['msg']);
    }
}
