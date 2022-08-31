@extends('layouts.app')
@section('title')Project {{ $project->title }}@stop

@section('links')
<li class="breadcrumb-item">
    <a href="/dashboard">Dashboard</a>
</li>
<li class="breadcrumb-item active">{{ $project->title }}</li>
@stop

@section('content')
<h1>{{ $project->title }}</h1>
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
                    <?php
                    echo $project['status'] == 0 ? '
                    <span class="badge bg-secondary">In Progress</span>' :
                        '
                    <span class="badge bg-success">Finished</span>'
                    ?>
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Customer</span>

            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Employees</span>
                <div>
                    <?php foreach ($employees as $employee) { ?>
                        <span><?= $employee['name'] ?>,</span>
                    <?php } ?>
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Estimated Time</span>
                <div class="gap-3 form-group d-flex">
                    <span class="mt-2">
                        <?php
                        $hrs = floor($project['estimated_time'] / 60);
                        $min = $project['estimated_time'] % 60;

                        if (strlen($hrs) == 1) {
                            echo '0';
                        }
                        echo $hrs . ':';

                        if (strlen($min) == 1) {
                            echo '0';
                        }
                        echo $min;
                        ?>
                    </span>
                </div>
            </li>

            <div class="mt-4 d-flex justify-content-center">
                <a class="btn btn-secondary ps-4 pe-4" href="/projects/{{ $project->id }}/edit">Edit</a>
            </div>
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
                    <th scope="col">#</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Content</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
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

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Project Employees Activity</h5>

        <!-- Table with hoverable rows -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Employee</th>
                    <th scope="col">Project</th>
                    <th scope="col">Description</th>
                    <th scope="col">Time</th>
                    <th scope="col">Added at</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">$project->id</th>
                    <td>$project->title</td>
                    <td>$project->status</td>
                    <td>$project->estimated_time</td>
                    <td>a</td>
                </tr>
            </tbody>
        </table>
        <!-- End Table with hoverable rows -->
    </div>
</div>
@stop