<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements RepositoryInterface
{
    static public function dashboard(array $filters): View
    {
        $project = new Project;

        $projects = $project->getProjectsOfCustomer(
            auth()->user()->id,
            filters: $filters
        );

        return view('customer.dashboard', [
            'projects' => $projects,
            'customers' => User::where('role', 3)->get()
        ]);
    }
}
