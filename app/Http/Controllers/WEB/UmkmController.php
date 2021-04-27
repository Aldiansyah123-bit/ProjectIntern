<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Umkm;
use App\Region;

class UmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data UMKM',
            'title1' => 'UMKM',
        ];

        $umkm = Umkm::all();
        return view('umkm.index',compact('umkm'),$data);
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
            'description'   => 'string|nullable',
            'region_id'     => 'required',
            'address'       => 'required',
            'latitude'      => 'required',
            'longitude'     => 'required',
            'phone'         => 'required',
            'avatar'        => 'image|max:2000|nullable',
            'background'    => 'image|max:2000|nullable',
        ]);

        if($request->hasFile('avatar')){
            // ada file yang diupload
            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $fileavatarSimpan = $filename.'_'.time().'.'.$extension;
            $path = $request->file('avatar')->move(public_path('avatar'),$fileavatarSimpan);

        }else{
            // tidak ada file yang diupload
            $fileavatarSimpan =  null;
        }

        if($request->hasFile('background')){
            // ada file yang diupload
            $filenameWithExt = $request->file('background')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('background')->getClientOriginalExtension();
            $filebackgroundSimpan = $filename.'_'.time().'.'.$extension;
            $path = $request->file('background')->move(public_path('background'),$filebackgroundSimpan);

        }else{
            // tidak ada file yang diupload
            $filebackgroundSimpan = null;
        }


        Umkm::create([
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

        return redirect('umkm')->with('status', 'Data Berhasil di Tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $data = [
            'title'  => 'Detail Data UMKM',
            'title1' => 'UMKM',
        ];
        $umkm = Umkm::where('id',$id)->get();
        return view('umkm.detail', compact('umkm'), $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = [
            'title' => 'Tambah Data UMKM',
            'title1' => 'UMKM'
        ];

        $region = Region::all();
        return view('umkm.add',compact('region'),$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'title'  => 'Edit Data Umkm',
            'title1' => 'UMKM',
        ];
        $umkm = Umkm::where('id',$id)->first();
        return view('umkm.edit', compact('umkm'), $data);
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



        return redirect('umkm')->with('status', 'Data Berhasil di Update');
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
        return redirect('umkm')->with('status', 'Data Berhasil di Hapus');
    }
}
