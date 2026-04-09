<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Officer; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProkerController extends Controller
{
  
// CREATE TABLE spjjtrust.activities (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     title VARCHAR(255) NOT NULL,
//     category ENUM('pendidikan', 'advokasi', 'kesejahteraan', 'sosial') NOT NULL,
//     event_date DATE NOT NULL,
//     description TEXT,
//     created_by varchar(15),
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     created_ip varchar(100)
// ) ENGINE=InnoDB;


// CREATE TABLE spjjtrust.activity_photos (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     activity_id INT NOT NULL,
//     photo_path VARCHAR(255) NOT NULL,
//     FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE
// ) ENGINE=InnoDB;
    public function galeryIndex() {
        return view('admin.proker.galery');
    }

    public function storeGallery(Request $request)
    {
        dd($request);
            $request->validate([
            'title'      => 'required|string|max:255',
            'category'   => 'required|in:pendidikan,advokasi,kesejahteraan,sosial',
            'event_date' => 'required|date',
            'photos'     => 'required',
            'photos.*'   => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
        try {
        return \DB::transaction(function () use ($request) {
            $activityId = \DB::table('activities')->insertGetId([
                'title'      => $request->title,
                'category'   => $request->category,
                'event_date' => $request->event_date,
                'description'=> $request->description ?? null,
                'created_by' => auth()->id() ?? 'admin',
                'created_at' => now(),
                'created_ip' => $request->ip(),
            ]);
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                    $file->storeAs('public/frontendpartials/assets/img/gallery', $filename);
                    \DB::table('activity_photos')->insert([
                        'activity_id' => $activityId,
                        'photo_path'  => $filename
                    ]);
                }
            }
            return redirect()->back()->with('success', 'Agenda dan dokumentasi berhasil disimpan!');
        });
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
    }

    public function kegiatanIndex() {
        return view('admin.proker.kegiatan');
    }
    public function storeKegiatan(Request $request)
    {
        try {
        return \DB::transaction(function () use ($request) {
            $filename = null;
            if ($request->hasFile('photo')) { 
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/frontendpartials/assets/img/gallery', $filename);
            $activityId = \DB::table('activities')->insertGetId([
            'title'       => $request->title,
            'category'    => $request->category,
            'event_date'  => $request->event_date,
            'description' => $request->description,
            'icon'        => $request->icon,
            'photo'       => $filename,
            'created_by'  => Auth::user()->nik,
            'created_at'  => now(),
            'created_ip'  => $request->ip(),
            ]);
            if ($filename) {
                \DB::table('activity_photos')->insert([
                    'activity_id' => $activityId,
                    'photo_path'  => $filename,
                    'category'    => $request->category,
                    'created_at'  => now(),
                ]);
            }
        }
            return redirect()->back()->with('success', 'Agenda dan dokumentasi berhasil disimpan!');
        });
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
}