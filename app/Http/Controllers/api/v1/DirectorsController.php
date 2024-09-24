<?php

namespace App\Http\Controllers\api\v1;

use App\Models\directors;
use App\Http\Controllers\Controller;

class DirectorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(directors::orderBy("id")->get());
    }
}
