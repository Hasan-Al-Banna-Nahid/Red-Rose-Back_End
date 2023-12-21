@extends('frontend.index')
@section('title')
    My Friend : {{ Auth::user()->name }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row profile-content d-flex justify-content-between">
            @foreach ($friendsList as $list)
                <div class="col-md-12 col-lg-6">
                    <div class="iq-card p-4">
                        <div class="iq-sub-card media align-items-center">
                            <div class="media-body">
                                <h3 class="mb-0 ">{{ $list->user->name }}</h3>
                                <h6 class="mb-0 ">{{ $list->user->profile->bio }}</h6>
                            </div>
                            <span class="text-primary" id="dropdownMenuButton5" data-toggle="dropdown">
                                <button class="btn btn-primary">Send Message</button>
                            </span>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                <form method="POST" action="/makemessage/{{ $list->user->id }}">
                                    @csrf
                                    <input type="text" name="message" placeholder="Type your message" class="from-control">
                                    <button class="dropdown-item">Submit</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
