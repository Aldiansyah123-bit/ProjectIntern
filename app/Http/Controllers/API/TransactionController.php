<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaction;
use App\Umkm;
use App\Bumdese;
use App\User;
use PhpParser\Node\Stmt\Return_;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $transaction = Transaction::all();
        return response()->json(['Transaction' => $transaction]);
    }


    public function create(Request $request)
    {
        $request->validate([
            'user_id'           => 'required|string',
            'umkm_id'           => 'required|string',
            'bumdes_id'         => 'required|string',
            'invoice_number'    => 'required',
            'address'           => 'required',
            'total_price'       => 'required',
            'discount'          => 'string|nullable',
            'voucher'           => 'string|nullable',
            'noted'             => 'string|nullable',
            'status'            => 'required',
        ]);

        Transaction::create([
                'user_id'           => $request->user_id,
                'umkm_id'           => $request->umkm_id,
                'bumdes_id'         => $request->bumdes_id,
                'invoice_number'    => $request->invoice_number,
                'address'           => $request->address,
                $total = $request->total_price - ($request->total_price * $request->discount/100) - $request->voucher,
                'total_price'       => $total,
                'discount'          => $request->discount,
                'voucher'           => $request->voucher,
                'noted'             => $request->noted,
                'status'            => $request->status,
        ]);

        return response()->json(['message' => 'Data Add Successfully']);
    }

    public function show($id)
    {
        $transaction = Transaction::where('id',$id)->get();
        return response()->json(['Transaction' => $transaction]);
    }


    public function update(Request $request, $id)
    {
        $transaction = Transaction::where('id',$id)->first();
        $request->validate([
            'user_id'           => 'required|string',
            'umkm_id'           => 'required|string',
            'bumdes_id'         => 'required|string',
            'invoice_number'    => 'required',
            'address'           => 'required',
            'total_price'       => 'required',
            'discount'          => 'string|nullable',
            'voucher'           => 'string|nullable',
            'noted'             => 'string|nullable',
            'status'            => 'required',
        ]);

        Transaction::findOrFail($id)->update([
                'user_id'           => $request->user_id,
                'umkm_id'           => $request->umkm_id,
                'bumdes_id'         => $request->bumdes_id,
                'invoice_number'    => $request->invoice_number,
                'address'           => $request->address,
                $total = $request->total_price - ($request->total_price * $request->discount/100) - $request->voucher,
                'total_price'       => $total,
                'discount'          => $request->discount ?? $transaction->discount,
                'voucher'           => $request->voucher ?? $transaction->voucher,
                'noted'             => $request->noted ?? $transaction->noted,
                'status'            => $request->status,
        ]);

        return response()->json(['message' => 'Data was Successfully Updated']);
    }

    public function destroy($id)
    {
        Transaction::destroy($id);
        return response()->json(['message' => 'Data Successfully Deleted']);
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
}
