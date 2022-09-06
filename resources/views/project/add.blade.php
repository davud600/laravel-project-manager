@extends('layouts.app')
@section('title')Create Project@stop

@section('links')
<li class="breadcrumb-item">
    <a href="/dashboard">Dashboard</a>
</li>
<li class="breadcrumb-item active">Create Project</li>
@stop

@section('content')
<h1>Create Project</h1>

@if ($errors->any())
@foreach ($errors->all() as $error)
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $error }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endforeach
@endif

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Create New Project</h5>

        <!-- Floating Labels Form -->
        <form class="row g-3" method="post">
            @csrf
            <div class="col-md-8">
                <div class="form-floating">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Project Title">
                    <label for="title">Project Title</label>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3 form-floating">
                    <select name="customer" class="form-select" id="floatingSelect" aria-label="State">
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->name }}
                        </option>
                        @endforeach
                    </select>
                    <label for="floatingSelect">Customer</label>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="description" name="description" placeholder="Project Description">
                    <label for="description">Project Description</label>
                </div>
            </div>

            <div class="col-md-3">
                <label class="mt-3 mb-2 ms-2">Estimated Time</label>
                <div class="gap-2 d-flex">
                    <div class="form-floating w-75">
                        <input min="0" type="number" class="form-control" id="hours" name="hours" placeholder="Hours">
                        <label for="hours">Hours</label>
                    </div>
                    <div class="form-floating w-75">
                        <input min="0" type="number" class="form-control" id="minutes" name="minutes" placeholder="Minutes">
                        <label for="minutes">Minutes</label>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <label class="mt-3 mb-2 ms-2">Employees</label>
                <div class="row" id="employees">
                    <div class="gap-2 col-3">
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
        // var employeesEl = document.getElementById('employees');
        // var container = document.createElement('div');
        // container.className = 'mb-3 col-3';
        // var smallerContainer = document.createElement('div');
        // smallerContainer.className = 'relative m-0 mb-2 form-floating';
        // var employeeSelect = document.createElement('select');
        // employeeSelect.className = 'form-select position-relative';
        // employeeSelect.setAttribute('id', 'floatingSelect');
        // employeeSelect.setAttribute('name', `employee${inputtedEmployees.length}`);
        // employeeSelect.setAttribute('aria-label', 'State');

        const employeesElement = document.getElementById('employees');

        employeesElement.innerHTML += `
        <div class="mb-3 col-3">
            <div class="relative m-0 mb-2 form-floating">
            <select name="employee${inputtedEmployees.length}" id="floatingSelect" class="form-select position-relative" aria-label="State">
                @foreach ($employees as $employee)
                    <option value="{!! $employee['id'] !!}">
                        {!! $employee['name'] !!}
                    </option>
                @endforeach
            </select>
            <button class="top-0 bottom-0 pt-0 pb-0 btn ps-2 pe-2 position-absolute end-0 bottom-50" type="button" onclick="removeEmployee(event)">x</button>
            <label for="floatingSelect">Employee</label>
            </div>
        </div>`

        inputtedEmployees.push(employeesElement);
    }

    function removeEmployee(event) {
        event.target.parentElement.remove();
    }
</script>
@stop