<?php

    namespace Modules\Danhgia\Entities;

    use Illuminate\Database\Eloquent\Model;

    class EventDetailProcess extends Model
    {
        protected $table = 'event_detail_process';

        protected $fillable = [
            'id',
            'event_id',
            'code',
            'user_id_receiver',
            'count_reply',
            'count_send',
            'status',
        ];

        public function employee()
        {
            return $this->hasMany('Modules\Employee\Entities\Employment', 'id', 'user_id_receiver');
        }

        public function event()
        {
            return $this->hasOne('Modules\Danhgia\Entities\Event', 'id', 'event_id');
        }
    }
