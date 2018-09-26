<?php

namespace Modules\Danhgia\Entities;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'type',
        'description',
        'data',
        'status'
    ];
    public function groupquestiondetail(){
        return $this->hasMany('Modules/Danhgia/Entities/GroupQuestionDetail');
    }


}
