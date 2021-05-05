<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransactionDetail;
use App\Transaction;
use App\Product;
use Illuminate\Support\Facades\DB;

class TransactiondetailController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $data = [
            'title'     => 'Data Transaction Detail',
            'title1'    => 'Transaction Detail',
            'transaction' => DB::table('transactions')->count(),
            'cart'  => DB::table('carts')->count(),
        ];
        $transdel = TransactionDetail::all();
        return view('transdel.index',compact('transdel'), $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'transaction_id'    => 'required|string',
            'product_id'        => 'required|string',
            'price'             => 'required|string',
            'amount'            => 'required|integer',
            'flag'              =>  'string|nullable',
        ]);

        TransactionDetail::create([
            'transaction_id'    => $request->transaction_id,
            'product_id'        => $request->product_id,
            'price'             => $request->price,
            'amount'            => $request->amount,
            'flag'              => $request->flag,
        ]);

        return redirect('transdel')->with('status', 'Data Berhasil di Tambah');
    }

    public function store()
    {
        $data = [
            'title' => 'Tambah Data Transaction Detail',
            'title1' => 'Transaction Detail'
        ];
        return view('transdel.add',$data);
    }

    public function show($id)
    {
        $transdel = TransactionDetail::where('id', $id)->get();
        return view('transdel.detail',compact('transdel'));
    }

    public function edit($id)
    {
        $data = [
            'title'  => 'Edit Data Transaction Detail',
            'title1' => 'Transaction Detail',
        ];
        $transdel = TransactionDetail::where('id',$id)->first();
        return view('transdel.edit', compact('transdel'), $data);
    }


    public function update(Request $request, $id)
    {
        $transdel = TransactionDetail::where('id',$id)->first();
        $request->validate([
            'transaction_id'    => 'required|string',
            'product_id'        => 'required|string',
            'price'             => 'required|string',
            'amount'            => 'required|integer',
            'flag'              =>  'string|nullable',
        ]);

        TransactionDetail::findOrFail($id)->update([
            'transaction_id'    => $request->transaction_id,
            'product_id'        => $request->product_id,
            'price'             => $request->price,
            'amount'            => $request->amount,
            'flag'              => $request->flag ?? $transdel->flag,
        ]);

        return redirect('transdel')->with('status', 'Data Berhasil di Update');
    }


    public function destroy($id)
    {
        TransactionDetail::destroy($id);
        return redirect('transdel')->with('status', 'Data berhasil di Hapus');
    }


    public function getTransaction(Request $request)
    {

        $search = $request->search;

        if($search == ''){
            $trans = Transaction::orderby('id','asc')
                                ->select('id','id')
                                ->limit(8)
                                ->get();
        }else{
            $trans = Transaction::orderby('id','asc')
                                ->select('id','id')
                                ->where('id', 'like', '%' .$search . '%')
                                ->limit(8)
                                ->get();
        }

        $response = array();
        foreach($trans as $transaction){
            $response[] = array(
                "id"      =>$transaction->id,
                "text"    =>$transaction->id
            );

        }

        echo json_encode($response);
        exit;
    }

    public function getProduct(Request $request)
    {

        $search = $request->search;

        if($search == ''){
            $product = Product::orderby('name','asc')
                            ->select('id','name')
                            ->limit(8)
                            ->get();
        }else{
            $product = Product::orderby('name','asc')
                            ->select('id','name')
                            ->where('name', 'like', '%' .$search . '%')
                            ->limit(8)
                            ->get();
        }

        $response = array();
        foreach($product as $products){
            $response[] = array(
                "id"      =>$products->id,
                "text"    =>$products->name
            );

        }

        echo json_encode($response);
        exit;
    }

}
