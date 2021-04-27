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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            'avatar'        => 'file|size:1024',
            'background'    => 'file|size:1024',
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            'avatar'        => 'image|max:1024|nullable',
            'background'    => 'image|max:1024|nullable',
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
