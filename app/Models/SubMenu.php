<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $table = 'ms_sub_menu';

    protected $fillable = [
        'menu_id',
        'name',
        'url',
        'sort_order'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }
}
