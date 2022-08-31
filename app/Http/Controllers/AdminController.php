<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $projects = Project::all();

        return view('admin.dashboard', [
            'projects' => $projects
        ]);
    }
}
