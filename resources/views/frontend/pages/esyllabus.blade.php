@extends('layouts.frontend')
@section('title')
    Event
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="card iq-mb-2">
                    <img src="{{ $syllabs->events->image_path }}" class="card-img-top" height="300" alt="#">
                    <div class="card-body">
                        <h4 class="card-title">Event Name: {{ $syllabs->events->name }}</h4>
                        <h4 class="card-title">Syllabus Name: {{ $syllabs->name }}</h4>
                        <span class="card-text">
                            <h5> {{ $syllabs->description }}</h5>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@endsection
