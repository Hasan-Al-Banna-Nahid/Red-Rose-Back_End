@extends('admin.index')
@section('title')
    All Divisions
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" target="_blank">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('country.index') }}">{{ $country->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Divisions</li>
        </ul>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.address.division.component')
            <div class="col-sm-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Create Division</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form method="POST" action="{{ route('division.store') }}">
                            @csrf
                            <div class="form-group">
                                <input required type="text" name="name" class="form-control"
                                    placeholder="Divition Name">
                                <input required type="hidden" name="country_id" class="form-control"
                                    value="{{ $country->id }}">
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
