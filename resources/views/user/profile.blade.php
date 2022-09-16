@extends('layouts.app')
@section('title'){{ auth()->user()->name }} Profile@stop

@section('links')

@stop

@section('content')
<div class="row">
    <div class="col-xl-4">

        <div class="card">
            <div class="pt-4 card-body profile-card d-flex flex-column align-items-center">

                <h2>{{ auth()->user()->name }}</h2>
                <h3>
                    {{
                        auth()->user()->role == 3 ? 'Customer' : (auth()->user()->role == 2 ? 'Employee': 'Admin')
                    }}
                </h3>
            </div>
        </div>

    </div>

    <div class="col-xl-8">

        <div class="card">
            <div class="pt-3 card-body">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                    </li>

                </ul>
                <div class="pt-2 tab-content">

                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <h5 class="card-title">Profile Details</h5>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label ">Name</div>
                            <div class="col-lg-9 col-md-8">{{ auth()->user()->name }}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Email</div>
                            <div class="col-lg-9 col-md-8">{{ auth()->user()->email }}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Company</div>
                            <div class="col-lg-9 col-md-8">{{ auth()->user()->company }}</div>
                        </div>

                    </div>

                </div><!-- End Bordered Tabs -->

            </div>
        </div>

    </div>
</div>
@stop