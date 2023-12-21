@extends('frontend.index')
@section('title')
    {{ $user->name }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row profile-content d-flex justify-content-between">
            <div class="col-12 col-md-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-body profile-page">
                        <div class="profile-header">
                            <div class="cover-container text-center">
                                @if ($user->profile_photo_path != null)
                                    <img src="{{ $user->profile_photo_path }}" height="200" width="200"
                                        class="rounded-circle img-fluid">
                                @else
                                    <img src="{{ asset('images/user_01.jpg') }}" height="200" width="200"
                                        class="rounded-circle img-fluid">
                                @endif
                            </div>

                            <div class="profile-detail mt-3 mb-3">
                                <h3>{{ $user->name }}</h3>
                            </div>
                            <div class="iq-card-body m-0 p-0">
                                <ul class="list-inline p-0 mb-0">
                                    <li>
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-sm-4">
                                                <h6>Bio</h6>
                                            </div>
                                            <div class="col-sm-8">
                                                <p class="mb-0">{{ $user->profile->bio }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-sm-4">
                                                <h6>RedRose Id</h6>
                                            </div>
                                            <div class="col-sm-8">
                                                <p class="mb-0">{{ $user->profile->redrose_id }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-sm-4">
                                                <h6>Designation</h6>
                                            </div>
                                            <div class="col-sm-8">
                                                <p class="mb-0">{{ $user->profile->designation }}</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="profile-detail mt-3 mb-3">
                                @if ($user->id != Auth::user()->id)
                                    @if ($is_friend != null)
                                        <a href="/unfriend/{{ $user->id }}"
                                            class="btn btn-primary text-white">Unfiend</a>
                                    @else
                                        @if ($is_request != null)
                                            <a class="btn btn-primary text-white">Requested</a>
                                            <a href="/cancelrequest/{{ $user->id }}"
                                                class="btn btn-primary text-white">Cancel</a>
                                        @else
                                            <a href="/add-friend/{{ $user->id }}" class="btn btn-primary text-white">Add
                                                Friend</a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between align-items-center mb-0">
                        <div class="iq-header-title">
                            <h4 class="card-title mb-0">Personal Details</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <ul class="list-inline p-0 mb-0">
                            <li>
                                <div class="row align-items-center justify-content-between mb-3">
                                    <div class="col-sm-3">
                                        <h6>Birthday</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="mb-0">{{ $user->profile->birthday }}</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row align-items-center justify-content-between mb-3">
                                    <div class="col-sm-3">
                                        <h6>Address</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="mb-0">{{ $user->profile->address }}</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row align-items-center justify-content-between mb-3">
                                    <div class="col-sm-3">
                                        <h6>Phone</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="mb-0">{{ $user->profile->phone }}</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row align-items-center justify-content-between mb-3">
                                    <div class="col-sm-3">
                                        <h6>Email</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="mb-0">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between align-items-center mb-0">
                        <div class="iq-header-title">
                            <h4 class="card-title mb-0">About</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <p>{{ $user->profile->about }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between align-items-center mb-0">
                        <div class="iq-header-title">
                            <h4 class="card-title mb-0">Social Information</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <ul class="list-inline d-flex p-0 mb-2 align-items-center">
                            @if ($user->social_link->whatsapp != null)
                                <li>
                                    <a class="btn btn-primary" href="{{ $user->social_link->whatsapp }}" target="blank">
                                        <h6 class="text text-white">Whatsapp</h6>
                                    </a>
                                </li>
                            @endif
                            @if ($user->social_link->facebook != null)
                                <li class="ml-2">
                                    <a class="btn btn-primary" href="{{ $user->social_link->facebook }}" target="blank">
                                        <h6 class="text text-white">Facebook</h6>
                                    </a>
                                </li>
                            @endif
                            @if ($user->social_link->twitter != null)
                                <li class="ml-2">
                                    <a class="btn btn-primary" href="{{ $user->social_link->twitter }}" target="blank">
                                        <h6 class="text text-white">Twitter</h6>
                                    </a>
                                </li>
                            @endif
                            @if ($user->social_link->instagram != null)
                                <li class="ml-2">
                                    <a class="btn btn-primary" href="{{ $user->social_link->instagram }}" target="blank">
                                        <h6 class="text text-white">Instagram</h6>
                                    </a>
                                </li>
                            @endif
                        </ul>
                        <ul class="list-inline d-flex p-0 mb-0 align-items-center">
                            @if ($user->social_link->linkedin != null)
                                <li>
                                    <a class="btn btn-primary" href="{{ $user->social_link->linkedin }}" target="blank">
                                        <h6 class="text text-white">LinkedIn</h6>
                                    </a>
                                </li>
                            @endif
                            @if ($user->social_link->pinterest != null)
                                <li class="ml-2">
                                    <a class="btn btn-primary" href="{{ $user->social_link->pinterest }}" target="blank">
                                        <h6 class="text text-white">Pinterest</h6>
                                    </a>
                                </li>
                            @endif
                            @if ($user->social_link->tiktok != null)
                                <li class="ml-2">
                                    <a class="btn btn-primary" href="{{ $user->social_link->tiktok }}" target="blank">
                                        <h6 class="text text-white">Tiktok</h6>
                                    </a>
                                </li>
                            @endif
                            @if ($user->social_link->wechat != null)
                                <li class="ml-2">
                                    <a class="btn btn-primary" href="{{ $user->social_link->wechat }}" target="blank">
                                        <h6 class="text text-white">Wechat</h6>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
