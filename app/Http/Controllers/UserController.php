<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\EmployeeEstimatedTime;
use App\Models\Project;
use App\Models\ProjectEmployee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        User $user,
        Project $project,
        EmployeeEstimatedTime $employeeEstimatedTime,
        ProjectEmployee $projectEmployee
    ) {
        $this->user = $user;
        $this->project = $project;
        $this->employeeEstimatedTime = $employeeEstimatedTime;
        $this->projectEmployee = $projectEmployee;
    }

    public function dashboard(SearchRequest $request)
    {
        if (auth()->user() == null) {
            return to_route('login');
        }

        if (auth()->user()->role == 2) {
            $projects = $this->project
                ->filter([
                    'query' => $request->get('query'),
                    'limit' => ($request->get('limit') ?? 1) * 10
                ])
                ->with('customer')
                ->get();

            $employeeActivity = $this->employeeEstimatedTime->getEmployeeActivity(
                withEmployee: true,
                withProject: true
            );

            return view('admin.dashboard', [
                'projects' => $projects,
                'employees_activity' => $employeeActivity
            ]);
        }

        if (auth()->user()->role == 1) {
            $projects = $this->projectEmployee->getProjectsOfEmployee(
                auth()->user()->id,
                filters: [
                    'query' => $request->get('query'),
                    'limit' => ($request->get('limit') ?? 1) * 10
                ]
            );

            $employeeActivity = $this->employeeEstimatedTime->getActivityOfEmployee(
                auth()->user()->id,
                withEmployee: true,
                withProject: true
            );

            return view('employee.dashboard', [
                'projects' => $projects,
                'employees_activity' => $employeeActivity
            ]);
        }

        $projects = $this->project->getProjectsOfCustomer(
            auth()->user()->id,
            filters: [
                'query' => $request->get('query'),
                'limit' => ($request->get('limit') ?? 1) * 10
            ]
        );

        return view('customer.dashboard', [
            'projects' => $projects
        ]);
    }

    public function index(SearchRequest $request)
    {
        $users = $this->user
            ->latest()
            ->filter($request->only('query'))
            ->get();

        return view('user.list', ['users' => $users]);
    }

    public function create()
    {
        return view('user.add');
    }

    public function store(Request $request)
    {
        $newUser = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company' => $request->company,
            'role' => $request->role
        ]);

        return redirect('users/' . $newUser->id . '/edit');
    }

    public function show(User $user)
    {
        return view('user.show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        return view('user.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $user = $this->user->getById($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => isset($request->password) ? Hash::make($request->password) : $user->password,
            'company' => $request->company
        ]);

        return redirect('users/' . $user->id . '/edit');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return to_route('users');
    }
}
