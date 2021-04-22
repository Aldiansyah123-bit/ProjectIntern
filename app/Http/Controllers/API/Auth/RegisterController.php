<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends Controller
{
    public $successStatus = 200;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name'          => 'required',
            'region_id'     => 'required',
            'address'       => 'required',
            'email'         => 'required|email',
            'password'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }


        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        return response()->json([
            'message' => 'Register Berhasil'
        ]);
    }


}
