<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'ms_menu';

    protected $fillable = [
        'name',
        'icon',
        'url',
        'sort_order'
    ];

    public function subMenu()
    {
        return $this->hasMany(SubMenu::class, 'menu_id', 'id')
                    ->orderBy('sort_order');
    }
}
