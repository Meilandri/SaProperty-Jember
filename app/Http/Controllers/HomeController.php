<?php

namespace App\Http\Controllers;

use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::published()->orderByDesc('completed_at')->take(3)->get();

        return view('pages.home', compact('projects'));
    }
}