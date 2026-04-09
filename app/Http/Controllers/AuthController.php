<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Officer;  
use App\Models\User; 
use App\Rules\NoHP;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        // dd('ok');
        return view('auth.login');
    }

    public function registerNewMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|min:10',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ],[
            'nik.required' => 'NIK wajib diisi.',
            'nik.min' => 'NIK minimal 10 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('openRegister', true);  // openRegister flag untuk buka register
        }

        #Mulai validasi NIK sama Email
        $cekNIK = Officer::where('nik', $request->nik)->first();
        if (!$cekNIK) {
            return back()
                ->with('openRegister', true)
                ->withErrors(['nik' => 'NIK tidak ditemukan pada database officer.'])
                ->withInput();
        }
        $cekEmail = Officer::where('email', $request->email)->first();
        if (!$cekEmail) {
            return back()
                ->with('openRegister', true)
                ->withErrors(['email' => 'Email tidak sesuai dengan database officer.'])
                ->withInput();
        }
        if (User::where('email', $request->email)->exists()) {
            return back()
                ->with('openRegister', true)
                ->withErrors(['email' => 'Email sudah digunakan.'])
                ->withInput();
        }
        if (User::where('nik', $request->nik)->exists()) {
            return back()
                ->with('openRegister', true)
                ->withErrors(['nik' => 'NIK sudah digunakan.'])
                ->withInput();
        }
        $officer = Officer::where('nik', $request->nik)->first();  
        $user = User::create([
        'fullname' => strtoupper($officer->name),
        'noHP' => $request->noHP,
        'email' => $request->email,
        'nik' => $request->nik,
        'role' => 2,
        'password' => Hash::make($request->password),
        ]);
         return back()->with('success', 'User sudah berhasil dibuat, silakan login.');
    }

    public function checkLogin(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric',
            'password' => 'required|min:8'
        ]);
        $user = User::where('nik', $request->nik)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'nik' => 'Invalid NIK or password'
            ]);
        }
        auth()->login($user);
       if ($user->role == 1) {
        return redirect()->route('dashboard');   // ke dashboard admin
        }
        return redirect()->route('homeLogin');
    }

     public function showForgotPasswordForm()
    {
        return view('auth.forgotPassword');
    }

    public function sendResetLinkViaWA(Request $request)
    {
     $request->validate([
        'noHP' => ['required', new NoHP, 'exists:users,noHP'],
    ]);
    $user = User::where('noHP', $request->noHP)->first();
    // dd($user);
    // Generate token reset
    $token = Str::random(40);
    DB::table('password_resets')->updateOrInsert(
        ['email' => $user->email],
        ['token' => $token, 'created_at' => now()]
    );

    $resetLink = url('/reset-password/' . $token);

    // TEXT UNTUK WHATSAPP
    $waText = urlencode("Halo {$user->name}, klik link reset password:\n$resetLink");

    // redirect user ke WhatsApp (gratis)
    return redirect("https://wa.me/{$user->noHP}?text={$waText}");
    }

    public function accountSettingShow(){
        return view('auth.accountSetting');
    }
    
     public function changePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048'
        ]);

        $file = $request->file('photo');
        $name = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/profile'), $name);
        $user = Auth::user();
        $user->photo = $name;
        $user->updated_id = Auth::user()->nik;
        $user->updated_ip = $request->ip();
        $user->save();

        return back()->with('success', 'Profile photo updated!');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'password' => 'nullable|min:8|confirmed'
        ],
         [
        'password.min' => 'Password harus minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);
        
        $user = Auth::user();
        $user->fullname = $request->fullname;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->updated_id = Auth::user()->nik;
        $user->updated_ip = $request->ip();
        $user->save();
        return back()->with('success', 'Account updated successfully!');
    }




}
