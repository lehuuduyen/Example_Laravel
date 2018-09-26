<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public static $STATE_ENABLE = 1;
    public static $STATE_DISABLE = 0;
    protected $table = 'positions';
    protected $fillable = [
        'id',
        'name',
        'description',
        'state'
    ];
    protected $hidden = [];
}
