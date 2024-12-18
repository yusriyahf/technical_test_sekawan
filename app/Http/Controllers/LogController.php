<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $data = Log::all();
        return view('log.index', ['data' => $data]);
    }
}
