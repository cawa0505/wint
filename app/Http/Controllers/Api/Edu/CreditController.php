<?php

namespace App\Http\Controllers\Api\Edu;

use App\Http\Controllers\Api\ApiController;
use App\Models\EduCredit;
use Illuminate\Http\Request;

class CreditController extends ApiController
{

    protected $model;

    public function __construct(){
        $this->model=new EduCredit();
    }

    public function index(Request $request)
    {
        //先默认拿本学期的，以后再测试
        $result=$this->model->fetch($request->user()->id,'credit');
        if($result)
            $this->success($result);
        $this->error();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EduCredit  $eduCredit
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
