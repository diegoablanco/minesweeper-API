<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return response()->json(null, 405);
    }

    public function show(Request $request)
    {
        return response()->json(null, 405);
    }

    public function create(Request $request)
    {
        return response()->json(null, 405);
    }

    public function flag(Request $request, $cell)
    {
        return response()->json(null, 405);
    }

    public function reveal(Request $request, $cell)
    {
        return response()->json(null, 405);
    }
}
