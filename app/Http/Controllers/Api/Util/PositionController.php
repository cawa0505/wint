<?php
/**
 * Created by PhpStorm.
 * User: Sky
 * Date: 2017-05-14
 * Time: 23:20
 */

namespace app\Http\Controller\Api\Util;


use App\Http\Controllers\Api\ApiController;
use App\Models\ListCity;
use App\Models\ListDistrict;
use App\Models\ListProvince;

class PositionController extends ApiController
{
    //获取地理位置信息

    public function getProvince(){
        return $this->success(ListProvince::orderBy('id')->get());
    }

    public function getCity($province_id){
        $province=ListProvince::find($province_id);
        if($province){
            return $this->success($province->city());
        }
        return $this->error();
    }

    public function getDistrict($city_id){
        $city=ListCity::find($city_id);
        if($city){
            return $this->success($city->district());
        }
        return $this->error();
    }

    public function getUniversity($district_id){
        $district=ListDistrict::find($district_id);
        if($district){
            return $this->success($district->university());
        }
        return $this->error();
    }


}