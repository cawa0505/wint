<?php

namespace App\Http\Controllers\Api\Edu;

use App\Http\Controllers\Api\ApiController;
use App\Models\EduUserBasicInfo;
use Illuminate\Http\Request;

class UserBasicInfoController extends ApiController
{
    protected $model;

    /**
     * UserBasicInfoController constructor.
     */
    public function __construct()
    {
        $this->model = new EduUserBasicInfo();
    }

    //查找绑定关系并返回用户所属直到学校的详情

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $result = $this->model->where('user_id', $request->user()->id)->first();
        $result->university;
        $result->classes;
        if (!$result)
            return $this->error(['msg' => '没有数据，请绑定']);
        return $this->success($result->toArray());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (!empty($request->user()->id)) {
            return $this->success($this->model->bind($request->user()->id, $request->all()));
        }
        return $this->error();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        if (!empty($request->user()->id)) {
            return $this->success($this->model->unbind($request->user()->id));
        }
        return $this->error();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        return $this->success($this->model->edit($request->user()->id, $request->all()));
    }

    /**
     * @param Request $request
     */
    public function init(Request $request)
    {
        $result = $this->model->init($request->user()->id);
	if ($result)
            return $this->success();
        else
            return $this->error($result['msg']);
    }
}
