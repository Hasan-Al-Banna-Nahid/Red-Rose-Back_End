@extends('admin.index')
@section('title')
    Contest
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" target="_blank">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contest - {{ $event->name }}</li>
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
                            <h4 class="card-title">Contest <span class="text text-primary">{{ $event->name }}</span></h4>
                        </div>
                        <div class="iq-header-title">
                            <h4 class="card-title"> <a href="/event/{{ $event->id }}/edit">Edit</a></h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <h5 class="card-title">Price  <span class="text text-primary">{{ $event->price }}</span></h5>
                        <h5 class="card-title">Exam Duration <span class="text text-primary">{{ $event->duration }}</span></h5>
                        <h5 class="card-title">Exam Date <span class="text text-primary">{{ $event->date }}</span></h5>
                        <h5 class="card-title">Exam Time <span class="text text-primary">{{ $event->time }}</span></h5>
                        <h5 class="card-title">Exam Type <span class="text text-primary">{{ $event->type }}</span></h5>
                        <h5 class="card-title">Exam Status <span class="text text-primary">{{ $event->status }}</span></h5>
                        <img height="250" width="250" src="{{ $event->image_path }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
