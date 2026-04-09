<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
protected $table = 'announcements';
protected $guarded = ['id'];
const CREATED_AT = 'created_date';
const UPDATED_AT = 'updated_date';
}
