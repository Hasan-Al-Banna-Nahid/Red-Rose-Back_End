@extends('layouts.admin')
@section('title')
    RedRose
@endsection
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" target="_blank">Home</a></li>
            @if (Auth::user()->user_type == 1)
                <li class="breadcrumb-item active" aria-current="page">Super Admin</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Admin</li>
            @endif
        </ul>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @if (Auth::user()->user_type == 1)
                <div class="col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-body pb-0">
                            <div class="rounded-circle iq-card-icon iq-bg-primary"><i class="ri-exchange-dollar-fill"></i>
                            </div>
                            <span class="float-right line-height-6"><a href="/adminlist">Admin</a></span>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <h2 class="mb-0"><span class="counter">{{ session()->get('adminCount') }}</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-body pb-0">
                            <div class="rounded-circle iq-card-icon iq-bg-warning"><i class="ri-bar-chart-grouped-line"></i>
                            </div>
                            <span class="float-right line-height-6"><a href="{{ route('event.index') }}">Contest</a></span>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <h2 class="mb-0"><span></span><span
                                        class="counter">{{ session()->get('eventCount') }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-body pb-0">
                            <div class="rounded-circle iq-card-icon iq-bg-success"><i class="ri-group-line"></i></div>
                            <span class="float-right line-height-6"><a href="/syllabus">Syllabus</a></span>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <h2 class="mb-0"><span class="counter">{{ session()->get('syllabusCount') }}</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-body pb-0">
                            <div class="rounded-circle iq-card-icon iq-bg-danger"><i class="ri-shopping-cart-line"></i>
                            </div>
                            <span class="float-right line-height-6"><a href="/question">Question</a></span>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <h2 class="mb-0"><span class="counter">{{ session()->get('questionCount') }}</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-body pb-0">
                            <div class="rounded-circle iq-card-icon iq-bg-danger"><i class="ri-shopping-cart-line"></i>
                            </div>
                            <span class="float-right line-height-6"><a href="/alluser">User</a></span>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <h2 class="mb-0"><span class="counter">{{ session()->get('userCount') }}</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-body pb-0">
                            <div class="rounded-circle iq-card-icon iq-bg-danger"><i class="ri-shopping-cart-line"></i>
                            </div>
                            <span class="float-right line-height-6"><a href="/participant">All Participant</a></span>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <h2 class="mb-0"><span class="counter">{{ session()->get('participantCount') }}</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif (Auth::user()->user_type == 3)
                <div class="col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-body pb-0">
                            <div class="rounded-circle iq-card-icon iq-bg-warning"><i class="ri-bar-chart-grouped-line"></i>
                            </div>
                            <span class="float-right line-height-6"><a href="/event">Contest</a></span>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <h2 class="mb-0"><span></span><span
                                        class="counter">{{ session()->get('eventCount') }}</span>
                                </h2>
                            </div>
                        </div>
                        <div id="chart-2"></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3"></div>
                <div class="col-md-6 col-lg-3"></div>
            @elseif (Auth::user()->user_type == 4)
                <div class="col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-body pb-0">
                            <div class="rounded-circle iq-card-icon iq-bg-success"><i class="ri-group-line"></i></div>
                            <span class="float-right line-height-6"><a href="/syllabus">Syllabus</a></span>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <h2 class="mb-0"><span class="counter">{{ session()->get('syllabusCount') }}</span></h2>
                            </div>
                        </div>
                        <div id="chart-3"></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-body pb-0">
                            <div class="rounded-circle iq-card-icon iq-bg-danger"><i class="ri-shopping-cart-line"></i>
                            </div>
                            <span class="float-right line-height-6"><a href="/question">Question</a></span>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <h2 class="mb-0"><span class="counter">{{ session()->get('questionCount') }}</span>
                                </h2>
                            </div>
                        </div>
                        <div id="chart-4"></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3"></div>
            @else
            @endif
        </div>
    </div>
@endsection
