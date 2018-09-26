<?php

    namespace Modules\Danhgia\Entities;

    use Illuminate\Database\Eloquent\Model;

    class GroupQuestion extends Model
    {
        protected $table = 'group_question';

        protected $fillable = [
            'name',
            'id',
            'status',
            'description',

        ];

        public function detail()
        {
            return $this->hasMany('Modules\Danhgia\Entities\GroupQuestionDetail', 'group_question_id', 'id')->count();
        }


        public function detail_question()
        {
            return $this->hasMany('Modules\Danhgia\Entities\GroupQuestionDetail', 'group_question_id', 'id')
                        ->with('question');
        }
    }
