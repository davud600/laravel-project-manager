<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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
            'role' => $request->role
        ]);

        return redirect('users/' . $newUser->id . '/edit');
    }

    public function show($user_id)
    {
        $user = User::where('id', $user_id)->first();

        return view('user.show', [
            'user' => $user
        ]);
    }

    public function edit($user_id)
    {
        $user = User::where('id', $user_id)->first();

        return view('user.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, $user_id)
    {
        $user = User::where('id', $user_id)->first();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => isset($request->password) ? Hash::make($request->password) : $user->password
        ]);

        return redirect('users/' . $user->id . '/edit');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('users/');
    }

    public function profile()
    {
        return view('user.profile');
    }
}
