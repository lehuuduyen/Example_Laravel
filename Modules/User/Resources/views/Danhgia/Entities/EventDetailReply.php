<?php

namespace Modules\Danhgia\Entities;

use Illuminate\Database\Eloquent\Model;

class EventDetailReply extends Model
{
    protected $table = 'event_detail_reply';

    protected $fillable = [
        'id',
        'event_detail_id',
        'user_id',
        'question_id',
        'data',
        'status',

    ];
}
