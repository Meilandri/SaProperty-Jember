<?php

namespace App\Http\Controllers;

use App\Support\SiteData;

class HomeController extends Controller
{
    public function index()
    {
        $projects = SiteData::projects()->sortByDesc('date')->take(3)->values();

        return view('pages.home', compact('projects'));
    }
}