<?php

    namespace Modules\Danhgia\Entities;

    use Illuminate\Database\Eloquent\Model;

    class GroupQuestionDetail extends Model
    {
        protected $table = 'group_question_detail';

        protected $fillable = [
            'question_id',
            'group_question_id',
            'status',

        ];
        public $timestamps = FALSE;

        public function question()
        {
            return $this->belongsto('Modules\Danhgia\Entities\Question');
        }
    }
