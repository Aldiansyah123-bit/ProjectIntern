<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $banner = Banner::all();
        return response()->json(['banner' => $banner]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'          => 'string|nullable',
            'description'   => 'string|nullable',
            'img'           => 'required|image|max:2000',
        ]);

        if($request->hasFile('img')){
            // ada file yang diupload
            $filenameWithExt = $request->file('img')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('img')->getClientOriginalExtension();
            $fileimgSimpan = $filename.'_'.time().'.'.$extension;
            $path = $request->file('img')->move(public_path('img'),$fileimgSimpan);

        }else{
            // tidak ada file yang diupload
            $fileimgSimpan =  null;
        }

        Banner::create([
                'name'           => $request->name,
                'description'    => $request->description,
                'img'            => $fileimgSimpan,
        ]);

        return response()->json(['message' => 'Data Berhasil di Tambah']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'string|nullable',
            'description'   => 'string|nullable',
            'img'           => 'required|image|max:2000',
        ]);

        $banner = Banner::where('id',$id)->first();
        if ($request->hasFile('img')) {
            //Hapus gambar Lama
            if ($banner->img) {
                unlink(public_path('img'). '/' .$banner->img);
            }
            $filenameWithExt = $request->file('img')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('img')->getClientOriginalExtension();
            $fileimgSimpan = $filename.'_'.time().'.'.$extension;
            $path = $request->file('img')->move(public_path('img'),$fileimgSimpan);
        }else{
            $fileimgSimpan = $banner->img;
        }


        Banner::findOrFail($id)->update([
            'name'           => $request->name ?? $banner->name,
            'description'    => $request->description ?? $banner->description,
            'img'            => $fileimgSimpan,
        ]);

        return response()->json(['message' => 'Data Berhasil di Update']);
    }

    public function destroy($id)
    {
        $banner = Banner::where('id',$id)->first();

        if ($banner->img <> "") {
            unlink(public_path('img'). '/' .$banner->img);
        }

        Banner::destroy($id);
        return response()->json(['message' => 'Data Berhasil di Hapus']);
    }
}
