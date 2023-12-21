<!DOCTYPE html>
<html lang="en">

<head>
    <title>RedRose Academy</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('landing/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/style.css') }}">
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar ftco-navbar-light site-navbar-target" id="ftco-navbar">
        <div class="container">
            <a href="/" class="btn btn-primary py-3 px-4" style="font-size: 16px"><b>Red Rose Academy</b></a>
            <button class="navbar-toggler js-fh5co-nav-toggle fh5co-nav-toggle" type="button" data-toggle="collapse"
                data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span>Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav nav ml-auto">
                    <li class="nav-item"><a href="#home-section" class="nav-link"><span>Home</span></a></li>
                    <li class="nav-item"><a href="{{ route('blog.index') }}" class="nav-link"><span>Blog</span></a></li>
                    {{-- <li class="nav-item"><a href="#author-section" class="nav-link"><span>Author</span></a></li> --}}
                    @auth
                        <li class="nav-item"><a href="/home" class="nav-link"><span>Dashboard</span></a></li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link"><span>Login</span></a></li>
                        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link"><span>Signup</span></a></li>
                    @endauth
                    <li class="nav-item"><a href="#contact-section" class="nav-link"><span>Contact</span></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="hero-wrap js-fullheight">
        <div class="overlay"></div>
        <div class="container-fluid px-0">
            <div class="row d-md-flex no-gutters slider-text align-items-center js-fullheight justify-content-end">
                <img class="one-third js-fullheight align-self-end order-md-last img-fluid mt-5"
                    src="{{ asset('landing/images/undraw_book_lover_mkck.svg') }}" alt="">
                <div class="one-forth d-flex align-items-center ftco-animate js-fullheight">
                    <div class="text mt-5">
                        <h3>রেড রোজ একাডেমিতে উপভোগের মাধ্যমে অধ্যয়ন করুন। এখন থেকে পড়াশোনায় বিরক্তি এড়াতে আমাদের
                            সাথে যুক্ত হন। আপনার বন্ধুদের ও শিক্ষার্থীদের সাইন আপ করতে উৎসাহিত করুন, এবং জিতে নিন নানা
                            পুরস্কার এবং মডেল টেস্ট পরীক্ষা দেবার মাদ্ধমে পান রেড রোজ পয়েন্ট।</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section ftco-no-pt">
        <div class="container">
            <div class="row justify-content-center py-5 mt-5">
                <div class="col-md-5 heading-section text-center ftco-animate">
                    <span class="subheading">
                        <h2 class="mb-4">Our Services</h2>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 text-center d-flex ftco-animate">
                    <div class="services-1 bg-light">
                        <span class="icon">
                            <img src="{{ asset('images/service_01.jpg') }}" height="150" width="100%"
                                alt="">
                        </span>
                        <div class="desc">
                            <h3 class="mb-5">Private tutore</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center d-flex ftco-animate">
                    <div class="services-1 bg-light">
                        <span class="icon">
                            <img src="{{ asset('images/service_02.jpg') }}" height="150" width="100%"
                                alt="">
                        </span>
                        <div class="desc">
                            <a href="/events">
                                <h3 class="mb-5">Contest</h3>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center d-flex ftco-animate">
                    <div class="services-1 bg-light">
                        <span class="icon">
                            <img src="{{ asset('images/service_03.jpg') }}" height="150" width="100%"
                                alt="">
                        </span>
                        <div class="desc">
                            <a href="/modeltest">
                                <h3 class="mb-5">Model Test</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="ftco-footer">
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-8">
                    <div class="ftco-footer-widget">
                        <h2 class="ftco-heading-2">About Us</h2>
                        <p>রেড রোজ Academyতে আপনি আনন্দ ও প্রতিযোগিতার   মাধ্যমেশিক্ষা অর্জন করতে পারেন <a href="{{ route('about.show') }}">View More</a> </p>
                        <ul>
                            <li><a href="#">Privacy policy</a></li>
                            <li><a href="#">Terms & Condition</a></li>
                        </ul>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                            <li class="ftco-animate"><a href="https://www.youtube.com/watch?v=ldKNFjxPg2A"
                                    target="-blank"><span class="fa fa-youtube"></span></a></li>
                            <li class="ftco-animate"><a
                                    href="https://www.facebook.com/profile.php?id=100082897614786&mibextid=ZbWKwL"
                                    target="-blank"><span class="fa fa-facebook"></span></a></li>
                            {{-- <li class="ftco-animate"><a href="#" target="-blank"><span class="fa fa-twitter"></span></a></li>
              <li class="ftco-animate"><a href="#" target="-blank"><span class="fa fa-instagram"></span></a></li> --}}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>
                        Copyright &copy; 2019 -
                        <script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved By <a href="/"> RedRose </a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div>
    <script src="{{ asset('landing/js/jquery.min.js') }}"></script>
    <script src="{{ asset('landing/js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('landing/js/popper.min.js') }}"></script>
    <script src="{{ asset('landing/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('landing/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('landing/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('landing/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('landing/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('landing/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('landing/js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('landing/js/scrollax.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="{{ asset('landing/js/google-map.js') }}"></script>
    <script src="{{ asset('landing/js/main.js') }}"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
    <!--<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v52afc6f149f6479b8c77fa569edb01181681764108816"
        -->
        <!--  integrity="sha512-jGCTpDpBAYDGNYR5ztKt4BQPGef1P0giN6ZGVUi835kFF88FOmmn8jBQWNgrNd8g/Yu421NdgWhwQoaOPFflDw=="
        -->
    <!--  data-cf-beacon='{"rayId":"7d5c2d56cf193e42","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2023.4.0","si":100}'-->
    <!--  crossorigin="anonymous"></script>-->
</body>

</html>
