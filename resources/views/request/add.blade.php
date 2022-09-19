@extends('layouts.app')
@section('title')Create Request@stop

@section('links')
<li class="breadcrumb-item">
    <a href="/dashboard">Dashboard</a>
</li>
<li class="breadcrumb-item">
    <a href="/projects/{{ $project->id }}">{{ $project->title }}</a>
</li>
<li class="breadcrumb-item active">Create Request</li>
@stop

@section('content')
<h1>Create Request</h1>

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
        <h5 class="card-title">Create New Request</h5>

        <!-- Floating Labels Form -->
        <form class="row g-3" method="post">
            @csrf
            @method('POST')
            <input type="hidden" name="project_id" value="0">
            <div class="col-md-8">
                <div class="form-floating">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Request Title" required>
                    <label for="title">Request Title</label>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="description" name="description" placeholder="Request Description">
                    <label for="description">Request Description</label>
                </div>
            </div>

            <div class="mt-5 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form><!-- End floating Labels Form -->

    </div>
</div>
@stop