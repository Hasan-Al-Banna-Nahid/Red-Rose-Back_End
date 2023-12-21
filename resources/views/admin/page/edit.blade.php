@extends('admin.index')
@section('title')
    page Panel
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" target="_blank">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit page</li>
        </ul>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.page.component')
            <div class="col-sm-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Edit page</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form method="POST" action="{{ route('page.update', $page->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">page title</label>
                                <input type="text" name="title" class="form-control" id="title" value="{{ $page->title }}">
                            </div>
                            <div class="form-group">
                                <label for="description">page Description</label>
                                <textarea class="form-control" name="description" id="description" rows="5">{{ $page->description }}</textarea>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Update" />
                            <input type="reset" class="btn iq-bg-danger" value="Cancel" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
