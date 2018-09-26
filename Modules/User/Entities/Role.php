<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "roles";
    protected $fillable = ['name','guard_name','description','sys_app_id'];

    public function permission(){
        return $this->hasMany("Modules\MyCore\Entities\SysAppPermission",'role_id','id');
    }
}
