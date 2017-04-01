<?php

namespace App\Http\Controllers;

use App\Models\ListDistrict;
use Illuminate\Http\Request;
use App\Models\ListCity;

class ChinaAreaController extends Controller{

    public static function cityList(Request $request,$id){
        return ListCity::where('province_id','=',$request->q?$request->q:$id)->get(['id',Db::raw('name as text')]);
    }

    public static function districtList(Request $request,$id){
        return ListDistrict::where('city_id','=',$request->q?$request->q:$id)->get(['id',Db::raw('name as text')]);
    }
}