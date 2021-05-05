<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Umkm;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
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
            'title' => 'Data Product',
            'title1' => 'PRODUCT',
        ];

        $product = Product::all();
        return view('product.index',compact('product'),$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'umkm_id'       => 'required|string',
            'name'          => 'required|string',
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

        return redirect('product')->with('status', 'Data Berhasil di Tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        echo json_encode($response);
        exit;
    }

    public function detail($id)
    {
        $data = [
            'title1'  => 'Detail Product',
        ];
        $product = Product::where('id',$id)->get();
        return view('product.detail', compact('product'), $data);
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
            'title' => 'Tambah Data Product',
            'title1' => 'Product'
        ];

        $product = Product::all();
        return view('product.add',compact('product'),$data);
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
            'title'  => 'Edit Data Product',
            'title1' => 'Product',
        ];
        $product = Product::where('id',$id)->first();
        return view('product.edit', compact('product'), $data);
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
            'umkm_id'       => 'required|integer',
            'name'          => 'required|string',
            'description'   => 'string|nullable',
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

        return redirect('product')->with('status', 'Data Berhasil di Update');
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
        return redirect('product')->with('status', 'Data Berhasil di Hapus');
    }
}
