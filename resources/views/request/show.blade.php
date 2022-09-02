@extends('layouts.app')
@section('title')Request {{ $request->title }}@stop

@section('links')
<li class="breadcrumb-item">
    <a href="/dashboard">Dashboard</a>
</li>
<li class="breadcrumb-item">
    <a href="/projects/{{ $project->id }}">{{ $project->title }}</a>
</li>
<li class="breadcrumb-item active">{{ $request->title }}</li>
@stop

@section('content')
<div class="d-flex justify-content-between">
    <h1>{{ $request->title }}</h1>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Request Information</h5>

        <!-- Default List group -->
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Description</span>
                <span class="col-7 text-end">{{ $request->description }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Status</span>
                <span>
                    {!!
                    $request->status == 0 ? '
                    <span class="badge bg-secondary">In Progress</span>' :
                    '
                    <span class="badge bg-success">Finished</span>'
                    !!}
                </span>
            </li>

            @if (auth()->user()->role == 0)
            <div class="mt-4 d-flex justify-content-center">
                <a class="btn btn-secondary ps-4 pe-4" href="/requests/{{ $request->id }}/edit?project_id={{ $project->id }}">Edit</a>
            </div>
            @endif
        </ul><!-- End Default List group -->

    </div>
</div>
@stop