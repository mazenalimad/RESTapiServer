<?php

namespace App\Http\Controllers\api\v1;

use App\Models\languages;
use App\Http\Controllers\Controller;

class LanguagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(languages::orderBy("id")->get());
    }
}
