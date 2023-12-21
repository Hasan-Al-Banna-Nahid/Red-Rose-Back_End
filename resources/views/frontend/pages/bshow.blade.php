@extends('frontend.index')
@section('title')
    blog Panel
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">blog <span class="text text-primary">{{ $blog->name }}</span></h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <img height="250" width="250" src="{{ $blog->image_path }}">
                        <h5 class="card-title mt-2">Blog Name: <span class="text text-primary">{{ $blog->name }}</span></h5>
                        <h5 class="card-title">Blog Description: <span class="text text-primary">
                            @php
                                echo $blog->description;
                            @endphp</span>
                        </h5>
                        <span class="card-text"><h6>Authore: {{ $blog->user->name }}</h6></span>
                        <span class="card-text"><h6>View: {{ $blog->pageview + 1 }}</h6></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
