<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use App\Umkm;
use App\Bumdese;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data Transaction',
            'title1'=> 'Transaction'
        ];
        $transaction = Transaction::all();
        return view('transaction.index',compact('transaction'),$data);
    }

    public function detail($id)
    {
        $transaction       = Transaction::where('id',$id)->get();
        return view('cart.detail', compact('transaction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'user_id'           => 'required',
            'umkm_id'           => 'required',
            'bumdes_id'         => 'required',
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

        return redirect('/transaction')->with('status', 'Data Berhasil di Tambah');
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
            'title' => 'Tambah Data Transaction',
            'title1' => 'Transaction'
        ];
        return view('transaction.add',$data);
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
            'title'  => 'Edit Data Transaction',
            'title1' => 'Transaction',
        ];
        $transaction = Transaction::where('id',$id)->first();
        return view('transaction.edit', compact('transaction'), $data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaction::destroy($id);
        return redirect('transaction')->with('status', 'Data Berhasil di Delete');
    }
}
