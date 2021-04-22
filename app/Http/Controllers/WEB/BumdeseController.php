<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bumdese;
use App\Region;

class BumdeseController extends Controller
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
            'title'  => 'Data Bumdes',
            'title1' => 'BUMDES',
        ];
        $bumdes = Bumdese::all();
        return view('bumdes.index', compact('bumdes'), $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'name'       => 'required',
            'region_id'  => 'required',
            'address'    => 'required',
            'latitude'   => 'required',
            'longitude'  => 'required',
            'phone'      => 'required',
            'avatar'     => 'required',
            'background' => 'required',
        ]);

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

        return redirect('bumdes')->with('status', 'Data Berhasil di Tambah');
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
            'title' => 'Tambah Data Bumdes',
            'title1' => 'BUMDES',
        ];

        $region = Region::all();
        return view('bumdes.add',compact('region'),$data);
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
        Bumdese::destroy($id);
        return redirect('bumdes')->with('status', 'Data Berhasil di Hapus');
    }
}
