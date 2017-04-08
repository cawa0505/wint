<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ListDistrict
 *
 * @property int $id
 * @property string $name
 * @property int $city_id
 * @property string $code
 * @property-read \App\Models\ListCity $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ListUniversity[] $university
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListDistrict whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListDistrict whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListDistrict whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListDistrict whereName($value)
 * @mixin \Eloquent
 */
class ListDistrict extends Model
{
    public function city(){
        return $this->belongsTo('App\Models\ListCity');
    }

    public function university(){
        return $this->hasMany('App\Models\ListUniversity');
    }
}
