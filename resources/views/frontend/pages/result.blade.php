@extends('layouts.frontend')
@section('title')
    Event Result
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                <div class="card iq-mb-3">
                    <img src="{{ $event->image_path }}" class="card-img-top" alt="#">
                    <div class="card-body">
                        <h4 class="card-title">{{ $event->name }}</h4>
                        <span class="card-text">
                            <h6>Price: {{ $event->price }}</h6>
                        </span>
                        <span class="card-text">
                            <h6>Exam Date: {{ $event->date }}</h6>
                        </span>
                        <span class="card-text">
                            <h6>Exam Time: {{ $event->time }}</h6>
                        </span>
                        <span class="card-text">
                            <h6>Exam Type: {{ $event->type }} time<h6>
                        </span>
                        <span class="card-text">
                            <h6>Exam Duration: {{ $event->duration }} time<h6>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title text-left">{{ 'Event ' . $event->name . '\'s Result' }}</h4>
                        </div>
                        <div class="iq-header-title">
                            <h4 class="card-title text-right">
                                {{ $event->name . '\'s Participent (' . session()->get('enrollcount') . ')' }}</h4>
                        </div>

                    </div>
                    <div class="iq-card-body">
                        <div class="table-responsive">
                            <table id="user-list-table" class="table table-striped table-bordered mt-4" role="grid"
                                aria-describedby="user-list-page-info">
                                <thead>
                                    <tr>
                                        <th>Position</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Right Answer</th>
                                        <th>Wrong Answer</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resultlist as $i => $list)
                                        <tr>
                                            <td>{{ $i = $i + 1 }}</td>
                                            <td class="text-center">
                                                @if ($list->user->profile_photo_path != null)
                                                    <img class="img-fluid rounded-circle avatar-40"
                                                        src="{{ $list->user->profile_photo_path }}" alt="profile">
                                                @else
                                                    <img class="img-fluid rounded-circle avatar-40" src="images/user_01.jpg"
                                                        alt="profile">
                                                @endif
                                            </td>
                                            <td>{{ $list->user->name }}</td>
                                            <td>{{ $list->r_ans }}</td>
                                            <td>{{ $list->w_ans }}</td>
                                            <td>
                                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                                    <div class="dropdown">
                                                        <span class="dropdown-toggle text-primary" id="dropdownMenuButton5"
                                                            data-toggle="dropdown">
                                                            <a href=""><i class="ri-more-fill"></i></a>
                                                        </span>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenuButton5">
                                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                                data-target="#modalCenter"><i
                                                                    class="ri-eye-fill mr-2"></i>View</a>
                                                        </div>
                                                        <div class="modal fade" id="modalCenter" tabindex="-1"
                                                            role="dialog" aria-labelledby="modalCenterTitle"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="modalCenterTitle">
                                                                            Event Name: {{ $event->name }}
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <img src="{{ $event->image_path }}"
                                                                            class="card-img-top" height="200"
                                                                            width="100" alt="#">

                                                                        <div
                                                                            class="row d-flex justify-content-between mt-3">
                                                                            <div class="col-lg-6 text-left">
                                                                                Participante Name
                                                                            </div>
                                                                            <div class="col-lg-6 text-right">
                                                                                <a
                                                                                    href="/viewprofile/{{ $list->user->id }}">{{ $list->user->name }}</a>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="row d-flex justify-content-between">
                                                                            <div class="col-lg-6 text-left">
                                                                                Right Answered
                                                                            </div>
                                                                            <div class="col-lg-6 text-right">
                                                                                {{ $list->r_ans }}
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="row d-flex justify-content-between">
                                                                            <div class="col-lg-6 text-left">
                                                                                Wrong Answered
                                                                            </div>
                                                                            <div class="col-lg-6 text-right">
                                                                                {{ $list->w_ans }}
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="row d-flex justify-content-between">
                                                                            <div class="col-lg-6 text-left">
                                                                                Total Markes
                                                                            </div>
                                                                            <div class="col-lg-6 text-right">
                                                                                {{ $list->total_mark }}
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="row d-flex justify-content-between">
                                                                            <div class="col-lg-6 text-left">
                                                                                Negative Markes
                                                                            </div>
                                                                            <div class="col-lg-6 text-right">
                                                                                {{ $list->neg_mark }}
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="row d-flex justify-content-between">
                                                                            <div class="col-lg-6 text-left">
                                                                                Total Question
                                                                            </div>
                                                                            <div class="col-lg-6 text-right">
                                                                                {{ $list->total_q }}
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="">{{ $resultlist->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
