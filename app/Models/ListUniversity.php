<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ListUniversity
 *
 * @property int $id
 * @property string $name
 * @property int $district_id
 * @property float $longitude 学校精度，用于地理位置获取学校
 * @property float $latitude 维度，同上
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ListCollege[] $college
 * @property-read \App\Models\ListDistrict $district
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListUniversity whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListUniversity whereDistrictId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListUniversity whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListUniversity whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListUniversity whereLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListUniversity whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListUniversity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ListUniversity extends Model
{
    public function district(){
        return $this->belongsTo('App\Models\ListDistrict','distict_id');
    }

    public function college(){
        return $this->hasMany('App\Models\ListCollege','university_id');
    }
}
