<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ListProvince
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ListCity[] $city
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListProvince whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListProvince whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListProvince whereName($value)
 * @mixin \Eloquent
 */
class ListProvince extends Model
{
    public function city(){
        return $this->hasMany('App\Models\ListCity','province_id');
    }

}
