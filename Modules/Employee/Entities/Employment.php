<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    public static $STATE_ENABLE = 1;
    public static $STATE_DISABLE = 0;
    protected $table = 'user_details';
    protected $fillable = [
        'is_email',
        'id',
        'email',
        'user_id',
        'department_id',
        'full_name',
        'avatar',
        'job_title',
        'gender',
        'phone',
        'office_id',
        'position_id',
        'type',
        'birth_place',
        'origin_place',
        'ethnic_group',
        'religious',
        'normal_address',
        'temporary_address',
        'dob',
        'tax_number',
        'social_number',
        'social_number_address',
        'social_date_create',
        'foreign_language',
        'computer',
        'education_level',
        'academic_level',
        'professional',
        'ensurance_number',
        'ensurance_date_create',
        'ensurance_address',
        'ensurance_hospital',
        'health',
        'weight',
        'heigh',
        'state',
    ];
    protected $hidden = [];

    //Vi tri
    public function position()
    {
        return $this->hasOne('Modules\Employee\Entities\Position', 'id', 'position_id');
    }
    public function department()
    {
        return $this->hasOne('Modules\Department\Entities\Department', 'id', 'department_id')->orderBy('id','desc');
    }

    public function user()
    {
        return $this->hasOne('Modules\User\Entities\User', 'id', 'user_id');
    }


}
