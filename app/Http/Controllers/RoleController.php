<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role; 



class FrontendController extends Controller
{

    public function show($slug)
    {
        // Cari berita berdasarkan slug, pastikan statusnya sudah 'published'
        $item = News::where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail(); // Jika tidak ketemu, munculkan error 404

        return view('frontend.show', compact('item'));
    }

}
