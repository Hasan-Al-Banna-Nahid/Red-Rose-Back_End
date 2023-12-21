@extends('front.layouts.app')
@section('title')
    About
@endsection
@section('content')
    @include('front.layouts.partial._subnavbar')
    <h1>About Us</h1>
    <!-- -------about us content------------------->
    <section class="about-us">
        <div class="row">
            <div class="about-col">
                <h1>Bangladesh biggest online learning platform.</h1>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam atque cum harum laborum exercitationem
                    recusandae ipsam ullam. Saepe eaque nisi pariatur minus, libero quaerat accusamus laboriosam aperiam
                    voluptate exercitationem optio.</p>
                <a href="#" class="hero-btn red-btn">Explore Now</a>
            </div>
            <div class="about-col">
                <img src="{{ asset('frontend/picture/about.jpg') }}" alt="#">
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        var navLinks = document.getElementById("navLinks");

        function showMenu() {
            navLinks.style.right = "0";
        }

        function hideMenu() {
            navLinks.style.right = "-200px";
        }
    </script>
@endsection
