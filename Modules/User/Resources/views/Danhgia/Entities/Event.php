<?php

namespace Modules\Danhgia\Entities;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';

    protected $fillable = [
        'description',
        'qroup_question_id'
        ];
    public function group_question()
    {
        return $this->hasOne('Modules\Danhgia\Entities\GroupQuestion', 'id', 'qroup_question_id');
    }
}
