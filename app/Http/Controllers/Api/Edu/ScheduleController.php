<?php

namespace App\Http\Controllers\Api\Edu;

use App\Http\Controllers\Api\ApiController;
use App\Models\EduSchedule;
use Illuminate\Http\Request;

class ScheduleController extends ApiController
{

    protected $model;

    public function __construct(){
        $this->model=new EduSchedule();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //先默认拿本学期的，以后再测试
        $result=$this->model->fetch($request->user()->id,'schedule',isset($request->year)?$request->year:null,isset($request->term)?$request->term:null);
        if($result)
           return $this->success($result);
        return $this->error();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EduSchedule  $eduSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $week=null)
    {
        //获取某周课的详情
        $result=$this->model->getByWeek($request->user()->eduBasicInfo->university_id,$week);
        if($result)
            $this->success($result);
        $this->error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EduSchedule  $eduSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(EduSchedule $eduSchedule)
    {
        return $this->success(EduSchedule::destroy($eduSchedule->id));
    }
}
