<?php

namespace Modules\Video\Entities;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected  $table = 'playlists';
    protected $fillable = [
        'name',
        'description',
        'status',
    ];
}
