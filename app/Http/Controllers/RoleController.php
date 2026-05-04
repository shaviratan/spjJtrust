<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role; 
use App\Models\Menu; 



class RoleController extends Controller
{
    public function index()
    {
        $role = \App\Models\Role::orderBy('created_at', 'desc')
        ->paginate(10);
         $menus = Menu::with('subMenu')->get();
         $access = \DB::table('ms_access')->get();
        return view('admin.userAndAccess.userRole', compact('role','menus','access'));
    }

     public function store(Request $request) {
        $data = $request->all();
        $data['name'] = $request->role_name;
        $data['description'] = $request->description;
        $data['created_at'] = Auth::user()->nik;
        Role::create($data);
        return redirect()->back()->with('success', 'Pengumuman Anda berhasil dikirim!');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update([
            'name'   => $request->role_name,
            'description' => $request->description,
        ]);
        return back()->with('success', 'Role berhasil diperbarui!');
    }

        public function delete($id)
    {
        $user = Role::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Role berhasil dihapus!');
    }
    

}
