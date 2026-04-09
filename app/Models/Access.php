<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    protected $table = 'ms_access';

    protected $fillable = [
        'role_id',
        'menu_id',
        'sub_menu_id'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function subMenu()
    {
        return $this->belongsTo(SubMenu::class, 'sub_menu_id', 'id');
    }
}
