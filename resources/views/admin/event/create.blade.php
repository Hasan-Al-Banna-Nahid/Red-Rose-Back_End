@extends('admin.index')
@section('title')
    Contests
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" target="_blank">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Contest</li>
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
                            <h4 class="card-title">Create Contest</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form method="POST" action="{{ route('event.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input required type="text" name="name" class="form-control" id="name"
                                    placeholder="Contest Name">
                            </div>
                            <div class="form-group">
                                <input required type="text" name="price" class="form-control" id="price"
                                    placeholder="Contest Price">
                            </div>
                            <div class="form-group">
                                <input required type="number" name="duration" class="form-control" id="duration"
                                    placeholder="Exam time duration">
                            </div>
                            <div class="form-group">
                                <label for="date">Select Date</label>
                                <input type="date" name="date" required class="form-control" id="date">
                            </div>
                            <div class="form-group">
                                <label for="time">Select Time</label>
                                <input type="time" name="time" required class="form-control" id="time">
                            </div>
                            <label>Select Contest Type</label>
                            <div class="">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio6" value="One" name="type"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio6"> One </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio7" value="Two" name="type"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio7"> Two </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio8" value="Three" name="type"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio8"> Three </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-control-file" for="customFile">Contest Feature Image</label>
                                <input name="image_path" type="file" class="form-control-file" id="customFile">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn iq-bg-danger" value="Cancel" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
