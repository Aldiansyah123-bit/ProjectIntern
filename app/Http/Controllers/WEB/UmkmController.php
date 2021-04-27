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
            'description'   => 'required',
            'region_id'     => 'required',
            'address'       => 'required',
            'latitude'      => 'required',
            'longitude'     => 'required',
            'phone'         => 'required',
            'avatar'        => 'required',
            'background'    => 'required',
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
            'avatar'        => 'required',
            'background'    => 'required',
        ]);

        if (Request()->avatar <> "") {
            //Hapus gambar Lama
            $umkm = Umkm::where('id',$id)->first();
            if ($umkm->avatar <> "") {
                unlink(public_path('avatar'). '/' .$umkm->avatar);
            }
        }
        if (Request()->background <> "") {
            //Hapus gambar Lama
            $umkm = Umkm::where('id',$id)->first();
            if ($umkm->avatar <> "") {
                unlink(public_path('background'). '/' .$umkm->background);
            }

            //jika ingin ganti gambar
            $file       = Request()->avatar;
            $fileavatar = $file->getClientOriginalName();
            $file       ->move(public_path('avatar'),$fileavatar);

            $file       = Request()->background;
            $filebackground = $file->getClientOriginalName();
            $file       ->move(public_path('background'),$filebackground);

            Umkm::findOrFail($id)->update([
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

        } else {

            //Jika tidak ingin mengganti icon
            Umkm::findOrFail($id)->update([
                'name'          => $request->name,
                'description'   => $request->description,
                'region_id'     => $request->region_id,
                'address'       => $request->address,
                'latitude'      => $request->latitude,
                'longitude'     => $request->longitude,
                'phone'         => $request->phone,
                'avatar'        => $request->avatar,
                'background'    => $request->background,
            ]);
        }

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
