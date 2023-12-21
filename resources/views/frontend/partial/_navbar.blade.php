<div class="iq-top-navbar">
    <div class="iq-navbar-custom d-flex justify-content-between">
        <div class="iq-sidebar-logo">
            <div class="">
                <a href="/" class="logo text-black">
                    {{-- <img src="images/logo.png" class="img-fluid" alt=""> --}}
                    <span>RedRose</span>
                </a>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ri-menu-3-line"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-list">
                    <li>
                        <a href="#" class="search-toggle iq-waves-effect text-primary">Contest</a>
                        <div class="iq-sub-dropdown iq-user-dropdown">
                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height shadow-none m-0">
                                <div class="iq-card-body p-0 ">
                                    <a href="/events" class="iq-sub-card iq-bg-primary-hover">
                                        <div class="media align-items-center">
                                            <div class="media-body ml-3">
                                                <h6 class="mb-0">All Contest</h6>
                                            </div>
                                        </div>
                                    </a>
                                    @auth
                                        <a href="/myevents" class="iq-sub-card iq-bg-primary-hover">
                                            <div class="media align-items-center">
                                                <div class="media-body ml-3">
                                                    <h6 class="mb-0">My Contest</h6>
                                                </div>
                                            </div>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="#" class="search-toggle iq-waves-effect text-primary">Model Test</a>
                        <div class="iq-sub-dropdown iq-user-dropdown">
                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height shadow-none m-0">
                                <div class="iq-card-body p-0 ">
                                    <a href="/modeltest" class="iq-sub-card iq-bg-primary-hover">
                                        <div class="media align-items-center">
                                            <div class="media-body ml-3">
                                                <h6 class="mb-0">All Model Test</h6>
                                            </div>
                                        </div>
                                    </a>
                                    @auth
                                        <a href="/modeltest" class="iq-sub-card iq-bg-primary-hover">
                                            <div class="media align-items-center">
                                                <div class="media-body ml-3">
                                                    <h6 class="mb-0">Finished Model Test</h6>
                                                </div>
                                            </div>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><a href="{{ route('blog.index') }}" class="iq-waves-effect text-black">Blog</a></li>
                    <li><a href="#" class="iq-waves-effect text-black">Contact Us</a></li>
                    @auth
                        <li>
                            <a href="#" class="search-toggle iq-waves-effect text-white">
                                @if (Auth::user()->profile_photo_path != null)
                                    <img src="{{ Auth::user()->profile_photo_path }}"
                                        class="img-fluid rounded-circle mr-3" alt="user">
                                @else
                                    <img src="{{ asset('images/user_01.jpg') }}" class="img-fluid rounded-circle mr-3"
                                        alt="user">
                                @endif
                            </a>
                            <div class="iq-sub-dropdown iq-user-dropdown">
                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height shadow-none m-0">
                                    <div class="iq-card-body p-0 ">
                                        <div class="bg-primary p-3">
                                            <h5 class="mb-0 text-white line-height">{{ Auth::user()->name }}</h5>
                                        </div>
                                        <a href="/profile" class="iq-sub-card iq-bg-primary-hover">
                                            <div class="media align-items-center">
                                                <div class="rounded iq-card-icon iq-bg-primary">
                                                    <i class="ri-file-user-line"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                    <h6 class="mb-0 ">My Profile</h6>
                                                    <p class="mb-0 font-size-12">View personal profile details.</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="/chat" class="iq-sub-card iq-bg-primary-hover">
                                            <div class="media align-items-center">
                                                <div class="rounded iq-card-icon iq-bg-primary">
                                                    <i class="ri-file-user-line"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                    <h6 class="mb-0 ">Chat</h6>
                                                    <p class="mb-0 font-size-12">View personal Chat list.</p>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="d-inline-block w-100 text-center p-3">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button class="iq-bg-danger iq-sign-btn" href="sign-in.html"
                                                    role="button">Logout<i class="ri-login-box-line ml-2"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" class="iq-waves-effect text-black">Sign In</a></li>
                        <li><a href="{{ route('register') }}" class="iq-waves-effect text-black">Sign Up</a></li>
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
</div>
