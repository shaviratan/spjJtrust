<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'ms_role';
    protected $fillable = [
        'name',
        'description',
    ];

}
