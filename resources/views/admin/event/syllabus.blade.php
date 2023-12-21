@extends('admin.index')
@section('title')
    Syllabus
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" target="_blank">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Syllabus</li>
        </ul>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.syllabus.component')
            <div class="col-sm-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Create Syllabus for {{ '"'.$event->name.'"' }}</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form method="POST" action="/syllabus">
                            @csrf
                            <div class="form-group">
                                <label for="event_id">Contest Name</label>
                                <input type="text" name="event_id" readonly class="form-control" id="event_id" value="{{ $event->name }}">
                                <input name="event_id" hidden value="{{ $event->id }}">
                            </div>
                            <div class="form-group">
                                <label for="name">Syllabus Name</label>
                                <input required type="text" name="name" class="form-control" id="name"
                                    placeholder="Syllabus Name">
                            </div>
                            <div class="form-group">
                                <label for="description">Syllabus Description</label>
                                <textarea class="form-control" name="description" id="description" rows="5"></textarea>
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
