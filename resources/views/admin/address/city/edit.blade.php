@extends('admin.index')
@section('title')
    Edit City
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" target="_blank">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('country.index') }}">{{ $division->country->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a
                    href="{{ route('division.index', $division->country_id) }}">{{ $division->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit City</li>
        </ul>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.address.city.component')
            <div class="col-sm-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Edit City</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form method="POST" action="{{ route('city.update', $city->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <input required type="text" name="name" class="form-control"
                                    value="{{ $city->name }}">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn iq-bg-danger" value="Cancel" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
