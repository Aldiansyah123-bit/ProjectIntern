<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Umkm;

class UmkmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        $umkm = Umkm::all();
        return response()->json([
            'Umkm' => $umkm
        ]);
    }

    public function detail($id)
    {
        $umkm = Umkm::where('id',$id)->get();

        return response()->json([
            'Umkm' => $umkm
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'description'   => 'required',
            'region_id'     => 'required',
            'address'       => 'required',
            'latitude'      => 'required',
            'longitude'     => 'required',
            'phone'         => 'required',
            'avatar'        => 'file|size:2000',
            'background'    => 'file|size:2000',
        ]);

        $file       = Request()->avatar;
        $fileavatar = $file->getClientOriginalName();
        $file       ->move(public_path('avatar'),$fileavatar);

        $file       = Request()->background;
        $filebackground = $file->getClientOriginalName();
        $file       ->move(public_path('background'),$filebackground);

        Umkm::create([
            'name'          => $request->name,
            'description'   => $request->description,
            'region_id'     => $request->region_id,
            'address'       => $request->address,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'phone'         => $request->phone,
            'avatar'        => $fileavatar,
            'background'    => $filebackground,
        ]);

        return response()->json(['message' => 'Data Berhasil di Tambah']);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required',
            'description'   => 'required',
            'region_id'     => 'required',
            'address'       => 'required',
            'latitude'      => 'required',
            'longitude'     => 'required',
            'phone'         => 'required',
            'avatar'        => 'image|max:2000|nullable',
            'background'    => 'image|max:2000|nullable',
        ]);

        $umkm = Umkm::where('id',$id)->first();
        if ($request->hasFile('avatar')) {
            //Hapus gambar Lama
            if ($umkm->avatar) {
                unlink(public_path('avatar'). '/' .$umkm->avatar);
            }
            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $fileavatarSimpan = $filename.'_'.time().'.'.$extension;
            $path = $request->file('avatar')->move(public_path('avatar'),$fileavatarSimpan);
        }else{
            $fileavatarSimpan = $umkm->avatar;
        }

        if ($request->hasFile('background')) {
            //Hapus gambar Lama
            if ($umkm->background) {
                unlink(public_path('background'). '/' .$umkm->background);
            }
            $filenameWithExt = $request->file('background')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('background')->getClientOriginalExtension();
            $filebackgroundSimpan = $filename.'_'.time().'.'.$extension;
            $path = $request->file('background')->move(public_path('background'),$filebackgroundSimpan);
        }else{
            $filebackgroundSimpan = $umkm->background;
        }

        Umkm::findOrFail($id)->update([
            'name'          => $request->name,
            'description'   => $request->description,
            'region_id'     => $request->region_id,
            'address'       => $request->address,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'phone'         => $request->phone,
            'avatar'        => $fileavatarSimpan,
            'background'    => $filebackgroundSimpan,
        ]);


        return response()->json(['message' => 'Data Berhasil di Update']);
    }


    public function destroy($id)
    {
        $umkm = Umkm::where('id',$id)->first();

        if ($umkm->avatar <> "") {
            unlink(public_path('avatar'). '/' .$umkm->avatar);
        }
        if ($umkm->background <> "") {
            unlink(public_path('background'). '/' .$umkm->background);
        }

        Umkm::destroy($id);
        return response()->json([
            'message' => 'Data Berhasil di Hapus'
        ]);
    }
}
