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
        <h5 class="card-title">All Projects</h5>

        <!-- Table with hoverable rows -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col">Estimated Time</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->title }}</td>
                    <td>
                        {!! $project->status == 0 ?
                        '<span class="badge bg-secondary">In Progress</span>':
                        '<span class="badge bg-success">Finished</span>'
                        !!}
                    </td>
                    <td>{{ $project->estimated_time }}</td>
                    <td>{{ $project->created_at }}</td>
                    <td>
                        <a class="btn btn-primary" href="/projects/{{ $project->id }}">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with hoverable rows -->
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
                <tr>
                    <th scope="row">$project->id</th>
                    <td>$project->title</td>
                    <td>$project->status</td>
                    <td>$project->estimated_time</td>
                    <td>
                        <a class="btn btn-primary" href="">View</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Table with hoverable rows -->
    </div>
</div>
@stop