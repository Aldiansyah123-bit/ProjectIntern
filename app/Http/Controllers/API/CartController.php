<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use App\Bumdese;
use App\Umkm;
use App\User;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $cart = Cart::all();
        return response()->json(['Cart' => $cart]);
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

        return response()->json(['message' => 'Data Added Successfully']);
    }

    public function show($id)
    {
        $cart = Cart::where('id',$id)->get();

        return response()->json([
            'Cart' => $cart
        ]);
    }

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

        return response()->json(['message' => 'Data was Successfully Updated']);
    }

    public function destroy($id)
    {
        Cart::destroy($id);
        return response()->json(['message' => 'Data successfully Deleted']);
    }
}
