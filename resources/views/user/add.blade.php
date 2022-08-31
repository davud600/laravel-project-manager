@extends('layouts.app')
@section('title')Create User@stop

@section('links')
<li class="breadcrumb-item">
    <a href="/dashboard">Dashboard</a>
</li>
<li class="breadcrumb-item">
    <a href="/users">Users</a>
</li>
<li class="breadcrumb-item active">Create User</li>
@stop

@section('content')
<h1>Create User</h1>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Create New User</h5>

        <!-- Floating Labels Form -->
        <form class="row g-3" method="post">
            @csrf
            <div class="col-md-7">
                <div class="form-floating">
                    <input type="text" name="name" class="form-control" id="floatingName" placeholder="Your Name" />
                    <label for="floatingName">Your Name</label>
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-floating">
                    <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Your Email" />
                    <label for="floatingEmail">Your Email</label>
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-floating">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Your Password" />
                    <label for="floatingEmail">Your Password</label>
                </div>
            </div>
            <div class="col-md-7">
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