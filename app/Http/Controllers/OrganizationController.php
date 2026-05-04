<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Organization; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    public function create() 
    {
        $data = DB::table('union_structure')->get();
        if ($data->isEmpty()) {
            $nodes = [];
        } else {
            $nodes = DB::table('union_structure')->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'pid' => $item->parent_id,
                    'title' => $item->position_title, // Chairman (tanpa ke-1)
                    'name' => $item->full_name,
                    'order' => $item->order_number ?? 1 // ke-1, ke-2
                ];
            });
        }
        return view('admin.organization.organizationCreate', [
            'nodes' => $nodes,
            'isEmpty' => $data->isEmpty()
        ]);
    }
    
     public function store(Request $request)
    {
      try {
        DB::table('union_structure')->insert([
            'position_title' => $request->title,
            'full_name' => $request->name,
            'parent_id' => $request->parent_id,
            'created_date' => now(),
            'created_by' => 'admin',
            'created_ip' => $request->ip()
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan'
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data'
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
       
        return back()->with('success', 'Role user berhasil diperbarui!');
    }

    public function count(Request $request)
    {
        $count = DB::table('union_structure')
            ->where('position_title', $request->title)
            ->count();

        return response()->json([
            'count' => $count
        ]);
    }

    public function delete($id)
    {
        DB::table('union_structure')->where('id', $id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }
   
}