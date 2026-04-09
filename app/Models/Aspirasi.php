<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
protected $table = 'ms_aspirasi';
protected $guarded = ['id'];

public function user()
{
    return $this->belongsTo(User::class, 'nik', 'nik');
}

}
