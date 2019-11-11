<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class bookController extends Controller
{
    public function index()
    {
        $halaman = 'Halaman Utama';
        return view('welcome',compact('halaman'));
    }
}
