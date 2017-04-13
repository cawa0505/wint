<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ListProfession
 *
 * @property int                                                                   $id
 * @property string                                                                $name
 * @property int                                                                   $college_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ListClass[] $classes
 * @property-read \App\Models\ListCollege                                          $college
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListProfession whereCollegeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListProfession whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListProfession whereName($value)
 * @mixin \Eloquent
 */
class ListProfession extends Model
{

    public function classes () {
        return $this->hasMany('App\Models\ListClass', 'class_id');
    }

    public function college () {
        return $this->belongsTo('App\Models\ListCollege');
    }

    public static function updateProfession ($profession, $university_id) {
        $data['name'] = $profession;
        $data['university_id'] = $university_id;
        $result = self::firstOrCreate($data);

        return $result->id;

    }
}
