@extends('layouts.app')
@section('title')My Projects@stop

@section('links')
<li class="breadcrumb-item active">Dashboard</li>
@stop

@section('content')
<div class="d-flex justify-content-between">
    <h1 class="">Dashboard</h1>
</div>
<div class="card">
    <div class="card-body">
        <div class="d-flex flex-row justify-content-between">
            <h5 class="card-title">My Projects</h5>
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
                    <td>{{ auth()->user()->name }}</td>
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
        <form method="get">
            <input type="hidden" name="query" value="{{ request()->get('query') ?? null }}">
            <button class="btn btn-outline-primary" type="submit" name="limit" value="{{ (request()->get('limit') ?? 1) + 1}}">
                Show More
            </button>
        </form>
    </div>
</div>
@stop