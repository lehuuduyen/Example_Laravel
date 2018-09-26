<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class ModelRole extends Model
{
    protected $table = "model_has_roles";
    protected $fillable = ["role_id","model_id","model_type"];
    public $timestamps = false;
}
