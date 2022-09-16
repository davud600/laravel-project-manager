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
        <div class="d-flex flex-row justify-content-between">
            <div class="d-flex gap-5">
                <h5 class="card-title">Users List</h5>
                <form method="get">
                    <input type="hidden" name="limit" value="{{ request()->get('limit') ?? null }}">
                    <input type="hidden" name="query" value="{{ request()->get('query') ?? null }}">
                    <div class="mt-2 d-flex gap-5">
                        <div class="d-flex gap-1 mb-3">
                            <label class="col-sm-3 col-form-label">Role: </label>
                            <div class="col-sm-10">
                                <select name="role" class="form-select" aria-label="Default select example">
                                    <option value="" {{ request()->get('role') == null ? 'selected':'' }}>Select Role</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ request()->get('role') == $role->id ? 'selected':'' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex gap-1 mb-3">
                            <label class="col-sm-5 col-form-label">Registered: </label>
                            <div class="col-sm-8">
                                <select name="time_registered" class="form-select" aria-label="Default select example">
                                    <option value="" {{ request()->get('time_registered') == null ? 'selected':'' }}>Select Time</option>
                                    <option value="7" {{ request()->get('time_registered') == 7 ? 'selected':'' }}>7 Days ago</option>
                                    <option value="14" {{ request()->get('time_registered') == 14 ? 'selected':'' }}>14 Days ago</option>
                                    <option value="21" {{ request()->get('time_registered') == 21 ? 'selected':'' }}>21 Days ago</option>
                                    <option value="28" {{ request()->get('time_registered') == 28 ? 'selected':'' }}>28 Days ago</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <input type="submit" value="Search" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
            @if (request()->query('limit') !== null && request()->query('limit') > 1)
            <div class="mt-2">
                <a class="btn btn-outline-secondary" href="{{ url()->current() }}?{{ http_build_query(request()->query()) }}&limit=1">Show Less</a>
            </div>
            @endif
        </div>

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
        <form method="get">
            <input type="hidden" name="time_registered" value="{{ request()->get('time_registered') ?? null }}">
            <input type="hidden" name="role" value="{{ request()->get('role') ?? null }}">
            <input type="hidden" name="query" value="{{ request()->get('query') ?? null }}">
            <button class="btn btn-outline-primary" type="submit" name="limit" value="{{ (request()->get('limit') ?? 1) + 1}}">
                Show More
            </button>
        </form>
    </div>
</div>
@stop