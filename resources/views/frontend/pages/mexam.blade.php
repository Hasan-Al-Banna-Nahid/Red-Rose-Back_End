@extends('layouts.frontend')
@section('title')
    Modeltest Exam
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                <div class="card iq-mb-3">
                    <div class="card-body">
                        <h4 class="card-title">{{ $modeltest->name }}</h4>
                        <span class="card-text">
                            <h6>Class: {{ $modeltest->allclass->name }}<h6>
                        </span>
                        <span class="card-text">
                            <h6>Subject: {{ $modeltest->subject }}<h6>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <form action="{{ route('mtest.result', $modeltest->id) }}" method="POST">
                    @csrf
                    @foreach ($question as $list)
                        <div class="card iq-mb-3">
                            <div class="card-body">
                                <span class="card-text">
                                    <h6>Question: {{ $list->name }}</h6>
                                </span>
                            </div>
                            <div class="card-body">
                                <div>
                                    <input type="radio" id="1{{ $list->id }}" name="ans[]{{ $list->id }}"
                                        value="v1{{ $list->option5 }}">
                                    <label for="1{{ $list->id }}" class="ml-2">{{ $list->option1 }}</label>
                                </div>
                                <div>
                                    <input type="radio" id="2{{ $list->id }}" name="ans[]{{ $list->id }}"
                                        value="v2{{ $list->option5 }}">
                                    <label for="2{{ $list->id }}" class="ml-2">{{ $list->option2 }}</label>
                                </div>
                                <div>
                                    <input type="radio" id="3{{ $list->id }}" name="ans[]{{ $list->id }}"
                                        value="v3{{ $list->option5 }}">
                                    <label for="3{{ $list->id }}" class="ml-2">{{ $list->option3 }}</label>
                                </div>
                                <div>
                                    <input type="radio" id="4{{ $list->id }}" name="ans[]{{ $list->id }}"
                                        value="v4{{ $list->option5 }}">
                                    <label for="4{{ $list->id }}" class="ml-2">{{ $list->option4 }}</label>
                                </div>
                                <input type="hidden" name="totalquestion" value="{{ $totalquestion }}">
                            </div>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-outline-primary">Finish</button>
                </form>
            </div>
        </div>
    </div>
@endsection
