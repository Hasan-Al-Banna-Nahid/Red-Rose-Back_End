@extends('admin.index')
@section('title')
    blog Panel
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" target="_blank">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit blog</li>
        </ul>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.blog.component')
            <div class="col-sm-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Edit blog</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form method="POST" action="{{ route('blog.update', $blog->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">blog Name</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ $blog->name }}">
                            </div>
                            <div class="form-group">
                                <label for="description">blog Description</label>
                                <textarea class="form-control" name="description" id="description" rows="5">
                                    {{ $blog->description }}
                                </textarea>
                            </div>
                            <img height="250" width="250" src="{{ $blog->image_path }}">
                            <div class="form-group">
                                <label class="form-control-file" for="customFile">blog Feature Image</label>
                                <input name="image_path" type="file" class="form-control-file" id="customFile">
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
