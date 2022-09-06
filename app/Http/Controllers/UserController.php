<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\EmployeeEstimatedTime;
use App\Models\Project;
use App\Models\ProjectEmployee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function importUsers()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function dashboard()
    {
        if (auth()->user() == null) {
            return to_route('login');
        } else if (auth()->user()->role == 2) {
            $projects = Project::all();
            $employees_activity = EmployeeEstimatedTime::where('created_by_admin', false)
                ->get();

            return view('admin.dashboard', [
                'projects' => $projects,
                'employees_activity' => $employees_activity
            ]);
        } else if (auth()->user()->role == 1) {
            $employee_project_ids = array_column(
                ProjectEmployee::where(
                    'employee_id',
                    auth()->user()->id
                )->get()->toArray(),
                'project_id'
            );

            $projects = Project::where('id', $employee_project_ids)->get();

            $employees_activity = EmployeeEstimatedTime::where(
                'employee_id',
                auth()->user()->id
            )->get();

            return view('employee.dashboard', [
                'projects' => $projects,
                'employees_activity' => $employees_activity
            ]);
        }

        $projects = Project::where(
            'customer_id',
            auth()->user()->id
        )->get();

        return view('customer.dashboard', [
            'projects' => $projects
        ]);
    }

    public function index()
    {
        $users = User::all();
        return view('user.list', ['users' => $users]);
    }

    public function create()
    {
        return view('user.add');
    }

    public function store(Request $request)
    {
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company' => $request->company,
            'role' => $request->role
        ]);

        return redirect('users/' . $newUser->id . '/edit');
    }

    public function show(int $user_id)
    {
        $user = User::where('id', $user_id)->first();

        return view('user.show', [
            'user' => $user
        ]);
    }

    public function edit(int $user_id)
    {
        $user = User::where('id', $user_id)->first();

        return view('user.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, int $user_id)
    {
        $user = User::where('id', $user_id)->first();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => isset($request->password) ? Hash::make($request->password) : $user->password,
            'company' => $request->company,
            'role' => $request->role
        ]);

        return redirect('users/' . $user->id . '/edit');
    }

    public function destroy(User $user)
    {
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
