<?php

namespace App\Http\Controllers\api\v1;

use App\Models\genres;
use App\Http\Controllers\Controller;

class GenresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(genres::orderBy("id",)->get());
    }
}
