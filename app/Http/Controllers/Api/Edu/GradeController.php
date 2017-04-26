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
            return $this->success($result);
        return $this->error();
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

}
