<?php

namespace Modules\Device\Entities;

use Illuminate\Database\Eloquent\Model;
use Hash;

class Device extends Model
{
    protected $fillable = [
        'name',
        'password',
        'description',
        'ip_address',
        'is_online'
    ];

    protected $hidden = [
        'password'
    ];

    public function setPasswordAttribute($value){

        $this->attributes['password'] = Hash::make($value);
    }
}
