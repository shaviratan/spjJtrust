<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    protected $table = 'ms_officer';

    protected $fillable = [
        'nik',
        'email',
        'name',
        'created_by',
        'created_date',
        'created_ip',
    ];

    public $timestamps = false;  
}
