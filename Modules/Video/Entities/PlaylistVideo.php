<?php

namespace Modules\Video\Entities;

use Illuminate\Database\Eloquent\Model;

class PlaylistVideo extends Model
{
    private  $table = 'playlist_videos';
    protected $fillable = [
        'video_id',
        'playlist_id',
        'order',
    ];
}
