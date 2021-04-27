<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Region;

class RegionController extends Controller
{
    public function getRegion()
    {
//        $search = $request->search;
//      if($search == ''){
//         $region = Region::orderby('name','asc')
//                    ->select('id','name')
//                    ->limit(8)
//                    ->get();
//      }else{
//         $region = Region::orderby('name','asc')
//                    ->select('id','name')
//                    ->where('name', 'like', '%' .$search . '%')
//                    ->limit(8)
//                    ->get();
//      }

        $regions = Region::filter()
            ->{request()->has('simple') ? 'simplePaginate' : 'paginate'}()->appends(request()->query());

      $response = array();
      foreach($regions as $region){
         $response[] = array(
              "id"      =>$region->id,
              "text"    =>$region->full_name
         );
      }

      echo json_encode($response);
      exit;
    }
}
