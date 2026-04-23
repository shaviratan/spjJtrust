<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'union_structure';

    protected $primaryKey = 'id';

    public $timestamps = false; // karena kamu pakai created_date dll

    protected $fillable = [
        'position_title',
        'full_name',
        'region_name',
        'term_period',
        'parent_id', // 🔥 ini penting buat pid
        'created_by',
        'created_date',
        'created_ip',
        'updated_by',
        'updated_date',
        'updated_ip'
    ];
}