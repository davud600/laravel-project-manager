@extends('layouts.app')
@section('title')All Users@stop

@section('links')
<li class="breadcrumb-item">
    <a href="/dashboard">Dashboard</a>
</li>
<li class="breadcrumb-item active">Users</li>
@stop

@section('content')
<div class="d-flex justify-content-between">
    <h1>Users</h1>
    <div>
        <a class="mb-4 me-3 btn btn-outline-secondary" href="/users/archive">
            <span>User Archive</span>
        </a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Users List</h5>

        <!-- Table with hoverable rows -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Company</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        {{
                            $user->role == 0 ? 'Customer' : ($user->role == 1 ? 'Employee': 'Admin')
                        }}
                    </td>
                    <td>{{ $user->company }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <a class="btn btn-primary" href="/users/{{ $user->id }}">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with hoverable rows -->
    </div>
</div>
@stop