<?php

    namespace Modules\User\Entities;

    use Illuminate\Database\Eloquent\Model;

    class Permission extends Model
    {
        protected $table = "permissions";
        protected $fillable = [
            'sys_app_id',
            'name',
            'guard_name',
            'description'
        ];

    }
