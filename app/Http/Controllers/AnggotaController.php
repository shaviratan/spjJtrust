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
require_once app_path('Helpers/SimpleXLSX.php'); 
use Shuchkin\SimpleXLSX;


class AnggotaController extends Controller
{
    public function tambahAnggotaIndex()
    {
        // dd('ok');
        return view('master.formTambahAnggota');
    }
    
     public function storeAnggota(Request $request)
    {
        $validated = $request->validate([
            'nama'           => 'required|string|max:255',
            'nik'            => 'required|string|max:20|unique:ms_officer,nik',
            'email'          => 'required|string|email|max:255|unique:ms_officer,email',
        ], [
            'nik.unique' => 'NIK sudah terdaftar!',
            'email.unique' => 'Email sudah terdaftar!',
        ]);
        $param = [ 
            'nik'           => $request->nik,
            'email'         => $request->email,
            'name'          => strtoupper($request->nama),
            'created_by'    => Auth::user()->nik,
            'created_date'  => now(),
            'created_ip'    => $request->ip()
        ];   
        // \DB::table('ms_officer')->insert([
        //     $param
        // ]);   
         return redirect()->route('admin.anggota.tambah')->with('success', 'Data anggota berhasil ditambahkan!');
    }

        public function dataAnggotaIndex()
    {
         $officer = DB::table('ms_officer')->orderBy('id', 'DESC')->paginate(10);
        return view('master.dataAnggota', compact('officer'));
    }

    public function showData($id)
    {
        $officer = Officer::find($id);
        if (!$officer) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($officer);
    }

    public function updateData(Request $request, $id)
    {
        $anggota = Officer::findOrFail($id);

        $anggota->name = $request->nama;
        $anggota->nik = $request->nik;
        $anggota->email = $request->email;
        $anggota->updated_by = Auth::user()->nik;
        $anggota->updated_date = now();
        $anggota->updated_ip = $request->ip();
        $anggota->save();
         session()->flash('success', 'Data berhasil diupdate');
        return response()->json([
        'success' => true,
        'message' => 'Data berhasil diupdate',
        'redirect' => route('admin.anggota.data')
        ]);
    }

    public function deleteAnggota($id)
    {
        $anggota = Officer::findOrFail($id);
        $anggota->delete();
        session()->flash('success', 'Data Master Officer berhasil dihapus!'); 
        return response()->json([
        'success' => true,
        'message' => 'Data berhasil dihapus',
        'redirect' => route('admin.anggota.data')
        ]);
    }

    public function exportAnggota()
    {
        $fileName = 'data_anggota_' . date('Y-m-d') . '.csv';
        $officers = \DB::table('ms_officer')->get();
        $columns  = ['Nama', 'NIK', 'Email'];
        // Definisikan header secara manual dalam array
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        // Gunakan response()->stream() dan masukkan $headers sebagai parameter KETIGA
        return response()->stream(function() use($officers, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($officers as $row) {
                fputcsv($file, [$row->name, $row->nik, $row->email]);
            }
            fclose($file);
        }, 200, $headers); // Headers diletakkan di sini sebagai argumen, bukan di-chain
    }

    public function downloadTemplate() {
    $fileName = 'template_officer.xls'; // Menggunakan format XML spreadsheet
    $header = ['NIK', 'Email', 'Nama'];
    $instruction = ['PENTING:', 'JANGAN HAPUS BARIS INI, ISI DATA MULAI BARIS KE-3', ''];
    $example = ['2021234567', 'jaya@jtrustbank.co.id', 'Jaya'];
    $xml = '<?xml version="1.0"?><?mso-application progid="Excel.Sheet"?>
    <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
        <Styles>
            <Style ss:ID="header"><Font ss:Bold="1"/><Interior ss:Color="#FFFF00" ss:Pattern="Solid"/></Style>
            <Style ss:ID="warning"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Interior ss:Color="#FF0000" ss:Pattern="Solid"/></Style>
        </Styles>
        <Worksheet ss:Name="Sheet1">
            <Table>
                <Row ss:StyleID="header">
                    <Cell><Data ss:Type="String">'.$header[0].'</Data></Cell>
                    <Cell><Data ss:Type="String">'.$header[1].'</Data></Cell>
                    <Cell><Data ss:Type="String">'.$header[2].'</Data></Cell>
                </Row>
                <Row ss:StyleID="warning">
                    <Cell><Data ss:Type="String">'.$instruction[0].'</Data></Cell>
                    <Cell><Data ss:Type="String">'.$instruction[1].'</Data></Cell>
                    <Cell><Data ss:Type="String">'.$instruction[2].'</Data></Cell>
                </Row>
                <Row>
                    <Cell><Data ss:Type="String">'.$example[0].'</Data></Cell>
                    <Cell><Data ss:Type="String">'.$example[1].'</Data></Cell>
                    <Cell><Data ss:Type="String">'.$example[2].'</Data></Cell>
                </Row>
            </Table>
        </Worksheet>
    </Workbook>';
    return response($xml, 200, [
        'Content-Type' => 'application/vnd.ms-excel',
        'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
    ]);
    }

    public function importAnggota(Request $request)
    {
        $request->validate(['file_excel' => 'required']);

        try {
            if ($xlsx = SimpleXLSX::parse($request->file('file_excel')->getRealPath())) {
                
                \DB::table('ms_officer')->truncate(); // Kosongkan data & Reset ID ke 1
                
                $rows = $xlsx->rows();
                
                foreach ($rows as $index => $data) {
                    // SKIP HANYA BARIS 1 (Header: NIK, Email, Nama)
                    if ($index < 2) continue; 

                    // Pastikan kolom NIK (indeks 0) tidak kosong
                    if (!empty($data[0])) { 
                        Officer::create([
                            'nik'           => strval($data[0]), // Pastikan NIK terbaca sebagai string
                            'email'         => $data[1] ?? null,
                            'name'          => $data[2] ?? null,
                            'created_by'    => Auth::user()->nik ?? 'System',
                            'created_date'  => now(),
                            'created_ip'    => $request->ip()
                        ]);
                    }
                }

                return redirect()->back()->with('success', 'Berhasil! Data telah diimport.');
            } else {
                return redirect()->back()->with('error', 'Gagal membaca file: ' . SimpleXLSX::parseError());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


}
