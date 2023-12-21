@extends('layouts.frontend')
@section('title')
    Model Test Syllabus
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="card iq-mb-2">
                    <div class="card-body">
                        <h4 class="card-title">Model Test Name: {{ $modeltestSyllabus->modeltest->name }}</h4>
                        <h4 class="card-title">Syllabus Name: {{ $modeltestSyllabus->name }}</h4>
                        <span class="card-text">
                            <h5> {{ $modeltestSyllabus->description }}</h5>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@endsection
