<?php

namespace App\Models;

use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EduCoursetake
 *
 * @mixin \Eloquent
 */
class EduCoursetake extends BaseModel
{


    /**上面整合完，在这里批量写入数据库及对应关系以及校验数据准确性
     * @param $data
     * @return bool true Or false
     */
    public function saveData($data,$year,$term){

    }
}
