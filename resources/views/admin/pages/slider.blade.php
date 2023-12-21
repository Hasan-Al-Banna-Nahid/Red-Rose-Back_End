@extends('admin.index')
@section('title')
    {{ Auth::user()->name }}
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" target="_blank">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Mobile Slider</li>
        </ul>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Slider</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <table id="user-list-table" class="table table-striped table-bordered mt-1" role="grid"
                            aria-describedby="user-list-page-info">
                            <thead>
                                <tr>
                                    <th>Picture</th>
                                    <th>Type</th>
                                    <th>Image Path</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sliderlist as $list)
                                    <tr>
                                        <td><img src="{{ $list->image_path }}" height="50" width="100%" alt="">
                                        </td>
                                        <td>{{ $list->type }}</td>
                                        <td>{{ $list->image_path }}</td>
                                        <td>
                                            <div class="iq-card-header-toolbar d-flex align-items-center">
                                                <div class="dropdown">
                                                    <span class="dropdown-toggle text-primary" id="dropdownMenuButton5"
                                                        data-toggle="dropdown">
                                                        <a href="" class="align-items-center"><i
                                                                class="ri-more-fill"></i></a>
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="dropdownMenuButton5">
                                                        <a class="dropdown-item" href="/event/{{ $list->id }}/edit"><i
                                                                class="ri-pencil-fill mr-2"></i>Edit</a>
                                                        <form method="POST" action="/event/{{ $list->id }}">
                                                            @csrf
                                                            @method('delete')
                                                            <button href="" class="dropdown-item"><i
                                                                    class="ri-delete-bin-6-fill mr-2"></i>Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Add Slider</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form method="POST" action="/slider" enctype="multipart/form-data">
                            @csrf
                            {{-- <label>Select Slider Type</label>
                            <div class="">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input checked type="radio" id="customRadio1" value="web" name="type" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio1"> Web </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio2" value="mobile" name="type" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio2"> Mobile </label>
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <label class="form-control-file" for="customFile">Slider Image</label>
                                <input required name="image_path" type="file" class="form-control-file" id="customFile">
                            </div>
                            <input hidden value="mobile" name="type">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn iq-bg-danger" value="Cancel" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
