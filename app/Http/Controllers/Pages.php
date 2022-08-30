<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class Pages extends Controller
{
    public function dashboard()
    {
        $projects = Project::all();

        return view('dashboard', [
            'username' => 'user',
            'userrole' => 'admin',
            'projects' => $projects
        ]);
    }
}
