@extends('admin.index')
@section('title')
    Events
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" target="_blank">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Question - {{ $question->name }}</li>
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
                            <h4 class="card-title">Question "{{ $question->name }}"</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <h5 class="card-title">Event Name: <span class="text text-primary">{{ $question->events->name }}</span></h5>
                        <h5 class="card-title">Question Name: <span class="text text-primary">{{ $question->name }}</span></h5>
                        <h5 class="card-title">Option 1: <span class="text text-primary">{{ $question->option1 }}</span></h5>
                        <h5 class="card-title">Option 2: <span class="text text-primary">{{ $question->option2 }}</span></h5>
                        <h5 class="card-title">Option 3: <span class="text text-primary">{{ $question->option3 }}</span></h5>
                        <h5 class="card-title">Option 4: <span class="text text-primary">{{ $question->option4 }}</span></h5>
                        <h5 class="card-title">Currect Answer: <span class="text text-primary">{{ 'Option ' . $question->option5 }}</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
