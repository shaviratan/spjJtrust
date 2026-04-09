<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\Access;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            if (!Auth::check()) {
                return $view->with('menu', []);
            }
            $roleId = Auth::user()->role;
            // Ambil menu berdasarkan role di ms_access
            $menus = Menu::whereIn('id', function ($query) use ($roleId) {
                $query->select('menu_id')
                      ->from('ms_access')
                      ->where('role_id', $roleId);
            })
            ->with([
                'subMenu' => function ($query) use ($roleId) {
                    $query->whereIn('id', function ($q) use ($roleId) {
                        $q->select('sub_menu_id')
                          ->from('ms_access')
                          ->where('role_id', $roleId);
                    })
                    ->where('is_active', 1);
                }
            ])
            ->orderBy('sort_order')
            ->get();
             // Ambil title otomatis
                $currentUrl = request()->path();
                $activeSubMenu = SubMenu::where('url', $currentUrl)->first();
                $activeTitle = $activeSubMenu->name ?? 'SPJ Dashboard';
            $view->with('menu', $menus)
                ->with('title', $activeTitle);
        });
    }
}
