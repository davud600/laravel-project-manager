<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\EmployeeEstimatedTime;
use App\Models\Project;
use App\Models\ProjectEmployee;
use App\Models\User;
use App\Repositories\AdminRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $filters = [
            'query' => $request->get('query'),
            'limit' => ($request->get('limit') ?? 1) * 10
        ];

        return match (auth()->user()->role) {
            2 => AdminRepository::dashboard($filters),
            1 => EmployeeRepository::dashboard($filters),
            0 => CustomerRepository::dashboard($filters)
        };
    }

    public function index(SearchRequest $request)
    {
        $users = $this->user
            ->latest()
            ->filter([
                'query' => $request->get('query'),
                'limit' => ($request->get('limit') ?? 1) * 10,
                'role' => $request->get('role')
            ])
            ->get();

        $roles = DB::table('roles')->get();

        return view('user.list', [
            'users' => $users,
            'roles' => $roles
        ]);
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
