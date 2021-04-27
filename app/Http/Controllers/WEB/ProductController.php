<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Umkm;

class ProductController extends Controller
{
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
            'umkm_id'       => 'required',
            'name'          => 'required',
            'description'   => 'required',
            'price'         => 'required',
            'stok'          => 'required',
            'img'           => 'required',
        ]);

        $file       = Request()->img;
        $fileimg    = $file->getClientOriginalName();
        $file       ->move(public_path('img'),$fileimg);

        Product::create([
                'umkm_id'        => $request->umkm_id,
                'name'           => $request->name,
                'description'    => $request->description,
                'price'          => $request->price,
                'stok'           => $request->stok,
                'img'            => $fileimg,
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
            'title'  => 'Detail Data Product',
            'title1' => 'Product',
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
            'umkm_id'       => 'required',
            'name'          => 'required',
            'description'   => 'required',
            'price'         => 'required',
            'stok'          => 'required',
            'img'           => 'required',
        ]);

        if (Request()->img <> "") {
            //Hapus gambar Lama
            $img = Product::where('id',$id)->first();
            if ($img->img <> "") {
                unlink(public_path('img'). '/' .$img->img);
            }

            //jika ingin ganti gambar
            $file       = Request()->img;
            $fileimg = $file->getClientOriginalName();
            $file       ->move(public_path('img'),$fileimg);

            Product::findOrFail($id)->update([
                'umkm_id'        => $request->umkm_id,
                'name'           => $request->name,
                'description'    => $request->description,
                'price'          => $request->price,
                'stok'           => $request->stok,
                'img'            => $fileimg,
        ]);


        } else {

            //Jika tidak ingin mengganti icon
            Product::findOrFail($id)->update([
                'umkm_id'        => $request->umkm_id,
                'name'           => $request->name,
                'description'    => $request->description,
                'price'          => $request->price,
                'stok'           => $request->stok,
                'img'            => $$request->img,
            ]);
        }

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
