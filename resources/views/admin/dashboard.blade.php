@extends('layouts.app')
@section('title')All Projects@stop

@section('links')
<li class="breadcrumb-item active">Dashboard</li>
@stop

@section('content')
<div class="d-flex justify-content-between">
    <h1 class="">Dashboard</h1>
    <div>
        <a class="mb-4 me-3 btn btn-outline-primary" href="/users">
            <span>Users</span>
        </a>
        <a class="mb-4 me-3 btn btn-outline-success" href="/projects/create">
            <span>Add Project</span>
        </a>
        <a class="mb-4 me-3 btn btn-outline-secondary" href="/projects/archive">
            <span>Project Archive</span>
        </a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="d-flex flex-row justify-content-between">
            <h5 class="card-title">All Projects</h5>
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
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Estimated Time</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Action</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                <tr>
                    <th>{{ $project->title }}</th>
                    <td>
                        {!! $project->status == 0 ?
                        '<span class="badge bg-secondary">In Progress</span>':
                        '<span class="badge bg-success">Finished</span>'
                        !!}
                    </td>
                    <td>{{ $project->customer->name }}</td>
                    <td>{{ getHoursAndMinutesFromTime($project->estimated_time) }}</td>
                    <td>{{ $project->created_at }}</td>
                    <td>
                        <a class="btn btn-primary" href="/projects/{{ $project->id }}">View</a>
                    </td>
                    <td>
                        <form action="/projects/{{ $project->id }}" method="post">
                            @csrf()
                            @method('DELETE')
                            <input type="submit" class="btn ps-2 pe-2 pt-0 pb-0" value="x">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with hoverable rows -->
        <form method="get">
            <input type="hidden" name="query" value="{{ request()->get('query') ?? null }}">
            <button class="btn btn-outline-primary" type="submit" name="limit" value="{{ (request()->get('limit') ?? 1) + 1}}">
                Show More
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Employees Activity</h5>

        <!-- Table with hoverable rows -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Employee</th>
                    <th scope="col">Project</th>
                    <th scope="col">Description</th>
                    <th scope="col">Time added</th>
                    <th scope="col">Added at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees_activity as $employee_activity)
                <tr>
                    <th scope="row">{{ $employee_activity->employee->name }}</th>
                    <td>{{ $employee_activity->project->title }}</td>
                    <td>{{ $employee_activity->description }}</td>
                    <td>{{ getHoursAndMinutesFromTime($employee_activity->time_added) }}</td>
                    <td>{{ $employee_activity->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with hoverable rows -->
    </div>
</div>
@stop