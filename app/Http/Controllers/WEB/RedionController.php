<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Region;

class RedionController extends Controller
{
    public function getRegion(Request $request)
    {

        $search = $request->search;

      if($search == ''){
         $region = Region::orderby('name','asc')
                    ->select('id','name')
                    ->limit(8)
                    ->get();
      }else{
         $region = Region::orderby('name','asc')
                    ->select('id','name')
                    ->where('name', 'like', '%' .$search . '%')
                    ->limit(8)
                    ->get();
      }

      $response = array();
      foreach($region as $regions){
         $response[] = array(
              "id"      =>$regions->id,
              "text"    =>$regions->name
         );
      }

      echo json_encode($response);
      exit;
    }
}
