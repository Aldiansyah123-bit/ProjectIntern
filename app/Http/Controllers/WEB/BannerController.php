<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data Banner',
            'title1' => 'Banner',
            'transaction' => DB::table('transactions')->count(),
            'cart'  => DB::table('carts')->count(),
        ];

        $banner = Banner::all();
        return view('banner.index',compact('banner'),$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        return redirect('banner')->with('status', 'Data Berhasil di Tambah');
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
    public function show()
    {
        $data = [
            'title' => 'Tambah Data Banner',
            'title1' => 'Banner'
        ];
        return view('banner.add',$data);
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
            'title'  => 'Edit Data Banner',
            'title1' => 'Banner',
        ];
        $banner = Banner::where('id',$id)->first();
        return view('banner.edit', compact('banner'), $data);
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

        return redirect('banner')->with('status', 'Data Berhasil di Update');
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
        return redirect('banner')->with('status', 'Data Berhasil di Hapus');
    }
}
