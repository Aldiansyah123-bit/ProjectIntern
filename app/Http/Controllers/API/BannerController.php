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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner = Banner::all();
        return response()->json(['banner' => $banner]);
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
            'img'           => 'required',
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
            'img'           => 'required',
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
