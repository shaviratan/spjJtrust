<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirasi; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Shuchkin\SimpleXLSXGen;
use Barryvdh\DomPDF\Facade\Pdf;

class AspirasiController extends Controller
{
    public function create() {
        return view('member.aspirasi');
    }

    public function store(Request $request) {
        $request->validate([
            'type' => 'required',
            'category' => 'required|string|max:100',
            'subject' => 'required|string|max:255',
            'description' => 'required',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);
        $data = $request->all();
        $data['nik'] = Auth::user()->nik;
        $data['created_ip'] = $request->ip();
        $data['is_anonymous'] = $request->has('is_anonymous') ? 1 : 0;
        // dd($data);
        // Handle File Upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/aspirasi'), $filename);
            $data['attachment'] = $filename;
        }
        Aspirasi::create($data);
        return redirect()->back()->with('success', 'Laporan Anda berhasil dikirim!');
    }

    public function dataAspirasi()
    {
        $aspirasi = \App\Models\Aspirasi::where('nik', auth()->user()->nik)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        return view('member.daftarAspirasi', compact('aspirasi'));
    }

    public function getDataDetailbyId($id)
    {
        if(auth()->user()->role == 1){
             $aspirasi = \App\Models\Aspirasi::where('id', $id)
                    ->first();
        }else{
        $aspirasi = \App\Models\Aspirasi::where('id', $id)
                    ->where('nik', auth()->user()->nik) 
                    ->first();
        }
        if (!$aspirasi) {
            return response()->json(['error' => 'Data tidak ditemukan atau Anda tidak memiliki akses.'], 403);
        }
        return response()->json($aspirasi);
    }

        public function dataAllAspirasi()
    {
        $aspirasi = DB::table('ms_aspirasi')
                    ->leftJoin('spjjtrust.users', 'ms_aspirasi.nik', '=', 'spjjtrust.users.nik')
                    ->select(
                        'ms_aspirasi.*', 
                        'spjjtrust.users.fullname as user_name',
                        'spjjtrust.users.email as email' 
                    )
                    ->orderBy('ms_aspirasi.created_at', 'desc')
                    ->paginate(10);
        // dd(auth()->user()->role);
        return view('admin.aspirasi.aspirasiDataMember', compact('aspirasi'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required',
            'admin_response' => 'required|string|max:1000'
        ]);

        \DB::table('ms_aspirasi')->where('id', $request->id)->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response,
            'updated_at' => now(),
            'updated_by' => auth()->user()->nik,
            'updated_ip' => $request->ip()
        ]);

        return redirect()->back()->with('success', 'Status aspirasi berhasil diperbarui.');
    }

    public function klasifikasi()
    {
        $rekapKategori = \DB::table('ms_aspirasi')
            ->select('category', \DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();
        return view('admin.aspirasi.klasifikasi', compact('rekapKategori'));
    }

    public function dataAspirasiByKategori(Request $request) // Tambahkan Request $request
    {
        $query = DB::table('ms_aspirasi')
            ->leftJoin('spjjtrust.users', 'ms_aspirasi.nik', '=', 'spjjtrust.users.nik')
            ->select(
                'ms_aspirasi.*', 
                'spjjtrust.users.fullname as user_name',
                'spjjtrust.users.email as email' 
            );
        if ($request->has('category')) {
            $query->where('ms_aspirasi.category', $request->category);
        }
        $aspirasi = $query->orderBy('ms_aspirasi.created_at', 'desc')
                        ->paginate(10)
                        ->withQueryString();
        return view('admin.aspirasi.aspirasiDataMember', compact('aspirasi'));
    }

    public function exportAspirasi() {
        $query = Aspirasi::select('ms_aspirasi.*', 'users.fullname as nama','users.email as email')
        ->leftJoin('users', 'ms_aspirasi.nik', '=', 'users.nik');
        $aspirasi = $query->latest()->get();
        return view('admin.aspirasi.export', compact('aspirasi'));
    }

    public function filteringExport(Request $request)
    {        
        $query = Aspirasi::query();
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        $rekapKategori = $query->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();
        return view('admin.pengaduan.export', compact('rekapKategori'));
    }

   public function exportExcel(Request $request)
    {
         $query = Aspirasi::select('ms_aspirasi.*', 'users.fullname as nama', 'users.email as email')
        ->leftJoin('users', 'ms_aspirasi.nik', '=', 'users.nik');
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59']);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        $data = $query->latest()->get();
        $rows = [
            ['NO', 'TANGGAL', 'NIK', 'NAMA', 'EMAIL', 'TIPE', 'KATEGORI', 'SUBJEK', 'DESKRIPSI', 'STATUS', 'ADMIN RESPONSE']
        ];
        foreach ($data as $index => $item) {
            $rows[] = [
                $index + 1,
                $item->created_at->format('d-m-Y'),
                $item->nik,
                $item->nama,
                $item->email,
                $item->type,
                $item->category,
                $item->subject,
                $item->description,
                $item->status,
                $item->admin_response
            ];
        }
        return SimpleXLSXGen::fromArray($rows)->downloadAs('Laporan_Pengaduan_' . date('Ymd') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Aspirasi::select('ms_aspirasi.*', 'users.fullname as nama', 'users.email as email')
        ->leftJoin('users', 'ms_aspirasi.nik', '=', 'users.nik');
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59']);
        }
        $data = $query->latest()->get();
        $pdf = Pdf::loadView('admin.aspirasi.pdf_template', compact('data'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('Laporan-Pengaduan-'.date('d-m-Y').'.pdf');
    }

    public function filtering(Request $request)
{
    $query = Aspirasi::select('ms_aspirasi.*', 'users.fullname as nama','users.email as email')
        ->leftJoin('users', 'ms_aspirasi.nik', '=', 'users.nik');
    if ($request->filled('from') && $request->filled('to')) {
        $query->whereBetween('ms_aspirasi.created_at', [
            $request->from . ' 00:00:00', 
            $request->to . ' 23:59:59'
        ]);
    }
    if ($request->filled('category')) {
        $query->where('ms_aspirasi.category', $request->category);
    }
    $aspirasi = $query->latest('ms_aspirasi.created_at')->get();
    // dd($aspirasi);
    return view('admin.aspirasi.export', compact('aspirasi'));
}


}