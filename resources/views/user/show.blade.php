@extends('layouts.app')
@section('title')User {{ $user->name }}@stop

@section('links')
<li class="breadcrumb-item">
    <a href="/dashboard">Dashboard</a>
</li>
<li class="breadcrumb-item">
    <a href="/users">Users</a>
</li>
<li class="breadcrumb-item active">{{ $user->name }}</li>
@stop

@section('content')
<h1>{{ $user->name }}</h1>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">User Information</h5>

        <!-- Default List group -->
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Name</span>
                <span class="col-7 text-end">{{ $user->name }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Email</span>
                <span class="col-7 text-end">{{ $user->email }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Role</span>
                <span>
                    {{
                        $user->role == 0 ? 'Customer' : ($user->role == 1 ? 'Employee': 'Admin')
                    }}
                </span>
            </li>

            <div class="mt-4 d-flex justify-content-center">
                <a class="btn btn-secondary ps-4 pe-4" href="/users/{{ $user->id }}/edit">Edit</a>
            </div>
        </ul><!-- End Default List group -->

    </div>
</div>
@stop