@extends('admin.index')
@section('title')
    Edit Contest
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" target="_blank">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Contest - {{ $event->name }}</li>
        </ul>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
@include('admin.event.component')
            <div class="col-sm-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Edit Contest "{{ $event->name }}"</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form method="POST" action="{{ route('event.update', $event->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <input required type="text" name="name" class="form-control" id="name"
                                    value="{{ $event->name }}">
                            </div>
                            <div class="form-group">
                                <input required type="text" name="price" class="form-control" id="price"
                                    value="{{ $event->price }}">
                            </div>
                            <div class="form-group">
                                <input required type="number" name="duration" class="form-control" id="duration"
                                    value="{{ $event->duration }}">
                            </div>
                            <div class="form-group">
                                <label for="date">Select Date</label>
                                <input type="date" name="date" required class="form-control" id="date"
                                    value="{{ $event->date }}">
                            </div>
                            <div class="form-group">
                                <label for="time">Select Time</label>
                                <input type="time" name="time" required class="form-control" id="time"
                                    value="{{ $event->time }}">
                            </div>
                            <label>Select Contest Type</label>
                            <div class="">
                                <div class="custom-control custom-radio custom-control-inline">
                                    @if ($event->type == 'One')
                                        <input type="radio" id="customRadio6" value="One" name="type" checked
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio6"> One </label>
                                    @elseif ($event->type == 'Two')
                                        <input type="radio" id="customRadio7" value="Two" name="type" checked
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio7"> Two </label>
                                    @elseif ($event->type == 'Three')
                                        <input type="radio" id="customRadio8" value="Three" name="type" checked
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio8"> Three </label>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status">Select Contest statue</label>
                                <select required name="status" id="status" class="custom-select">
                                    <option value="{{ $event->status }}">
                                        @if ($event->status == 'create')
                                            Created
                                        @elseif ($event->status == 'running')
                                            Running
                                        @elseif ($event->status == 'start')
                                            Start
                                        @elseif ($event->status == 'end')
                                            End
                                        @endif
                                    </option>
                                    <option value="create">Created</option>
                                    <option value="running">Running</option>
                                    <option value="start">Start</option>
                                    <option value="end">End</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-file" for="customFile">Contest Feature Image</label>
                                <img height="100" width="100" src="{{ $event->image_path }}">
                                <input name="image_path" type="file" class="form-control-file" id="customFile">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Update" />
                            <input type="reset" class="btn iq-bg-danger" value="Cancel" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
