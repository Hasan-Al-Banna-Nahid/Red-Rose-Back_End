@extends('layouts.frontend')
@section('title')
    My Event
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($eventList as $list)
                <div class="col-sm-4">
                    <div class="card iq-mb-3">
                        <img src="{{ $list->events->image_path }}" class="card-img-top" alt="#">
                        <div class="card-body">
                            <h4 class="card-title">{{ $list->events->name }}</h4>
                            <span class="card-text">
                                <h6>Price: {{ $list->events->price }}</h6>
                            </span>
                            <span class="card-text">
                                <h6>Exam Date: {{ $list->events->date }}</h6>
                            </span>
                            <span class="card-text">
                                <h6>Exam Time: {{ $list->events->time }}</h6>
                            </span>
                            <span class="card-text">
                                <h6>Exam Type: {{ $list->events->type }} time<h6>
                            </span>
                            <span class="card-text">
                                <h6>Exam Duration: {{ $list->events->duration }} time<h6>
                            </span>
                            @if ($list->events->status == 'start')
                                <a class="btn btn-outline-primary mr-1" href="/exam/{{ $list->events->id }}">Exam Now</a>
                            @elseif ($list->events->status == 'end')
                                <a class="btn btn-outline-primary mr-1" href="{{ route('user.result', $list->events->id) }}">Exam Result</a>
                            @endif
                            <a class="btn btn-outline-primary mr-1" href="/eventsyllabus/{{ $list->events->id }}">Syllabus</a>
                            <a class="btn btn-outline-primary mr-1"
                                href="/eventparticipant/{{ $list->events->id }}">Participant</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
