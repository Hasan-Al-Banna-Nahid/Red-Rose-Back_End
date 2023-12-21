@extends('admin.index')
@section('title')
    All Model Test
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" target="_blank">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Class</li>
        </ul>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.model_test.component')
            <div class="col-sm-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Create Model Test</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form method="POST" action="{{ route('modeltest.store') }}">
                            @csrf
                            <div class="form-group">
                                <input required type="text" name="name" class="form-control" id="name"
                                    placeholder="Model Test Name">
                            </div>
                            <div class="form-group">
                                <label for="allclass_id">Select Class</label>
                                <select required name="allclass_id" id="allclass_id" class="custom-select">
                                    @foreach ($classlist as $list)
                                        <option value="{{ $list->id }}">{{ $list->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input required type="text" name="subject" class="form-control" id="name"
                                    placeholder="Subjetc Name">
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
