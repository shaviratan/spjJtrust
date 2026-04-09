<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Compro; 



class CompanyProfileController extends Controller
{
    public function index()
    {
        $data = Compro::first();
        return view('admin.companyProfile.profile',compact('data'));
    }

    public function update(Request $request)
    {
        $identity = Compro::first() ?? new Compro();
        $targetFolder = 'uploads/compro'; // Folder di dalam public/
        $destinationPath = public_path($targetFolder);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        if ($request->hasFile('profile_image')) {
            if ($identity->profile_image && file_exists(public_path($identity->profile_image))) {
                unlink(public_path($identity->profile_image));
            }
            $file = $request->file('profile_image');
            $fileName = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $identity->profile_image = $targetFolder . '/' . $fileName;
        }
        if ($request->hasFile('video_thumbnail')) {
            if ($identity->video_thumbnail && file_exists(public_path($identity->video_thumbnail))) {
                unlink(public_path($identity->video_thumbnail));
            }
            $file = $request->file('video_thumbnail');
            $fileName = 'thumb_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $identity->video_thumbnail = $targetFolder . '/' . $fileName;
        }
        $identity->fill([
            'profile_description' => $request->profile_description,
            'visi' => $request->visi,
            'misi' => $request->misi,
        ]);
        $identity->save();
        return back()->with('success', 'Data berhasil diperbarui di public/uploads/compro!');
    }

    public function indexContact()
    {
        $data = Compro::first();
        return view('admin.companyProfile.contact',compact('data'));
    }

    public function updateContact(Request $request)
{

    $compro = Compro::first() ?? new Compro();
    $targetFolder = 'uploads/compro';
    $destinationPath = public_path($targetFolder);
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }
    if ($request->hasFile('logo')) {
        if ($compro->logo && file_exists(public_path($compro->logo))) {
            unlink(public_path($compro->logo));
        }
        $file = $request->file('logo');
        $fileName = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);
        $compro->logo = $targetFolder . '/' . $fileName;
    }
    Compro::updateOrCreate(
        ['id' => 1],
        [
            'company_name' => $request->company_name,
            'address'      => $request->address,
            'email'        => $request->email,
            'whatsapp'     => $request->whatsapp,
            'phone'        => $request->phone,
            'logo'         => $compro->logo, 
        ]
    );
    return back()->with('success', 'Identitas berhasil diperbarui!');
}

    

}
