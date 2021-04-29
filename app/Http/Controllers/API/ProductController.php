<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Umkm;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        $product = Product::all();
        return response()->json(['Product' => $product]);
    }

    public function getProduct(Request $request)
    {

        $search = $request->search;

        if($search == ''){
            $umkm = Umkm::orderby('name','asc')
                        ->select('id','name')
                        ->limit(8)
                        ->get();
        }else{
            $umkm = Umkm::orderby('name','asc')
                        ->select('id','name')
                        ->where('name', 'like', '%' .$search . '%')
                        ->limit(8)
                        ->get();
        }

        $response = array();
        foreach($umkm as $umkms){
            $response[] = array(
                "id"      =>$umkms->id,
                "text"    =>$umkms->name
            );
        }

        return response()->json($response);
    }

    public function detail($id)
    {
        $product = Product::where('id',$id)->get();

        return response()->json([
            'Product' => $product
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'umkm_id'       => 'required',
            'name'          => 'required',
            'description'   => 'string|nullable',
            'price'         => 'required',
            'stok'          => 'required',
            'img'           => 'image|max:2000|nullable',
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'umkm_id'       => 'required',
            'name'          => 'required',
            'description'   => 'required',
            'price'         => 'required',
            'stok'          => 'required',
            'img'           => 'image|max:2000|nullable',
        ]);

        $product = Product::where('id',$id)->first();
        if ($request->hasFile('img')) {
            //Hapus gambar Lama
            if ($product->img) {
                unlink(public_path('img'). '/' .$product->img);
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


    public function destroy($id)
    {
        $product = Product::where('id',$id)->first();

        if ($product->img <> " ") {
            unlink(public_path('img'). '/' .$product->img);
        }

        Product::destroy($id);

        return response()->json(['message' => 'Data Berhasil di Hapus']);
    }
}
