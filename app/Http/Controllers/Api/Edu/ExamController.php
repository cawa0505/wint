<?php

namespace App\Http\Controllers\Api\Edu;

use App\Http\Controllers\Api\ApiController;
use App\Models\EduExam;
use Illuminate\Http\Request;

class ExamController extends ApiController
{

    protected $model;

    public function __construct(){
        $this->model=new EduExam();
    }

    public function index(Request $request)
    {
        //先默认拿本学期的，以后再测试
        $result=$this->model->fetch($request->user()->id,'exam',isset($request->year)?$request->year:null,isset($request->term)?$request->term:null);
        if($result)
            $this->success($result);
        $this->error();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EduExam  $eduExam
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
     * @param  \App\Models\EduExam  $eduExam
     * @return \Illuminate\Http\Response
     */
    public function edit(EduExam $eduExam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EduExam  $eduExam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EduExam $eduExam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EduExam  $eduExam
     * @return \Illuminate\Http\Response
     */
    public function destroy(EduExam $eduExam)
    {
        return $this->success(EduExam::destroy($eduExam->id));
    }
}
