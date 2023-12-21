@extends('layouts.admin')
@section('title')
    All Participant
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> All Participent </h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <div class="table-responsive">
                            <table id="user-list-table" class="table table-striped table-bordered mt-4" role="grid"
                                aria-describedby="user-list-page-info">
                                <thead>
                                    <tr>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Contest</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($enrolllist as $list)
                                        <tr>
                                            <td class="text-center">
                                                @if ($list->user->profile_photo_path != null)
                                                <img class="img-fluid rounded-circle avatar-40" src="{{ $list->user->profile_photo_path }}" alt="profile">
                                                @else
                                                <img class="img-fluid rounded-circle avatar-40" src="images/user_01.jpg" alt="profile">                                                    
                                                @endif
                                            </td>
                                            <td>{{ $list->user->name }}</td>
                                            <td>{{ $list->events->name }}</td>
                                            <td>{{ $list->events->status }}</td>
                                            <td>
                                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                                    <div class="dropdown">
                                                        <span class="dropdown-toggle text-primary" id="dropdownMenuButton5"
                                                            data-toggle="dropdown">
                                                            <a href=""><i class="ri-more-fill"></i></a>
                                                        </span>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton5">
                                                            <a class="dropdown-item" href=""><i class="ri-eye-fill mr-2"></i>View</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="">{{ $enrolllist->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
