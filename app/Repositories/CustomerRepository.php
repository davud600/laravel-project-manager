<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Contracts\View\View;

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
            'projects' => $projects
        ]);
    }
}
