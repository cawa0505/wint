<?php

namespace App\Http\Controllers\Api\Edu;

use App\Http\Controllers\Api\ApiController;
use App\Models\EduCourse;
use Illuminate\Http\Request;

class CourseController extends ApiController
{

    protected $model;

    public function __construct(){
        $this->model=new EduCourse();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //先默认拿本学期的，以后再测试
        $result=$this->model->where('university_id','=',$request->user()->eduBasicInfo->university_id)->get()->toArray();
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
     * @param  \App\Models\EduCourse  $eduCourse
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
     * @param  \App\Models\EduCourse  $eduCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(EduCourse $eduCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EduCourse  $eduCourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EduCourse $eduCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EduCourse  $eduCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy(EduCourse $eduCourse)
    {
        return $this->success(EduCourse::destroy($eduCourse->id));
    }
}
