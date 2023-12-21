@extends('layouts.frontend')
@section('title')
    All blog
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($bloglist as $list)
                <div class="col-sm-3">
                    <div class="card iq-mb-3">
                        <img src="{{ $list->image_path }}" class="card-img-top" alt="#">
                        <div class="card-body">
                            <h4 class="card-title">{{ $list->name }}</h4>
                            {{-- <span class="card-text"><h6>Details: {{ $list->description }}</h6></span> --}}
                            <span class="card-text"><h6>Authore: {{ $list->user->name }}</h6></span>
                            <span class="card-text"><h6>View: {{ $list->pageview }}</h6></span>
                            <a href="{{ route('ublog.show', $list->id) }}" class="btn btn-primary text-white">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection