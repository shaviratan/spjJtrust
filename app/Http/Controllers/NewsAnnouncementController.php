<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement; 
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NewsAnnouncementController extends Controller
{
    public function createAnnoun() {
        return view('admin.new_announcement.announcement');
    }

    public function storeAnnoun(Request $request) {
        $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'isi' => 'required',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:today'
        ]);
        $data = $request->all();
        $data['title'] = $request->judul;
        $data['category'] = $request->kategori;
        $data['content'] = $request->isi;
        $data['expires_at'] = $request->tanggal_berakhir;
        $data['created_by'] = Auth::user()->nik;
        $data['created_ip'] = $request->ip();
        Announcement::create($data);
        return redirect()->back()->with('success', 'Pengumuman Anda berhasil dikirim!');
    }

     public function dataAllAnnoun() {
        $announcements = \App\Models\Announcement::orderBy('created_date', 'desc')
            ->paginate(10);
        return view('admin.new_announcement.dataAnnouncement', compact('announcements'));
    }

    public function getDataAnnouById($id)
    {
        $announcements = \App\Models\Announcement::where('id', $id)
                    ->first();
        if (!$announcements) {
            return response()->json(['error' => 'Data tidak ditemukan atau Anda tidak memiliki akses.'], 403);
        }
        return response()->json($announcements);
    }

    public function updateAnnoun(Request $request, $id)
    {
        $anoun = Announcement::findOrFail($id);
        $anoun->title = $request->title;
        $anoun->category = $request->category;
        $anoun->content = $request->content;
        $anoun->expires_at = $request->expires_at;
        $anoun->updated_by = Auth::user()->nik;
        $anoun->updated_date = now();
        $anoun->updated_ip = $request->ip();
        $anoun->save();
         session()->flash('success', 'Data berhasil diupdate');
        return response()->json([
        'success' => true,
        'message' => 'Data berhasil diupdate',
        'redirect' => route('admin.pengumuman')
        ]);
    }

    public function createNews() {
        return view('admin.new_announcement.newsForm');
    }

    public function storeNews(Request $request) {
        $messages = [
            'title.required'    => 'Judul berita wajib diisi, tidak boleh kosong.',
            'content.required'      => 'Konten atau isi berita harus diisi.',
        ];
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ], $messages);
        $data = $request->all();
        $data['judul'] = $request->title;
        $data['isi'] = $request->content;
        $data['slug'] = Str::slug($request->title);
        $data['status'] = $request->status;
        $data['is_important'] = $request->boolean('is_important');
        $data['created_by'] = Auth::user()->nik;
        $data['created_ip'] = $request->ip();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('frontendpartials/assets/img'), $filename);
            $data['gambar'] = $filename;
        }
        dd($data);
        News::create($data);
        return redirect()->back()->with('success', 'Pengumuman Anda berhasil dikirim!');
    }

    public function dataAllNews() {
        $data = \App\Models\News::orderBy('created_date', 'desc')
            ->paginate(10);
        return view('admin.new_announcement.dataNews', compact('data'));
    }

    public function getDataNewsById($id)
    {
        $data = \App\Models\News::where('id', $id)
                    ->first();
        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan atau Anda tidak memiliki akses.'], 403);
        }
        return response()->json($data);
    }
        
    public function updateNews(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $news->judul = $request->judul;
        $news->isi = $request->isi;
        $news->status = $request->status;
        $news->slug = Str::slug($request->judul);;
        $news->updated_by = Auth::user()->nik;
        $news->updated_date = now();
        $news->updated_ip = $request->ip();
        $news->save();
         session()->flash('success', 'Data berhasil diupdate');
        return response()->json([
        'success' => true,
        'message' => 'Data berhasil diupdate',
        'redirect' => route('admin.berita.data')
        ]);
    }

    public function indexFront()
    {
        $news = DB::table('news')->where('status', 'published')->paginate(12);   
        return view('frontend.allNews', compact('news'));
    }
}