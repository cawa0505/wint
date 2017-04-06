<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ListCollege
 *
 * @property int $id
 * @property string $name
 * @property int $university_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ListProfession[] $profession
 * @property-read \App\Models\ListUniversity $university
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListCollege whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListCollege whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListCollege whereUniversityId($value)
 * @mixin \Eloquent
 */
class ListCollege extends Model
{
    public function university(){
        return $this->belongsTo('App\Models\ListUniversity');
    }

    public function profession(){
        return $this->hasMany('App\Models\ListProfession');
    }
}
