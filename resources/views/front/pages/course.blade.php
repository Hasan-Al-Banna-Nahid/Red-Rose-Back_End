@extends('front.layouts.app')
@section('title')
    Course
@endsection
@section('content')
    <h1>Our Courses</h1>
    </section>

    <!-- ---------Course--------------->

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
    <!-- ----------Facilities-------- -->

    <section class="facilities">
        <h1>Our Facilities</h1>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Maiores, sit?</p>

        <div class="row">
            <div class="facilities-col">
                <img src="{{asset('frontend/picture/library.png')}}" alt="#">
                <h3>World class Library</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facere expedita minus sunt, obcaecati eveniet
                    voluptate.</p>
            </div>

            <div class="facilities-col">
                <img src="{{asset('frontend/picture/basketball.png')}}" alt="#">
                <h3>Largest Play Ground</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facere expedita minus sunt, obcaecati eveniet
                    voluptate.</p>
            </div>

            <div class="facilities-col">
                <img src="{{asset('frontend/picture/cafeteria.png')}}" alt="#">
                <h3>Tasty and Healthy Food</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facere expedita minus sunt, obcaecati eveniet
                    voluptate.</p>
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
