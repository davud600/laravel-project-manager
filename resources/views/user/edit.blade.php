@extends('layouts.app')
@section('title')Edit {{ $user->name }}@stop

@section('links')
<li class="breadcrumb-item">
    <a href="/dashboard">Dashboard</a>
</li>
<li class="breadcrumb-item">
    <a href="/users">Users</a>
</li>
<li class="breadcrumb-item">
    <a href="/users/{{ $user->id }}">{{ $user->name }}</a>
</li>
<li class="breadcrumb-item active">Update {{ $user->name }}</li>
@stop

@section('content')
<h1>Update {{ $user->name }}</h1>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit User</h5>

        <!-- Floating Labels Form -->
        <form class="row g-3" method="post" action="/users/{{ $user->id }}">
            @csrf
            @method('PUT')
            <div class="col-md-8">
                <div class="form-floating">
                    <input type="text" name="name" class="form-control" id="floatingName" placeholder="Your Name" value="{{ $user->name }}" />
                    <label for="floatingName">Your Name</label>
                </div>
            </div>

            <div class="col-md-8">
                <div class="form-floating">
                    <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Your Email" value="{{ $user->email }}" />
                    <label for="floatingEmail">Your Email</label>
                </div>
            </div>

            <div class="col-12">
                <label for="yourCompany" class="form-label">Your Company</label>
                <input type="text" name="company" class="form-control" id="yourCompany" value="{{ $user->company }}" />
                <div class="invalid-feedback">
                    Enter your company name!
                </div>
            </div>

            <div class="col-md-8">
                <div class="form-floating">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Your New Password" />
                    <label for="floatingEmail">Your New Password</label>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-floating">
                    <input type="text" name="company" class="form-control" id="floatingName" placeholder="Your Name" />
                    <label for="floatingName">Company</label>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </form>
        <!-- End floating Labels Form -->
    </div>
</div>
@stop