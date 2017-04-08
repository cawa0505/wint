<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ListClassroom
 *
 * @property int $id
 * @property string $name 教室名
 * @property int $building_id 教学楼名
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListClassroom whereBuildingId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListClassroom whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListClassroom whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListClassroom whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ListClassroom whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ListClassroom extends Model
{
    //
}
