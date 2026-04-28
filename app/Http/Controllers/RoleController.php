<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role; 



class FrontendController extends Controller
{
    public function index()
    {
        $role = \App\Models\Role::orderBy('created_at', 'desc')
        ->paginate(10);
        return view('admin.userAndAccess.userRole', compact('role'));
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
