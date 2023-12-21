<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
        <a href="/superadmin">
            {{-- <img src="images/logo.png" class="img-fluid" alt=""> --}}
            <span>Redrose</span>
        </a>
        <div class="iq-menu-bt align-self-center">
            <div class="wrapper-menu">
                <div class="line-menu half start"></div>
                <div class="line-menu"></div>
                <div class="line-menu half end"></div>
            </div>
        </div>
    </div>
    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                @if (Auth::user()->user_type == 1)
                    <li class="iq-menu-title"><i class="ri-separator"></i><span>Super Admin</span></li>
                    <li class="active">
                        <a href="#dashboard" class="iq-waves-effect collapsed" data-toggle="collapse"
                            aria-expanded="false"><i class="ri-home-4-line"></i><span>Dashboard</span><i
                                class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="dashboard" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            <li><a href="/adminlist"><i class="las la-house-damage"></i>Admin</a></li>
                            <li><a href="/notification"><i class="las la-bell"></i>Notifications</a></li>
                            <li><a href="/supportlist"><i class="las la-bell"></i>support</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('event.index') }}"><i class="lab la-elementor"></i>Contest Management</a></li>
                    <li><a href="{{ route('modeltest.index') }}"><i class="lab la-elementor"></i>Modeltest Management</a></li>
                    {{-- <li>
                        <a href="#events" class="iq-waves-effect collapsed" data-toggle="collapse"
                            aria-expanded="false"><i class="ri-home-4-line"></i><span>Event Management</span><i
                                class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="events" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            <li><a href="{{ route('event.index') }}"><i class="lab la-elementor"></i>All Events</a></li>
                            <li><a href="{{ route('syllabus.index') }}"><i class="ri-file-pdf-line"> </i>Event
                                    Syllabus</a></li>
                            <li><a href="{{ route('question.index') }}"><i class="las la-file-alt iq-arrow-left"></i>Set
                                    Questions</a></li>
                            <li><a href="/participant"><i class="las la-file-alt iq-arrow-left"></i>All Participant</a>
                            </li>
                        </ul>
                    </li> --}}
                    {{-- <li>
                        <a href="#modeltest" class="iq-waves-effect collapsed" data-toggle="collapse"
                            aria-expanded="false"><i class="ri-home-4-line"></i><span>Model Test</span><i
                                class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="modeltest" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            <li><a href="{{ route('modeltest.create') }}"><i class="ri-file-pdf-line"> </i>Create Model
                                    Test</a></li>
                            <li><a href="{{ route('msyllabus.index') }}"><i class="ri-file-pdf-line"> </i>Syllabus</a>
                            </li>
                            <li><a href="{{ route('mquestion.index') }}"><i
                                        class="las la-file-alt iq-arrow-left"></i>Set Question</a>
                            </li>
                        </ul>
                    </li> --}}
                    {{-- <li>
                        <a href="#result" class="iq-waves-effect collapsed" data-toggle="collapse"
                            aria-expanded="false"><i class="ri-home-4-line"></i><span>Results</span><i
                                class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="result" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            <li><a href="{{ route('event.result') }}"><i class="las la-house-damage"></i>Event
                                    Result</a></li>
                            <li><a href="{{ route('modeltest.result') }}"><i class="las la-house-damage"></i>Model Tset
                                    Result</a></li>
                        </ul>
                    </li> --}}
                    <li>
                        <a href="#alluser" class="iq-waves-effect collapsed" data-toggle="collapse"
                            aria-expanded="false"><i class="ri-home-4-line"></i><span>User Management</span><i
                                class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="alluser" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            <li><a href="/alluser"><i class="las la-house-damage"></i>All User</a></li>
                            <li><a href="#"><i class="las la-house-damage"></i>As a Student</a></li>
                            <li><a href="#"><i class="las la-house-damage"></i>As a Teacher</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#settings" class="iq-waves-effect collapsed" data-toggle="collapse"
                            aria-expanded="false"><i class="ri-home-4-line"></i><span>Settings</span><i
                                class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="settings" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            <li><a href="/allclass"><i class="lab la-elementor"></i>Class</a></li>
                            <li><a href="{{ route('country.index') }}"><i class="las la-house-damage"></i>Address</a>
                            </li>
                            <li><a href="{{ route('blog.create') }}"><i class="las la-house-damage"></i>Blogs</a></li>
                            <li><a href="{{ route('page.create') }}"><i class="las la-house-damage"></i>Pages</a></li>
                            <li>
                                <a href="/slider" class="iq-waves-effect"><i
                                        class="ri-record-circle-line iq-arrow-left"></i>
                                    <span>Slider</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif (Auth::user()->user_type == 3)
                    <li class="iq-menu-title"><i class="ri-separator"></i><span>Admin</span></li>
                    <li class="active">
                        <a href="#dashboard" class="iq-waves-effect collapsed" data-toggle="collapse"
                            aria-expanded="false"><i class="ri-home-4-line"></i><span>Dashboard</span><i
                                class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="dashboard" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            <li><a href="/event"><i class="lab la-elementor"></i>Events</a></li>
                        </ul>
                    </li>
                @elseif (Auth::user()->user_type == 4)
                    <li class="iq-menu-title"><i class="ri-separator"></i><span>Admin</span></li>
                    <li class="active">
                        <a href="#dashboard" class="iq-waves-effect collapsed" data-toggle="collapse"
                            aria-expanded="false"><i class="ri-home-4-line"></i><span>Dashboard</span><i
                                class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="dashboard" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            <li><a href="/syllabus"><i class="ri-file-pdf-line"> </i>Syllabus</a></li>
                            <li><a href="/question"><i class="las la-file-alt iq-arrow-left"></i>Questions</a></li>
                        </ul>
                    </li>
                @elseif (Auth::user()->user_type == 5 || Auth::user()->user_type == 6)
                    <li class="iq-menu-title"><i class="ri-separator"></i><span>Admin</span></li>
                    <li class="active">
                        <a href="#dashboard" class="iq-waves-effect collapsed" data-toggle="collapse"
                            aria-expanded="false"><i class="ri-home-4-line"></i><span>Dashboard</span><i
                                class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="dashboard" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            <li><a href="/supportcreate"><i class="las la-bell"></i>Request a support</a></li>
                            <li><a href="/support"><i class="las la-bell"></i>My support</a></li>
                        </ul>
                    </li>
                @endif
                <li>
                    <a href="/clear-cash" class="iq-waves-effect collapsed"><i
                            class="ri-record-circle-line iq-arrow-left"></i>
                        <span>Clear Cash</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="p-3"></div>
    </div>
</div>
