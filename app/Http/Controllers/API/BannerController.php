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
            'img'           => 'image|max:1024|nullable',
        ]);

        $file       = Request()->img;
        $fileimg    = $file->getClientOriginalName();
        $file       ->move(public_path('img'),$fileimg);

        Banner::create([
                'name'           => $request->name,
                'description'    => $request->description,
                'img'            => $fileimg,
        ]);

        return response()->json(['message' => 'Data Berhasil di Tambah']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'string|nullable',
            'description'   => 'string|nullable',
            'img'           => 'image|max:1024|nullable',
        ]);

        if (Request()->img <> "") {
            //Hapus gambar Lama
            $img = Banner::where('id',$id)->first();
            if ($img->img <> "") {
                unlink(public_path('img'). '/' .$img->img);
            }

            //jika ingin ganti gambar
            $file       = Request()->img;
            $fileimg = $file->getClientOriginalName();
            $file       ->move(public_path('img'),$fileimg);

            Banner::findOrFail($id)->update([
                'name'           => $request->name,
                'description'    => $request->description,
                'img'            => $fileimg,
        ]);


        } else {

            //Jika tidak ingin mengganti icon
            Banner::findOrFail($id)->update([
                'name'           => $request->name,
                'description'    => $request->description,
                'img'            => $$request->img,
            ]);
        }

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
