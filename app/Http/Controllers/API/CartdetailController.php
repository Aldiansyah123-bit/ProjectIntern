<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cartdetail;
use Illuminate\Support\Facades\Auth;

class CartdetailController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {

        $cartdetail = Cartdetail::all();
        return response()->json(['Cartdetail' => $cartdetail]);
    }
    public function show($id)
    {
        $cartdetail = Cartdetail::where('id',$id)->get();
        return response()->json(['Cartdetail' => $cartdetail]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'cart_id'   => 'required',
            'product_id'=> 'required',
            'amount'    => 'required',
            'flag'      => 'string|nullable',
        ]);

        Cartdetail::create([
            'cart_id'   => $request->cart_id,
            'product_id'=> $request->product_id,
            'amount'    => $request->amount,
            'flag'      => $request->flag,
        ]);

        return response()->json(['message' => 'Data Added Successfully']);
    }

    public function update(Request $request, $id)
    {
        $cartdetail = Cartdetail::where('id',$id)->first();
        $request->validate([
            'cart_id'   => 'required',
            'product_id'=> 'required',
            'amount'    => 'required',
            'flag'      => 'string|nullable',
        ]);

        Cartdetail::findOrFail($id)->update([
                'cart_id'   => $request->cart_id,
                'product_id'=> $request->product_id,
                'amount'    => $request->amount,
                'flag'      => $request->flag ?? $cartdetail->flag,
        ]);

        return response()->json(['message' => 'Data was Successfully Updated']);
    }

    public function destroy($id)
    {
        Cartdetail::destroy($id);
        return response()->json(['message' => 'Data successfully Deleted']);
    }
}
