@extends('admin.index')
@section('title')
    Events
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" target="_blank">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Question - {{ $question->name }}</li>
        </ul>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.question.component')
            <div class="col-sm-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Edit Question "{{ $question->name }}"</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form method="POST" action="/question/{{ $question->id }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="event_id" value="{{ $question->event_id }}">
                            <div class="form-group">
                                <input required type="text" name="name" class="form-control" id="name"
                                    value="{{ $question->name }}">
                            </div>
                            <div class="form-group">
                                <input required type="text" name="option1" class="form-control" id="option1"
                                    value="{{ $question->option1 }}">
                            </div>
                            <div class="form-group"><input required type="text" name="option2" class="form-control"
                                    id="option2" value="{{ $question->option2 }}"></div>
                            <div class="form-group"><input required type="text" name="option3" class="form-control"
                                    id="option3" value="{{ $question->option3 }}"></div>
                            <div class="form-group"><input required type="text" name="option4" class="form-control"
                                    id="option4" value="{{ $question->option4 }}"></div>
                            <div class="form-group">
                                <label for="option5">Select Correct answer</label>
                                <select required name="option5" class="custom-select">
                                    <option value="{{ $question->option5 }}">{{ 'Option ' . $question->option5 . ' Selected' }}</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                    <option value="4">Option 4</option>
                                </select>
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
