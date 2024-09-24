<?php

namespace App\Http\Controllers\api\v1;

use App\Models\cast_members;
use App\Http\Controllers\Controller;

class CastMembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Cast_members::orderBy('id')->get());
    }
}
