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
            <div class="d-flex gap-5">
                <h5 class="card-title">All Projects</h5>
                <form method="get">
                    <input type="hidden" name="limit" value="{{ request()->get('limit') ?? null }}">
                    <input type="hidden" name="query" value="{{ request()->get('query') ?? null }}">
                    <div class="mt-2 d-flex gap-5">
                        <div class="d-flex gap-1 mb-3">
                            <label class="col-sm-4 col-form-label">Customer: </label>
                            <div class="col-sm-9">
                                <select name="customer" class="form-select" aria-label="Default select example">
                                    <option value="" {{ request()->get('customer') == null ? 'selected':'' }}>Select Customer</option>
                                    @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ request()->get('customer') == $customer->id ? 'selected':'' }}>{{ $customer->name }}</option>
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
                    <td>{{ $project->customer->name }}</td>
                    <td>{{ getHoursAndMinutesFromTime($project->estimated_time) }}</td>
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
            <input type="hidden" name="time_registered" value="{{ request()->get('time_registered') ?? null }}">
            <input type="hidden" name="customer" value="{{ request()->get('customer') ?? null }}">
            <input type="hidden" name="query" value="{{ request()->get('query') ?? null }}">
            <button class="btn btn-outline-primary" type="submit" name="limit" value="{{ (request()->get('limit') ?? 1) + 1}}">
                Show More
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">My Activity</h5>

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
                    <th scope="row">{{ $employee_activity->employee->name }} (me)</th>
                    <td>{{ $employee_activity->project->title }}</td>
                    <td>{{ $employee_activity->description }}</td>
                    <td>{{ $employee_activity->time_added }}</td>
                    <td>{{ $employee_activity->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with hoverable rows -->
    </div>
</div>
@stop