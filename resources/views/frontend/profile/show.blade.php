@extends('frontend.index')
@section('title')
    {{ Auth::user()->name }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row profile-content">
            <div class="col-12 col-md-12 col-lg-4">
                <div class="iq-card">
                    <div class="iq-card-body profile-page">
                        <div class="profile-header">
                            <div class="cover-container text-center">
                                @if ($user->profile_photo_path != null)
                                    <img src="{{ $user->profile_photo_path }}" class="rounded-circle img-fluid">
                                @else
                                    <img src="{{ asset('images/user_01.jpg') }}"class="rounded-circle img-fluid">
                                @endif
                            </div>
                            <div class="profile-detail mt-3 mb-3">
                                <a href="{{ '/my-friend' }}" class="btn btn-primary">My Friend</a>
                                <a href="{{ '/find-friend' }}" class="btn btn-primary">Find Friend</a>
                                <a href="{{ '/allrequest' }}" class="btn btn-primary">Request</a>
                                <a href="{{ '/allsend' }}" class="btn btn-primary">Send</a>
                            </div>
                            <div class="profile-detail mt-3 mb-3">
                                <h3>{{ $user->name }}</h3>
                            </div>
                            <div class="iq-card-body m-0 p-0">
                                <ul class="list-inline p-0 mb-0">
                                    <li>
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-sm-4">
                                                <h6>Redrose point</h6>
                                            </div>
                                            <div class="col-sm-8">
                                                <p class="mb-0">{{ $user->profile->points }}</p>
                                            </div>
                                        </div>
                                    </li>
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
                        </div>
                    </div>
                </div>
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
            <div class="col-12 col-md-12 col-lg-8">
                <form method="POST" action="/profile" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="iq-card">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">User Information</h4>
                                    </div>
                                </div>
                                <div class="iq-card-body">
                                    <div class="new-user-info">
                                        <div class="row">
                                            <div class="form-group text-center col-md-12">
                                                <div class="add-img-user profile-img-edit">
                                                    @if ($user->profile_photo_path != null)
                                                        <img class="profile-pic img-fluid"
                                                            src="{{ $user->profile_photo_path }}" alt="profile-pic">
                                                    @else
                                                        <img class="profile-pic img-fluid"
                                                            src="{{ asset('images/user_01.jpg') }}" alt="profile-pic">
                                                    @endif
                                                    <div class="p-image">
                                                        <a href="javascript:void();"
                                                            class="upload-button btn iq-bg-primary">Upload
                                                            Photo</a>
                                                        <input class="file-upload" name="profile_photo" type="file"
                                                            accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="img-extension mt-3">
                                                    <div class="d-inline-block align-items-center">
                                                        <span>Only</span>
                                                        <span>.jpg</span>
                                                        <span>.png</span>
                                                        <span>.jpeg</span>
                                                        <span>allowed</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 mt-3">
                                                <label for="redrose_id">RedRose Id</label>
                                                @if ($redrose_id_edit == 'on')
                                                    <span> {{ '(you are availlable to edit)' }}</span>
                                                    <input type="text" name="redrose_id" class="form-control"
                                                        id="redrose_id" value="{{ $user->profile->redrose_id }}">
                                                @else
                                                    <span>{{ '(last edit on ' . $user->profile->date . ')' }}</span>
                                                    <input class="form-control" readonly id="redrose_id"
                                                        value="{{ $user->profile->redrose_id }}">
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6 mt-3">
                                                <label for="bio">Bio:</label>
                                                <input type="text" name="bio" class="form-control" id="bio"
                                                    value="{{ $user->profile->bio }}">
                                            </div>
                                            <div class="form-group col-md-6 mt-3">
                                                <label for="designation">Designation:</label>
                                                <input type="text" name="designation" class="form-control"
                                                    id="designation" value="{{ $user->profile->designation }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="birthday">Date of Birth Date</label>
                                                <input type="date" name="birthday"
                                                    value="{{ $user->profile->birthday }}" class="form-control"
                                                    id="birthday">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="name">Name:</label>
                                                <input type="text" name="name" class="form-control" id="name"
                                                    value="{{ $user->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email"> Email: </label>
                                                <input id="email" class="form-control" readonly
                                                    value="{{ $user->email }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="add1">Address:</label>
                                                <input type="text" required name="address" class="form-control"
                                                    id="add1" value="{{ $user->profile->address }}">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Country:</label>
                                                <select class="form-control" required name="country">
                                                    <option value="{{ $user->profile->country }}">
                                                        {{ $user->profile->country }} Selected</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Chin">Chin</option>
                                                    <option value="India">India</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Gender:</label>
                                                <select class="form-control" required name="gender">
                                                    @if ($user->profile->gender != '')
                                                        <option value="{{ $user->profile->gender }}">
                                                            {{ $user->profile->gender }} Selected</option>
                                                    @endif
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="company_name">Company Name:</label>
                                                <input type="text" name="company_name" class="form-control"
                                                    id="company_name" value="{{ $user->profile->company_name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="mobno">Mobile Number:</label>
                                                <input type="number" required name="phone" class="form-control"
                                                    id="mobno" value="{{ $user->profile->phone }}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="about">About You:</label>
                                                <textarea class="form-control" name="about" id="about" rows="2">{{ $user->profile->about }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">Advance Settings</h4>
                                    </div>
                                </div>
                                <div class="iq-card-body">
                                    <div class="new-user-info">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="country">Select your Country</label>
                                                <select required id="country" name="country" class="custom-select">
                                                    <option value="{{ $user->profile->country }}">
                                                        @foreach ($countrylist as $list)
                                                            @if ($list->id == $user->profile->country)
                                                                {{ $list->name . ' Selected' }}
                                                            @endif
                                                        @endforeach
                                                    </option>
                                                    @foreach ($countrylist as $list)
                                                        @if ($list->is_active == 'on')
                                                            <option value="{{ $list->id }}">{{ $list->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="division">Select your Division</label>
                                                <select required id="division" name="division" class="custom-select">
                                                    <option value="{{ $user->profile->division }}">
                                                        @foreach ($divisionlist as $list)
                                                            @if ($list->id == $user->profile->division)
                                                                {{ $list->name . ' Selected' }}
                                                            @endif
                                                        @endforeach
                                                    </option>
                                                    @foreach ($divisionlist as $list)
                                                        <option value="{{ $list->id }}">{{ $list->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="city">Select your city</label>
                                                <select required name="city" class="custom-select">
                                                    <option value="{{ $user->profile->city }}">
                                                        @foreach ($citylist as $list)
                                                            @if ($list->id == $user->profile->city)
                                                                {{ $list->name . ' Selected' }}
                                                            @endif
                                                        @endforeach
                                                    </option>
                                                    @foreach ($citylist as $list)
                                                        <option value="{{ $list->id }}">{{ $list->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="upazila">Select your upazila / thana</label>
                                                <select required name="upazila" class="custom-select">
                                                    <option value="{{ $user->profile->city }}">
                                                        @foreach ($upazilalist as $list)
                                                            @if ($list->id == $user->profile->upazila)
                                                                {{ $list->name . ' Selected' }}
                                                            @endif
                                                        @endforeach
                                                    </option>
                                                    @foreach ($upazilalist as $list)
                                                        <option value="{{ $list->id }}">{{ $list->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="address">Address</label>
                                                <input type="text" id="address" name="address" class="form-control"
                                                    value="{{ $user->profile->address }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="institute">Institute Name</label>
                                                <input type="text" name="institute" class="form-control"
                                                    id="institute" value="{{ $user->profile->institute }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="class">Select your class</label>
                                                <select required id="class" name="class" class="custom-select">
                                                    <option value="{{ $user->profile->class }}">
                                                        @foreach ($allclasslist as $list)
                                                            @if ($list->id == $user->profile->class)
                                                                {{ $list->name }}
                                                            @endif
                                                        @endforeach
                                                    </option>
                                                    @foreach ($allclasslist as $list)
                                                        <option value="{{ $list->id }}">{{ $list->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">Social Link</h4>
                                    </div>
                                </div>
                                <div class="iq-card-body">
                                    <div class="new-user-info">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="whatsapp">Whatsapp Number:</label>
                                                <input type="number" name="whatsapp" class="form-control"
                                                    id="whatsapp" value="{{ $user->social_link->whatsapp }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="facebook">Facebook:</label>
                                                <input type="text" name="facebook" class="form-control"
                                                    id="facebook" value="{{ $user->social_link->facebook }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="twitter">Twitter:</label>
                                                <input type="text" name="twitter" class="form-control" id="twitter"
                                                    value="{{ $user->social_link->twitter }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="instagram">Instagram:</label>
                                                <input type="text" name="instagram" class="form-control"
                                                    id="instagram" value="{{ $user->social_link->instagram }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="linkedin">Linkedin:</label>
                                                <input type="text" name="linkedin" class="form-control"
                                                    id="linkedin" value="{{ $user->social_link->linkedin }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="pinterest">Pinterest:</label>
                                                <input type="text" name="pinterest" class="form-control"
                                                    id="pinterest" value="{{ $user->social_link->pinterest }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="tiktok">Tiktok:</label>
                                                <input type="text" name="tiktok" class="form-control" id="tiktok"
                                                    value="{{ $user->social_link->tiktok }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="wechat">Wechat:</label>
                                                <input type="text" name="wechat" class="form-control" id="wechat"
                                                    value="{{ $user->social_link->wechat }}">
                                            </div>
                                        </div>
                                        <hr>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="reset" class="btn btn-warning">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
