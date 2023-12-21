@extends('frontend.index')
@section('title')
    Send Friend Request : {{ Auth::user()->name }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row profile-content d-flex justify-content-between">
            @foreach ($sendRequestList as $list)
                <div class="col-md-12 col-lg-6">
                    <div class="iq-card p-2">
                        <div class="iq-sub-card media align-items-center ">
                            <div class="media-body">
                                <h3 class="mb-0 ">{{ $list->sendRequest->name }}</h3>
                                <span class="text text-info">{{ 'Redrose id: ' . $list->sendRequest->profile->redrose_id }}</span>
                                <h6 class="mb-1 ">{{ 'Bio: ' . $list->sendRequest->profile->bio }}</h6>
                                {{-- <a href="/confirmrequest/{{ $list->sendRequest->id }}" class="btn btn-primary text-white">Requested</a> --}}
                                <a class="btn btn-primary text-white">Requested</a>
                                <a href="/cancelrequest/{{ $list->sendRequest->id }}" class="btn btn-primary text-white">Cancel</a>
                            </div>
                            <img src="{{ $list->sendRequest->profile_photo_path }}" height="100" width="100"
                                class="img-fluid rounded-circle text-right" alt="">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
