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
                    <span class="badge bg-secondary">Under Review</span>' :
                    '
                    <span class="badge bg-success">Approved</span>'
                    !!}
                </span>
            </li>

            @can('edit-requests')
            <div class="mt-4 d-flex justify-content-center">
                <a class="btn btn-secondary ps-4 pe-4" href="/requests/{{ $request->id }}/edit?project_id={{ $project->id }}">Edit</a>
            </div>
            @endcan
        </ul><!-- End Default List group -->

    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Messages</h5>
        <div class="d-flex justify-content-center">
            <div class="d-flex flex-column gap-1 w-50">
                @foreach ($messages as $message)
                @if ($message->created_by == auth()->user()->id)
                <div class="d-flex justify-content-end">
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row">
                            <span class="fw-bold">me:&nbsp;&nbsp;</span>
                            <span class="me-3" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ $message->created_at }}">
                                {{ $message->text }}
                            </span>

                            @if ($message['attach'] != null)
                            @php
                            $file_uri_path = $message['attach'];
                            $uri_segments = explode('/', $file_uri_path);
                            $file_name = $uri_segments[count($uri_segments) - 1];
                            @endphp
                            <a href="/download-file?file_uri={{ $message->attach }}">
                                <span><?= $file_name ?></span>
                                <i class="bi bi-file"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <div class="d-flex justify-content-start">
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row">
                            <span class="fw-bold">{{ getUserNameFromId($message->created_by) }}:&nbsp;&nbsp;</span>
                            <span class="me-3" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $message->created_at }}">
                                {{ $message->text }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif
                <hr>
                @endforeach
            </div>
        </div>
        <!-- Send message form -->
        <div class="d-flex justify-content-center">
            <form action="/requests/{{ $request->id }}/create-message" class="w-50" method="post" enctype="multipart/form-data">
                @csrf()
                @method('POST')
                <div class="mt-3 mb-3 justify-content-center d-flex gap-2 flex-row">
                    <input type="text" name="message" class="form-control">
                    <input type="file" name="userfile">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop