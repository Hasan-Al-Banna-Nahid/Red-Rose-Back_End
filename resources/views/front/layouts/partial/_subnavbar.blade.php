<section class="sub-header">
    <nav>
        <a href="/"><img src="{{ asset('frontend/picture/logo.png') }}" alt="#"></a>
        <div class="nav-links" id="navLinks">
            <i class="fa fa-times" onclick="hideMenu()"></i>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="{{ route('front.about') }}">About</a></li>
                <li><a href="{{ route('front.course') }}">Course</a></li>
                <li><a href="{{ route('front.blog') }}">Blog</a></li>
                <li><a href="{{ route('front.contact') }}">Contact</a></li>
                <li><a href="">Services</a></li>
            </ul>
        </div>
        <i class="fa fa-briefcase" onclick="showMenu()"></i>
    </nav>
</section>
