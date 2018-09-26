<?php

namespace Modules\Danhgia\Entities;

use Illuminate\Database\Eloquent\Model;

class EventDetailRegisty extends Model
{
    protected $table = 'event_detail_registry';

    protected $fillable = [
        'id',
        'event_id',
        'department_id',
        'user_id_receiver',


    ];
    public $timestamps = false;

}
