<?php

namespace Modules\Video\Entities;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';
    protected $fillable = [
        'customer_id',
        'name',
        'thumbnail',
        'file',
        'description',
        'status',
    ];
}
