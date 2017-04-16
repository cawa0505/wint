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
            $this->success($result);
        $this->error();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EduSchedule  $eduSchedule
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //先默认拿本学期的，以后再测试
        $result=$this->model->getDetail($id);
        if($result)
            $this->success($result);
        $this->error();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EduSchedule  $eduSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(EduSchedule $eduSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EduSchedule  $eduSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EduSchedule $eduSchedule)
    {
        //
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
