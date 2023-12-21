@extends('layouts.frontend')
@section('title')
    Event
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($eventList as $list)
                @if ($list->status == 'running')
                    <div class="col-sm-3">
                        <div class="card iq-mb-3">
                            <img src="{{ $list->image_path }}" class="card-img-top" alt="#">
                            <div class="card-body">
                                <h4 class="card-title">{{ $list->name }}</h4>
                                <span class="card-text"><h6>Price: {{ $list->price }}</h6></span>
                                <span class="card-text"><h6>Exam Date: {{ $list->date }}</h6></span>
                                <span class="card-text"><h6>Exam Time: {{ $list->time }}</h6></span>
                                <span class="card-text"><h6>Exam Type: {{ $list->type }} time<h6></span>
                                <span class="card-text"><h6>Exam Duration: {{ $list->duration }} minute<h6></span>
                                <a class="btn btn-outline-primary mr-1" href="/enroll/{{ $list->id }}">Enroll Now</a>
                                <a class="btn btn-outline-primary mr-1" href="/eventsyllabus/{{ $list->id }}">Syllabus</a>
                                <a class="btn btn-outline-primary mr-1" href="/eventparticipant/{{ $list->id }}">Participant</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
