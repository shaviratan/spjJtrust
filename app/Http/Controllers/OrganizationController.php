<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Officer; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    public function create() {
        // $users = \App\Models\User::orderBy('created_date', 'desc')
        //     ->paginate(10);
        return view('admin.organization.organizationCreate');
    }
    
     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email',
        'nik'      => 'required',
        'no_hp'    => 'required',
        'role'     => 'required',
        'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $officer = Officer::where('nik', $request->nik)
                        ->where('email', $request->email)
                        ->first();
        if (!$officer) {
            return back()->withInput()->withErrors([
                'nik' => 'Data NIK atau Email tidak ditemukan di database Officer.',
                'email' => 'Data NIK atau Email tidak ditemukan di database Officer.',
            ]);
        }
        $userExists = User::where('nik', $request->nik)
                        ->orWhere('email', $request->email)
                        ->exists();
        if ($userExists) {
            return back()->withInput()->withErrors([
                'nik' => 'NIK atau Email sudah terdaftar sebagai pengguna sistem.',
                'email' => 'NIK atau Email sudah terdaftar sebagai pengguna sistem.',
            ]);
        }
        $officer = Officer::where('nik', $request->nik)->first();
        $user = User::create([
        'fullname' => strtoupper($officer->name),
        'noHP' => $request->noHP,
        'email' => $request->email,
        'nik' => $request->nik,
        'role' => $request->role,
        'created_id' => Auth::user()->nik,
        'created_ip' => $request->ip(),
        'password' => Hash::make($request->password),
        ]);
         return back()->with('success', 'User sudah berhasil dibuat');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:1,2',
        ]);
        $user = User::findOrFail($id);
        $user->update([
            'role' => $request->role,
            'updated_id' => Auth::user()->nik,
            'updated_date' => now(),
            'updated_ip' => $request->ip()
        ]);
        return back()->with('success', 'Role user berhasil diperbarui!');
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return back()->with('success', 'Password user ' . $user->fullname . ' berhasil diperbarui!');
    }
}