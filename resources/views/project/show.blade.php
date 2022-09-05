@extends('layouts.app')
@section('title')Project {{ $project->title }}@stop

@section('links')
<li class="breadcrumb-item">
    <a href="/dashboard">Dashboard</a>
</li>
<li class="breadcrumb-item active">{{ $project->title }}</li>
@stop

@section('content')
<div class="d-flex justify-content-between">
    <h1>{{ $project->title }}</h1>
    @can('create-requests')
    <a class="mb-4 me-3 btn btn-outline-success" href="/requests/create?project_id={{ $project->id }}">
        <span>Create Request</span>
    </a>
    @endcan

</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Project Information</h5>

        <!-- Default List group -->
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Description</span>
                <span class="col-7 text-end">{{ $project->description }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Status</span>
                <span>
                    {!!
                    $project->status == 0 ? '
                    <span class="badge bg-secondary">In Progress</span>' :
                    '
                    <span class="badge bg-success">Finished</span>'
                    !!}
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Customer</span>
                <span>{{ getUserNameFromId($project->customer_id) }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Employees</span>
                <div>
                    @foreach ($employees as $employee)
                    <span>{{ $employee->name }},&nbsp;&nbsp;</span>
                    @endforeach
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Estimated Time</span>
                <div class="gap-3 form-group d-flex justify-content-end">
                    @can('add-time-to-projects')
                    <form class="d-flex w-75 gap-2" action="{{ $project->id}}/change-estimated-time" method="post">
                        @csrf()
                        @method('POST')
                        <label for="description" class="fw-light mt-2">Description</label>
                        <input type="text" class="form-control" name="description" id="description">
                        <input min="0" type="number" class="form-control ms-2 w-50" name="hours" id="hours">
                        <label for="hours" class="fw-light mt-2">Hr</label>
                        <input min="0" type="number" class="form-control w-50" name="minutes" id="minutes">
                        <label for="minutes" class="fw-light mt-2">Min</label>
                        <input type="submit" class="btn btn-primary w-50" value="Add Time">
                    </form>
                    @endcan
                    <span class="mt-2">
                        {{ getHoursAndMinutesFromTime($project->estimated_time) }}
                    </span>
                </div>
            </li>

            @can('edit-projects')
            <div class="mt-4 d-flex justify-content-center">
                <a class="btn btn-secondary ps-4 pe-4" href="/projects/{{ $project->id }}/edit">Edit</a>
            </div>
            @endcan
        </ul><!-- End Default List group -->

    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Project Requests</h5>

        <!-- Table with hoverable rows -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Subject</th>
                    <th scope="col">Content</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($project_requests as $request)
                <tr>
                    <th>{{ $request->title }}</th>
                    <td>{{ $request->description }}</td>
                    <td>
                        {!!
                        $request->status == 0 ? '
                        <span class="badge bg-secondary">Under Review</span>' :
                        '
                        <span class="badge bg-success">Approved</span>'
                        !!}
                    </td>
                    <td>
                        <a class="btn btn-primary" href="/requests/{{ $request->id }}">View</a>
                        @can('change-status-requests')
                        @if ($request->status == 0)
                        <a class="btn btn-success" href="/requests/{{ $request->id }}/change-status">Approve</a>
                        @else
                        <a class="btn btn-danger" href="/requests/{{ $request->id }}/change-status">Cancel</a>
                        @endif
                        @endcan
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
        <h5 class="card-title">Project Employees Activity</h5>

        <!-- Table with hoverable rows -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Employee</th>
                    <th scope="col">Description</th>
                    <th scope="col">Time added</th>
                    <th scope="col">Added at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees_activity as $employee_activity)
                <tr>
                    <th scope="row">
                        @if (auth()->user()->id == $employee_activity->employee_id)
                        (me)
                        @endif
                        {{ getUserNameFromId($employee_activity->employee_id) }}
                    </th>
                    <td>{{ $employee_activity->description }}</td>
                    <td>
                        @if ($employee_activity->created_by_admin)
                        (UPDATED)
                        @endif
                        {{ getHoursAndMinutesFromTime($employee_activity->time_added) }}
                    </td>
                    <td>{{ $employee_activity->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with hoverable rows -->
    </div>
</div>
@stop