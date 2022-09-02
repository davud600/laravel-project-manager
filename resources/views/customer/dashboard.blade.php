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
        <h5 class="card-title">My Projects</h5>

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
                    <td>{{ $project->customer_id }}</td>
                    <td>{{ $project->estimated_time }}</td>
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
    </div>
</div>
@stop