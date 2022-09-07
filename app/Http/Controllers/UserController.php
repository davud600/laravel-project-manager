<?php

namespace App\Http\Controllers;

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

    public function dashboard()
    {
        if (auth()->user() == null) {
            return to_route('login');
        }

        if (auth()->user()->role == 2) {
            $projects = $this->project->with('customer')->get();
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
            $employeeProjectIds = array_column(
                $this->projectEmployee->getProjectsOfEmployee(
                    auth()->user()->id
                )->toArray(),
                'project_id'
            );

            $projects = $this->project->getProjectsFromIds(
                $employeeProjectIds,
                withCustomer: true
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
            auth()->user()->id
        );

        return view('customer.dashboard', [
            'projects' => $projects
        ]);
    }

    public function index()
    {
        $users = $this->user->all();
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

    public function show(int $id)
    {
        $user = $this->user->getById($id);

        return view('user.show', [
            'user' => $user
        ]);
    }

    public function edit(int $id)
    {
        $user = $this->user->getById($id);

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

    public function destroy(int $id)
    {
        $user = $this->user->getById($id);
        $user->delete();

        return to_route('users');
    }

    public function profile()
    {
        if (auth()->user() == null) {
            return to_route('login');
        }

        return view('user.profile');
    }
}
