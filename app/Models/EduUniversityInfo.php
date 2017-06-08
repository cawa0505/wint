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
        return $this->hasOne('app\Models\University','university_id','id');
    }
}
