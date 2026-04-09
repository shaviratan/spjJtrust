<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
protected $table = 'news';
protected $guarded = ['id'];
const CREATED_AT = 'created_date';
const UPDATED_AT = 'updated_date';
}
