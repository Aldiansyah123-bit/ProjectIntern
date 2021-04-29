<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use App\Bumdese;
use App\Umkm;
use App\User;
use App\Cartdetail;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data Cart',
            'title1'=> 'Cart',
        ];

        $cart = Cart::all();
        return view('cart.index',compact('cart'),$data);
    }

    public function detail($id)
    {
        $cart       = Cart::where('id',$id)->get();
        $cartdetails = Cartdetail::where('cart_id', $id)->get();
        return view('cart.detail', compact('cart', 'cartdetails'));
    }


    public function create(Request $request)
    {
        $request->validate([
            'user_id'       => 'required',
            'umkm_id'       => 'required',
            'bumdes_id'     => 'required',
            'is_checkout'   => 'string|nullable',
        ]);

        Cart::create([
            'user_id'       => $request->user_id,
            'umkm_id'       => $request->umkm_id,
            'bumdes_id'     => $request->bumdes_id,
            'is_checkout'   => $request->is_checkout,
        ]);

        return redirect('/cart')->with('status', 'Data Berhasil di Tambah');
    }

    public function getAddUser(Request $request)
    {

        $search = $request->search;

        if($search == ''){
            $user = User::orderby('name','asc')
                        ->select('id','name')
                        ->limit(8)
                        ->get();
        }else{
            $user = User::orderby('name','asc')
                        ->select('id','name')
                        ->where('name', 'like', '%' .$search . '%')
                        ->limit(8)
                        ->get();
        }

        $response = array();
        foreach($user as $users){
            $response[] = array(
                "id"      =>$users->id,
                "text"    =>$users->name
            );
        }

        echo json_encode($response);
        exit;
    }


    public function getAddUmkm(Request $request)
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

      public function getAddBumdes(Request $request)
      {

          $search = $request->search;

          if($search == ''){
              $bumdes = Bumdese::orderby('name','asc')
                            ->select('id','name')
                            ->limit(8)
                            ->get();
          }else{
              $bumdes = Bumdese::orderby('name','asc')
                            ->select('id','name')
                            ->where('name', 'like', '%' .$search . '%')
                            ->limit(8)
                            ->get();
          }

          $response = array();
          foreach($bumdes as $bumdeses){
              $response[] = array(
                  "id"      =>$bumdeses->id,
                  "text"    =>$bumdeses->name
              );
          }

          echo json_encode($response);
          exit;
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
            'title' => 'Tambah Data Cart',
            'title1' => 'Cart'
        ];
        return view('cart.add',$data);
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
            'title'  => 'Edit Data Cart',
            'title1' => 'Cart',
        ];
        $cart = Cart::where('id',$id)->first();
        return view('cart.edit', compact('cart'), $data);
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
            'user_id'       => 'required',
            'umkm_id'       => 'required',
            'bumdes_id'     => 'required',
            'is_checkout'   => 'string|nullable',
        ]);

        Cart::findOrFail($id)->update([
            'user_id'       => $request->user_id,
            'umkm_id'       => $request->umkm_id,
            'bumdes_id'     => $request->bumdes_id,
            'is_checkout'   => $request->is_checkout,
        ]);

        return redirect('cart')->with('status', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::destroy($id);
        return redirect('cart')->with('status', 'Data Berhasil di Delete');
    }
}
