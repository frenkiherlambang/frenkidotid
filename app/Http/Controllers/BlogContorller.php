<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogContorller extends Controller
{
    public function index()
    {
        return view('blog.index');
    }
}
