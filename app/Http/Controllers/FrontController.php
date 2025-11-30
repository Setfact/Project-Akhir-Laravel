<?php

namespace App\Http\Controllers;

use App\Models\Destination;

class FrontController extends Controller
{
    public function index()
    {
        $destinations = Destination::all();
        return view('welcome', compact('destinations'));
    }

    public function show(Destination $destination)
    {
        return view('destinations.show', compact('destination'));
    }
}