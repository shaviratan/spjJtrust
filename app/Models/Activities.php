<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model

{
    use HasFactory;
    protected $table = 'activities';

    protected $fillable = [
        'title',
        'category',
        'event_date',
        'description',
        'created_by',
        'created_ip'
    ];
    public $timestamps = true;

    public function photos()
    {
        return $this->hasMany(ActivityPhoto::class, 'activity_id');
    }
}