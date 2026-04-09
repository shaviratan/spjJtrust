<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class ForgotPasswordController extends Controller
{

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }
    // Submit password baru
    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        $reset = DB::table('password_resets')
                    ->where('token', $request->token)
                    ->first();

        if (!$reset) {
            return back()->withErrors(['token' => 'Token tidak valid atau sudah kedaluwarsa.']);
        }

        // Update password
        User::where('email', $reset->email)->update([
            'password' => bcrypt($request->password),
        ]);

        // Hapus token
        DB::table('password_resets')->where('token', $request->token)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil diperbarui.');
    }
}
