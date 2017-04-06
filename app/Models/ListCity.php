<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ListCity
 *
 * @property int $id
 * @property string $name
 * @property int $province_id
 * @property string $code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ListDistrict[] $district
 * @property-read \App\Models\ListProvince $province
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListCity whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListCity whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListCity whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListCity whereProvinceId($value)
 * @mixin \Eloquent
 */
class ListCity extends Model
{
    public function province(){
        return $this->belongsTo('App\Models\ListProvince');
    }

    public function district(){
        return $this->hasMany('App\Models\ListDistrict');
    }
}
