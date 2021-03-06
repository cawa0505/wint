<?php

namespace App\Models;


/**
 * App\Models\EduUniversityInfo
 *
 * @mixin \Eloquent
 */
class EduUniversityInfo extends EduModel
{
    public function university(){
        return $this->hasOne('App\Models\ListUniversity','id','university_id');
    }
}
