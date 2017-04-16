<?php

namespace App\Http\Controllers\Api\Edu;

use App\Http\Controllers\Api\ApiController;
use App\Models\EduGrade;
use Illuminate\Http\Request;

class GradeController extends ApiController
{

    protected $model;

    public function __construct(){
        $this->model=new EduGrade();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //先默认拿本学期的，以后再测试
        $result=$this->model->fetch($request->user()->id,'grade',isset($request->year)?$request->year:null,isset($request->term)?$request->term:null);
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
     * @param  \App\Models\EduGrade  $eduGrade
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
     * @param  \App\Models\EduGrade  $eduGrade
     * @return \Illuminate\Http\Response
     */
    public function edit(EduGrade $eduGrade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EduGrade  $eduGrade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EduGrade $eduGrade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EduGrade  $eduGrade
     * @return \Illuminate\Http\Response
     */
    public function destroy(EduGrade $eduGrade)
    {
        return $this->success(EduGrade::destroy($eduGrade->id));
    }
}
