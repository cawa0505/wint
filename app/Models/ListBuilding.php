<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ListBuilding
 *
 * @property int $id
 * @property string $name 教学楼名
 * @property int $school_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListBuilding whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListBuilding whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListBuilding whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListBuilding whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListBuilding whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ListBuilding extends Model
{
    //
}
