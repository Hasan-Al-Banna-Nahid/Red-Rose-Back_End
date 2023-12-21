@extends('layouts.frontend')
@section('title')
    Model Test
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($modeltestlist as $list)
            @if ($list->type == 'on')
            <div class="col-sm-3">
                <div class="card iq-mb-3">
                    <div class="card-body">
                        <h4 class="card-title">{{ $list->name }}</h4>
                        <span class="card-text">
                            <h6>Class Name: {{ $list->allclass->name }}<h6>
                        </span>
                        <span class="card-text">
                            <h6>Subject: {{ $list->subject }}<h6>
                        </span>
                        <a class="btn btn-outline-primary mr-1" href="{{ route('mtest.exam',  $list->id) }}">Exam Now</a>
                        <a class="btn btn-outline-primary mr-1" href="{{ route('umsyllabus.show', $list->id) }}">Sylabus</a>
                    </div>
                </div>
            </div>
            @endif

            @endforeach
        </div>
    </div>
@endsection
