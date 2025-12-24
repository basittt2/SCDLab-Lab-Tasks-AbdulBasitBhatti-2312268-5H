<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // Function for Home page
    public function home()
    {
        return view('home');
    }

    // Function for About page
    public function about()
    {
        return view('about');
    }

    // Function for Contact Us page
    public function contact()
    {
        return view('contact');
    }
}

