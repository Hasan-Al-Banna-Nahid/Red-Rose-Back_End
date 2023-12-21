@extends('front.layouts.app')
@section('title')
    Home
@endsection
@section('content')
{{-- @section('nav') --}}
@include('front.layouts.partial._navbar')
{{-- @endsection --}}
    <!-------------course---------------->
    <section class="course">
        <h1>Courses We Offer</h1>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deserunt, minima!</p>
        <div class="row">
            <div class="course-col">
                <h3>Intermediate</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum repellat optio dolor laboriosam minima
                    libero cupiditate explicabo placeat porro obcaecati.</p>
            </div>
            <div class="course-col">
                <h3>degree</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum repellat optio dolor laboriosam minima
                    libero cupiditate explicabo placeat porro obcaecati.</p>
            </div>
            <div class="course-col">
                <h3>post graduate</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum repellat optio dolor laboriosam minima
                    libero cupiditate explicabo placeat porro obcaecati.</p>
            </div>
        </div>
    </section>
    <!-------------campus---------------->
    <section class="campus">
        <h1>Our Global campus</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quas, vel.</p>
        <div class="row">
            <div class="campus-col">
                <img src="{{ asset('frontend/picture/london.png') }}" alt="#">
                <div class="layer">
                    <h3>london</h3>
                </div>
            </div>
            <div class="campus-col">
                <img src="{{ asset('frontend/picture/newyork.png') }}" alt="#">
                <div class="layer">
                    <h3>NEW YORK</h3>
                </div>
            </div>
            <div class="campus-col">
                <img src="{{ asset('frontend/picture/washington.png') }}" alt="#">
                <div class="layer">
                    <h3>WASHINGTON</h3>
                </div>
            </div>
        </div>
    </section>
    <!-------------facilities---------------->
    <section class="facilities">
        <h1>Our Facilities</h1>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Maiores, sit?</p>
        <div class="row">
            <div class="facilities-col">
                <img src="{{ asset('frontend/picture/library.png') }}" alt="#">
                <h3>World class Library</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facere expedita minus sunt, obcaecati
                    eveniet voluptate.</p>
            </div>
            <div class="facilities-col">
                <img src="{{ asset('frontend/picture/basketball.png') }}" alt="#">
                <h3>Largest Play Ground</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facere expedita minus sunt, obcaecati
                    eveniet voluptate.</p>
            </div>
            <div class="facilities-col">
                <img src="{{ asset('frontend/picture/cafeteria.png') }}" alt="#">
                <h3>Tasty and Healthy Food</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facere expedita minus sunt, obcaecati
                    eveniet voluptate.</p>
            </div>
        </div>
    </section>
    <!-- -------testimonials--------- -->
    <section class="testimonials">
        <h1>What our Students Says</h1>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Maiores, sit?</p>
        <div class="row">
            <div class="testimonials-col">
                <img src="{{ asset('frontend/picture/user1.jpg') }}" alt="#">
                <div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque possimus a quam quas omnis
                        accusantium ullam, veniam impedit molestias rerum.</p>
                    <h3>Christine Berkley</h3>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                </div>
            </div>
            <div class="testimonials-col">
                <img src="{{ asset('frontend/picture/user2.jpg') }}" alt="#">
                <div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque possimus a quam quas omnis
                        accusantium ullam, veniam impedit molestias rerum.</p>
                    <h3>David Bayer</h3>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-half-o"></i>
                </div>
            </div>
        </div>
    </section>
    <!-- --------call to Action------ -->
    <section class="cta">
        <h1>Enroll For Various Online Courses <br>Anywhere From The Bangladesh.</h1>
        <a href="#" class="hero-btn">CONTACT US</a>
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
