<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bumdese;
use Validator;

class BumdesController extends Controller
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
        $bumdes = Bumdese::all();
        return response()->json([
            'Bumdes' => $bumdes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name'          => 'required',
            'region_id'     => 'required',
            'address'       => 'required',
            'latitude'      => 'required|decimal',
            'longitude'     => 'required|decimal',
            'phone'         => 'required',
            'avatar'        => 'required',
            'background'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),404]);
        }

        Bumdese::create([
            'name'          => $request->name,
            'region_id'     => $request->region_id,
            'address'       => $request->address,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'phone'         => $request->phone,
            'avatar'        => $request->avatar,
            'background'    => $request->background,
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
        $validator = Validator::make($request->all(),
        [
            'name'          => 'required',
            'region_id'     => 'required',
            'address'       => 'required',
            'latitude'      => 'required|decimal',
            'longitude'     => 'required|decimal',
            'phone'         => 'required',
            'avatar'        => 'required',
            'background'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),404]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bumdese::destroy($id);
        return response()->json([
            'message' => 'Data Berhasil di Hapus'
        ]);
    }
}
