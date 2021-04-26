<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bumdese;

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

    public function detail($id)
    {
        $bumdes = Bumdese::where('id',$id)->get();

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

        $file       = Request()->avatar;
        $fileavatar = $file->getClientOriginalName();
        $file       ->move(public_path('avatar'),$fileavatar);

        $file       = Request()->background;
        $filebackground = $file->getClientOriginalName();
        $file       ->move(public_path('background'),$filebackground);

        Bumdese::create([
            'name'          => $request->name,
            'region_id'     => $request->region_id,
            'address'       => $request->address,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'phone'         => $request->phone,
            'avatar'        => $fileavatar,
            'background'    => $filebackground,
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

        if (Request()->avatar <> "") {
            //Hapus gambar Lama
            $bumdes = Bumdese::where('id',$id)->first();
            if ($bumdes->avatar <> "") {
                unlink(public_path('avatar'). '/' .$bumdes->avatar);
            }
        }
        if (Request()->background <> "") {
            //Hapus gambar Lama
            $bumdes = Bumdese::where('id',$id)->first();
            if ($bumdes->avatar <> "") {
                unlink(public_path('background'). '/' .$bumdes->background);
            }

            //jika ingin ganti gambar
            $file       = Request()->avatar;
            $fileavatar = $file->getClientOriginalName();
            $file       ->move(public_path('avatar'),$fileavatar);

            $file       = Request()->background;
            $filebackground = $file->getClientOriginalName();
            $file       ->move(public_path('background'),$filebackground);

            Bumdese::findOrFail($id)->update([
                'name'          => $request->name,
                'region_id'     => $request->region_id,
                'address'       => $request->address,
                'latitude'      => $request->latitude,
                'longitude'     => $request->longitude,
                'phone'         => $request->phone,
                'avatar'        => $fileavatar,
                'background'    => $filebackground,
            ]);

        } else {

            //Jika tidak ingin mengganti icon
            Bumdese::findOrFail($id)->update([
                'name'          => $request->name,
                'region_id'     => $request->region_id,
                'address'       => $request->address,
                'latitude'      => $request->latitude,
                'longitude'     => $request->longitude,
                'phone'         => $request->phone,
                'avatar'        => $request->avatar,
                'background'    => $request->background,
            ]);
        }

        return response()->json(['message' => 'Data Berhasil di Update']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bumdes = Bumdese::where('id',$id)->first();

        if ($bumdes->avatar <> "") {
            unlink(public_path('avatar'). '/' .$bumdes->avatar);
        }
        if ($bumdes->background <> "") {
            unlink(public_path('background'). '/' .$bumdes->background);
        }
        Bumdese::destroy($id);
        return response()->json([
            'message' => 'Data Berhasil di Hapus'
        ]);
    }
}
