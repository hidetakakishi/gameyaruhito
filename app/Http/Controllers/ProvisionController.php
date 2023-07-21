<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProvisionController extends Controller
{
    public function index(Request $request)
    {
        return view('provision');
    }
}
