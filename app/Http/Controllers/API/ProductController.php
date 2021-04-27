<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
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
        $product = Product::all();
        return response()->json(['Product' => $product]);
    }

    public function detail($id)
    {
        $product = Product::where('id',$id)->get();

        return response()->json([
            'Product' => $product
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
            'umkm_id'       => 'required',
            'name'          => 'required',
            'description'   => 'string|nullable',
            'price'         => 'required',
            'stok'          => 'required',
            'img'           => 'image|max:1024|nullable',
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

        Product::create([
                'umkm_id'        => $request->umkm_id,
                'name'           => $request->name,
                'description'    => $request->description,
                'price'          => $request->price,
                'stok'           => $request->stok,
                'img'            => $fileimgSimpan,
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
            'umkm_id'       => 'required',
            'name'          => 'required',
            'description'   => 'required',
            'price'         => 'required',
            'stok'          => 'required',
            'img'           => 'file|size:1024',
        ]);

        $product = Product::where('id',$id)->first();
        if ($request->hasFile('img')) {
            //Hapus gambar Lama
            if ($product->img) {
                unlink(public_path('img'). '/' .$product->avatar);
            }
            $filenameWithExt = $request->file('img')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('img')->getClientOriginalExtension();
            $fileimgSimpan = $filename.'_'.time().'.'.$extension;
            $path = $request->file('img')->move(public_path('img'),$fileimgSimpan);
        }else{
            $fileimgSimpan = $product->img;
        }

        Product::findOrFail($id)->update([
                'umkm_id'        => $request->umkm_id,
                'name'           => $request->name,
                'description'    => $request->description,
                'price'          => $request->price,
                'stok'           => $request->stok,
                'img'            => $fileimgSimpan,
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
        $product = Product::where('id',$id)->first();

        if ($product->img <> "") {
            unlink(public_path('img'). '/' .$product->img);
        }

        Product::destroy($id);

        return response()->json(['message' => 'Data Berhasil di Hapus']);
    }
}
