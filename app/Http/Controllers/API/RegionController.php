<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Region;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RegionController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $regions = Region::filter()
            ->{request()->has('simple') ? 'simplePaginate' : 'paginate'}()->appends(request()->query());
//        $this->authorize('index', 'App\Region');

        return response()->json($regions);
    }
}
