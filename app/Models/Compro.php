<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compro extends Model
{
    protected $table = 'about_company';
    protected $fillable = [
        'profile_description',
        'profile_image',
        'video_thumbnail',
        'visi',
        'misi',
        'logo',          
        'company_name',  
        'address',       
        'email',         
        'phone',         
        'whatsapp'       
    ];
    protected $casts = [
        'misi' => 'array',
    ];

}
