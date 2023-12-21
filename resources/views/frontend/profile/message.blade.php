@extends('layouts.frontend')
@section('title')
    Chat
@endsection
@section('content')
    <div class="container-fluid" style="height: 85vh">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-body chat-page p-0">
                        <div class="chat-data-block">
                            <div class="row">
                                <div class="col-lg-3 chat-data-left scroller">
                                    <div class="chat-search pt-3 pl-3">
                                        <div class="d-flex align-items-center">
                                            <div class="chat-profile mr-3">
                                                @if (Auth::user()->profile_photo_path != null)
                                                    <img src="{{ Auth::user()->profile_photo_path }}" class="avatar-60"
                                                        alt="user">
                                                @else
                                                    <img src="{{ asset('images/user_01.jpg') }}" class="avatar-60"
                                                        alt="user">
                                                @endif
                                            </div>
                                            <div class="chat-caption">
                                                <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                                <a href="/pointhistory">
                                                    <p class="m-0">RedRose Point: {{ Auth::user()->profile->points }}</p>
                                                </a>
                                            </div>
                                            <button type="submit" class="close-btn-res p-3"><i
                                                    class="ri-close-fill"></i></button>
                                        </div>
                                        <div id="user-detail-popup" class="scroller">
                                            <div class="user-profile">
                                                <button type="submit" class="close-popup p-3"><i
                                                        class="ri-close-fill"></i></button>
                                                <div class="user text-center mb-4">
                                                    <a class="avatar m-0">
                                                        @if (Auth::user()->profile_photo_path != null)
                                                            <img src="{{ Auth::user()->profile_photo_path }}"
                                                                class="avatar" alt="user">
                                                        @else
                                                            <img src="{{ asset('images/user_01.jpg') }}" class="avatar"
                                                                alt="user">
                                                        @endif
                                                    </a>
                                                    <div class="user-name mt-4">
                                                        <h4>{{ Auth::user()->name }}</h4>
                                                    </div>
                                                    <div class="user-desc">
                                                        <p>{{ Auth::user()->profile->bio }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat-sidebar-channel scroller">
                                        <ul class="iq-chat-ui nav flex-column nav-pills">
                                            @foreach ($chatList as $list)
                                                <li>
                                                    @if (Auth::user()->id == $list->receiver_id)
                                                        <a role="tab" href="/chatmessage/{{ $list->id }}">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar mr-3">
                                                                    @if ($list->user->profile_photo_path != null)
                                                                        <img src="{{ $list->user->profile_photo_path }}"
                                                                            class="avatar-50" alt="user">
                                                                    @else
                                                                        <img src="{{ asset('images/user_01.jpg') }}"
                                                                            class="avatar-50" alt="user">
                                                                    @endif
                                                                    @if ($list->user->status == 1)
                                                                        <span class="avatar-status"><i
                                                                                class="ri-checkbox-blank-circle-fill text-success"></i></span>
                                                                    @endif
                                                                </div>
                                                                <div class="chat-sidebar-name">
                                                                    <h6 class="mb-0">{{ $list->user->name }}</h6>
                                                                    <span>{{ $list->lastmessage }}</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @elseif (Auth::user()->id == $list->sender_id)
                                                        <a role="tab" href="/chatmessage/{{ $list->id }}">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar mr-3">
                                                                    @if ($list->receiver->profile_photo_path != null)
                                                                        <img src="{{ $list->receiver->profile_photo_path }}"
                                                                            class="avatar-50" alt="user">
                                                                    @else
                                                                        <img src="{{ asset('images/user_01.jpg') }}"
                                                                            class="avatar-50" alt="user">
                                                                    @endif
                                                                    @if ($list->receiver->status == 1)
                                                                        <span class="avatar-status"><i
                                                                                class="ri-checkbox-blank-circle-fill text-success"></i></span>
                                                                    @endif
                                                                </div>
                                                                <div class="chat-sidebar-name">
                                                                    <h6 class="mb-0">{{ $list->receiver->name }}</h6>
                                                                    <span>{{ $list->lastmessage }}</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif

                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-lg-9 chat-data p-0 chat-data-right">
                                    <div class="tab-content">
                                        @if ($user == 'off')
                                            <div class="tab-pane fade active show" id="default-block" role="tabpanel">
                                                <div class="chat-start">
                                                    <span class="iq-start-icon text-primary"><i
                                                            class="ri-message-3-line"></i></span>
                                                    <button id="chat-start" class="btn bg-white mt-3"> <a href="/my-friend"> Start
                                                        Conversation!</a></button>
                                                </div>
                                            </div>
                                        @else
                                            <div class="tab-pane fade active show" id="chatbox1" role="tabpanel">
                                                <div class="chat-head">
                                                    <header
                                                        class="d-flex justify-content-between align-items-center bg-white pt-3 pr-3 pb-3">
                                                        <div class="d-flex align-items-center">
                                                            <div id="sidebar-toggle" class="sidebar-toggle">
                                                                <i class="ri-menu-3-line"></i>
                                                            </div>
                                                            <div class="avatar chat-user-profile m-0 mr-3">
                                                                @if ($user->profile_photo_path != null)
                                                                    <img src="{{ $user->profile_photo_path }}"
                                                                        class="avatar-50" alt="user">
                                                                @else
                                                                    <img src="{{ asset('images/user_01.jpg') }}"
                                                                        class="avatar-50" alt="user">
                                                                @endif
                                                                @if ($user->status == 1)
                                                                    <span class="avatar-status"><i
                                                                            class="ri-checkbox-blank-circle-fill text-success"></i></span>
                                                                @endif
                                                            </div>
                                                            <h5 class="mb-0">{{ $user->name }}</h5>
                                                            {{-- @if ($user->status == 0)
                                                                <p>Not active</p>
                                                            @endif --}}
                                                        </div>
                                                        <div id="chat-user-detail-popup" class="scroller"
                                                            class="scroller">
                                                            <div class="user-profile text-center">
                                                                <button type="submit" class="close-popup p-3"><i
                                                                        class="ri-close-fill"></i></button>
                                                                <div class="user mb-4">
                                                                    <a class="avatar m-0">
                                                                        @if ($user->profile_photo_path != null)
                                                                            <img src="{{ $user->profile_photo_path }}"
                                                                                class="avatar-50" alt="user">
                                                                        @else
                                                                            <img src="{{ asset('images/user_01.jpg') }}"
                                                                                class="avatar-50" alt="user">
                                                                        @endif
                                                                    </a>
                                                                    <div class="user-name mt-4">
                                                                        <h4>{{ $user->name }}</h4>
                                                                    </div>
                                                                    <div class="user-desc">
                                                                        <p>{{ $user->profile->bio }}</p>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="chatuser-detail text-left mt-4">
                                                                    <div class="row">
                                                                        <div class="col-6 col-md-6 title">Phone:</div>
                                                                        <div class="col-6 col-md-6 text-right">
                                                                            {{ $user->profile->phone }}</div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-6 col-md-6 title">Date Of Birth:
                                                                        </div>
                                                                        <div class="col-6 col-md-6 text-right">
                                                                            {{ $user->profile->birthday }}</div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-6 col-md-6 title">Gender:</div>
                                                                        <div class="col-6 col-md-6 text-right">
                                                                            {{ $user->profile->gender }}</div>
                                                                    </div>
                                                                    <hr>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="chat-header-icons d-flex">
                                                            <button type="submit" data-toggle="modal"
                                                                data-target="#modalCenter"
                                                                class="btn btn-primary d-flex align-items-center p-2"><i
                                                                    class="fa fa-paper-plane-o"
                                                                    aria-hidden="true"></i><span
                                                                    class="d-none d-lg-block ml-1">Send Points</span>
                                                            </button>
                                                            <div class="modal fade" id="modalCenter" tabindex="-1"
                                                                role="dialog" aria-labelledby="modalCenterTitle"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered"
                                                                    role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="modalCenterTitle">
                                                                                Send Points to {{ $user->name }}
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="/sendpoints/{{ $user->id }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <label for="points">Give points to
                                                                                    send</label>
                                                                                <input class="form-control" type="number"
                                                                                    name="message" id="points">
                                                                                <input type="hidden" name="chatid"
                                                                                    value="{{ $chatid }}">
                                                                                <input type="submit" value="Submit">
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit" data-toggle="modal"
                                                                data-target="#modalCenterCC"
                                                                class="btn btn-primary d-flex align-items-center ml-2 p-2"><i
                                                                    class="fa fa-paper-plane-o"
                                                                    aria-hidden="true"></i><span
                                                                    class="d-none d-lg-block ml-1">Share Contact
                                                                    Card</span>
                                                            </button>
                                                            <div class="modal fade" id="modalCenterCC" tabindex="-1"
                                                                role="dialog" aria-labelledby="modalCenterCCTitle"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered"
                                                                    role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="modalCenterCCTitle">
                                                                                Share Contact Card to {{ $user->name }}
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form class="from-control"
                                                                                action="/sendcard/{{ $user->id }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <select name="message"
                                                                                    class="custom-select">
                                                                                    @foreach ($friendsList as $list)
                                                                                        <option
                                                                                            value="{{ $list->user->id }}">
                                                                                            {{ $list->user->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <input type="hidden" name="chatid"
                                                                                    value="{{ $chatid }}">
                                                                                <input class="mt-2 from-control"
                                                                                    type="submit" value="Submit">
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <a href="javascript:void();" class="chat-icon-phone">
                                                                <i class="ri-phone-line"></i>
                                                            </a>
                                                            <a href="javascript:void();" class="chat-icon-video">
                                                                <i class="ri-vidicon-line"></i>
                                                            </a>
                                                            <a href="javascript:void();" class="chat-icon-delete">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </a> --}}
                                                            {{-- <span class="dropdown">
                                                                <i class="ri-more-2-line cursor-pointer dropdown-toggle nav-hide-arrow cursor-pointer pr-0"
                                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false"
                                                                    role="menu"></i>
                                                                <span class="dropdown-menu dropdown-menu-right"
                                                                    aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item" href="JavaScript:void(0);"><i
                                                                            class="fa fa-thumb-tack"
                                                                            aria-hidden="true"></i>
                                                                        Pin to top</a>
                                                                    <a class="dropdown-item" href="JavaScript:void(0);"><i
                                                                            class="fa fa-trash-o" aria-hidden="true"></i>
                                                                        Delete chat</a>
                                                                    <a class="dropdown-item" href="JavaScript:void(0);"><i
                                                                            class="fa fa-ban" aria-hidden="true"></i>
                                                                        Block</a>
                                                                </span>
                                                            </span> --}}
                                                        </div>
                                                    </header>
                                                </div>
                                                <div class="chat-content scroller">
                                                    @foreach ($messagelist as $list)
                                                        @if ($list->sender_id == Auth::user()->id)
                                                            <div class="chat">
                                                                <div class="chat-user">
                                                                    <a class="avatar m-0">
                                                                        @if ($list->sender->profile_photo_path != null)
                                                                            <img src="{{ $list->sender->profile_photo_path }}"
                                                                                class="avatar-35" alt="user">
                                                                        @else
                                                                            <img src="{{ asset('images/user_01.jpg') }}"
                                                                                class="avatar-35" alt="user">
                                                                        @endif
                                                                    </a>
                                                                    <span class="chat-time mt-1">6:45</span>
                                                                </div>
                                                                <div class="chat-detail">
                                                                    <div class="chat-message">
                                                                        @if ($list->type == 'text')
                                                                            <p>{{ $list->message }}</p>
                                                                        @elseif ($list->type == 'points')
                                                                            <p>You send
                                                                                {{ $user->name . ' ' . $list->message . ' points' }}
                                                                            </p>
                                                                        @elseif ($list->type == 'contactcard')
                                                                            <p>You send
                                                                                {{ $user->name . ' "' }} <a
                                                                                    href="/viewprofile/{{ $list->user->id }}"
                                                                                    class="text-white">
                                                                                    {{ $list->user->name }} </a>
                                                                                {{ '" contact card' }}
                                                                            </p>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @elseif ($list->receiver_id == Auth::user()->id)
                                                            <div class="chat chat-left">
                                                                <div class="chat-user">
                                                                    <a class="avatar m-0">
                                                                        @if ($list->sender->profile_photo_path != null)
                                                                            <img src="{{ $list->sender->profile_photo_path }}"
                                                                                class="avatar-35" alt="user">
                                                                        @else
                                                                            <img src="{{ asset('images/user_01.jpg') }}"
                                                                                class="avatar-35" alt="user">
                                                                        @endif
                                                                    </a>
                                                                    <span class="chat-time mt-1">6:48</span>
                                                                </div>
                                                                <div class="chat-detail">
                                                                    <div class="chat-message">
                                                                        @if ($list->type == 'text')
                                                                            <p>{{ $list->message }}</p>
                                                                        @elseif ($list->type == 'points')
                                                                            <p>{{ $user->name . ' send ' . $list->message . ' points' }}
                                                                            </p>
                                                                        @elseif ($list->type == 'contactcard')
                                                                            <p>
                                                                                {{ $user->name . ' send you an contact card of "' }}
                                                                                <a class="text-white"
                                                                                    href="/viewprofile/{{ $list->user->id }}">
                                                                                    {{ $list->user->name }} </a>
                                                                                {{ '"' }}
                                                                            </p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="chat-footer p-3 bg-white">
                                                    <form class="d-flex align-items-center" method="POST"
                                                        action="/chatmessage/{{ $chatid }}">
                                                        @csrf
                                                        <div class="chat-attagement d-flex">
                                                            <a href="javascript:void();"><i class="fa fa-smile-o pr-3"
                                                                    aria-hidden="true"></i></a>
                                                            <a data-toggle="modal" data-target="#modal"><i
                                                                    class="fa fa-paperclip pr-3"
                                                                    aria-hidden="true"></i></a>
                                                        </div>
                                                        <input type="hidden" name="receiver_id"
                                                            value="{{ $user->id }}">
                                                        <input type="text" name="message" class="form-control mr-3"
                                                            placeholder="Type your message">
                                                        <button type="submit"
                                                            class="btn btn-primary d-flex align-items-center p-2"><i
                                                                class="fa fa-paper-plane-o" aria-hidden="true"></i><span
                                                                class="d-none d-lg-block ml-1">Send</span></button>
                                                    </form>
                                                </div>
                                                <div class="modal fade" id="modal" tabindex="-1" role="dialog"
                                                    aria-labelledby="modalTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalTitle">
                                                                    Choose option
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body d-flex">
                                                                <button type="submit" data-toggle="modal"
                                                                    data-target="#modalCenter"
                                                                    class="btn btn-primary d-flex align-items-center close"
                                                                    data-dismiss="modal"><i
                                                                        class="fa fa-paper-plane-o"
                                                                        aria-hidden="true"></i><span
                                                                        class="d-none d-lg-block ml-1">Send Points</span>
                                                                </button>
                                                                <div class="modal fade" id="modalCenter" tabindex="-1"
                                                                    role="dialog" aria-labelledby="modalCenterTitle"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered"
                                                                        role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="modalCenterTitle">
                                                                                    Send Points to {{ $user->name }}
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form
                                                                                    action="/sendpoints/{{ $user->id }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    <label for="points">Give points to
                                                                                        send</label>
                                                                                    <input class="form-control"
                                                                                        type="number" name="message"
                                                                                        id="points">
                                                                                    <input type="hidden" name="chatid"
                                                                                        value="{{ $chatid }}">
                                                                                    <input type="submit" value="Submit">
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" data-toggle="modal"
                                                                    data-target="#modalCenterCC"
                                                                    class="btn btn-primary d-flex align-items-center close"
                                                                    data-dismiss="modal"><i
                                                                        class="fa fa-paper-plane-o"
                                                                        aria-hidden="true"></i><span
                                                                        class="d-none d-lg-block ml-1">Share Contact
                                                                        Card</span>
                                                                </button>
                                                                <div class="modal fade" id="modalCenterCC" tabindex="-1"
                                                                    role="dialog" aria-labelledby="modalCenterCCTitle"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered"
                                                                        role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="modalCenterCCTitle">
                                                                                    Share Contact Card to
                                                                                    {{ $user->name }}
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form class="from-control"
                                                                                    action="/sendcard/{{ $user->id }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    <select name="message"
                                                                                        class="custom-select">
                                                                                        @foreach ($friendsList as $list)
                                                                                            <option
                                                                                                value="{{ $list->user->id }}">
                                                                                                {{ $list->user->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <input type="hidden" name="chatid"
                                                                                        value="{{ $chatid }}">
                                                                                    <input class="mt-2 from-control"
                                                                                        type="submit" value="Submit">
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
