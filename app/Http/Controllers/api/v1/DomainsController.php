<?php

namespace App\Http\Controllers\api\v1;

use App\Models\domains;
use App\Http\Controllers\Controller;

class DomainsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(domains::orderBy("id")->get());
    }
}
