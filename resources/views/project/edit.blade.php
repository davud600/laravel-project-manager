@extends('layouts.app')
@section('title'){{ $project->title }}@stop

@section('links')
<li class="breadcrumb-item">
    <a href="/dashboard">Dashboard</a>
</li>
<li class="breadcrumb-item">
    <a href="/projects/{{ $project->id }}">{{ $project->title }}</a>
</li>
<li class="breadcrumb-item active">Edit Project</li>
@stop

@section('content')
<h1>Update {{ $project->title }}</h1>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Project</h5>

        <!-- Floating Labels Form -->
        <form class="row g-3" method="post" action="/projects/{{ $project->id }}">
            @csrf
            @method('PUT')
            <div class="col-md-8">
                <div class="form-floating">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Project Title" value="{!! $project->title !!}" required>
                    <label for="title">Project Title</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3 form-floating">
                    <select name="customer" class="form-select" id="floatingSelect" aria-label="State">
                    </select>
                    <label for="floatingSelect">Customer</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="description" name="description" placeholder="Project Description" value="{!! $project->description !!}">
                    <label for="description">Project Description</label>
                </div>
            </div>

            <div class="col-md-3">
                <label class="mt-3 mb-2 ms-2">Estimated Time</label>
                <div class="gap-2 d-flex">
                    <div class="form-floating w-75">
                        <input min="0" type="number" class="form-control" id="hours" name="hours" placeholder="Hours" value="{!! floor($project->estimated_time / 60) !!}">
                        <label for="hours">Hours</label>
                    </div>
                    <div class="form-floating w-75">
                        <input min="0" type="number" class="form-control" id="minutes" name="minutes" placeholder="Minutes" value="{!! $project->estimated_time % 60 !!}">
                        <label for="minutes">Minutes</label>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="mt-3 mb-3 form-floating w-25">
                    <select name="status" class="form-select" id="floatingSelect" aria-label="State">
                        <?php echo $project['status'] == 0 ?
                            '<option value="0" selected>In Progress</option>
                            <option value="1">Finished</option>' :
                            '<option value="0">In Progress</option>
                            <option value="1" selected>Finished</option>'
                        ?>
                    </select>
                    <label for="floatingSelect">Status</label>
                </div>
            </div>

            <div class="col-md-12">
                <label class="mt-3 mb-2 ms-2">Employees</label>
                <div class="row" id="employees">
                    <div class="col-3">
                        <button class="pt-3 pb-3 btn btn-outline-success w-100 text-start" type="button" onclick="addEmployee()">
                            + Add Employee
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-5 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form><!-- End floating Labels Form -->

    </div>
</div>
@stop

@section('body')
<script type="text/javascript">
    var inputtedEmployees = [];

    function addEmployee() {
        inputtedEmployees.push($('#employees').append(`
        <div class="mb-3 col-3">
            <div class="relative m-0 mb-2 form-floating">
            <select name="employee${inputtedEmployees.length}" id="floatingSelect" class="form-select position-relative" aria-label="State">
                @foreach ($all_employees as $employee)
                    <option value="<?= $employee['id'] ?>">
                        <?= $employee['name'] ?>
                    </option>
                @endforeach
            </select>
            <button class="top-0 bottom-0 pt-0 pb-0 btn ps-2 pe-2 position-absolute end-0 bottom-50" type="button" onclick="removeEmployee(event)">x</button>
            <label for="floatingSelect">Employee</label>
            </div>
        </div>`));
    }

    function removeEmployee(event) {
        event.target.parentElement.remove();
    }
</script>
@stop