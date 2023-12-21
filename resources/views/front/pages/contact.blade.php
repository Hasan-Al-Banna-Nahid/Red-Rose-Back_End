@extends('front.layouts.app')
@section('title')
    Contact Us
@endsection
@section('content')
    <h1>Contact Us</h1>
    </section>
    <!-- -------contact us page------------------->
    <section class="location">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58452.23641293825!2d90.40709580510308!3d23.702236940582996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b9d832538007%3A0xf485cc9e416d26f4!2sBarnamala%20Adarsha%20High%20School%20and%20College!5e0!3m2!1sen!2sbd!4v1691564664643!5m2!1sen!2sbd"width="600"
            height="450" style="border:0;" allowfullscreen=""
            loading="lazy"referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
    <section class="contact-us">
        <div class="row">
            <div class="contact-col">
                <div>
                    <i class="fa fa-home"></i>
                    <span>
                        <h5>Lorem ipsum dolor sit amet.</h5>
                        <p>Sonir AKhra,Dhaka,Bangladesh</p>
                    </span>
                </div>
                <div>
                    <i class="fa fa-phone"></i>
                    <span>
                        <h5>+880............</h5>
                        <p>saturday to thursday </p>
                    </span>
                </div>
                <div>
                    <i class="fa fa-envelope-o"></i>
                    <span>
                        <h5>redrose.helpdesk21@gmail.com</h5>
                        <p>Email us your query.</p>
                    </span>
                </div>
            </div>
            <div class="contact-col">
                <form action="#">
                    <input type="text" placeholder="Enter your Name" required>
                    <input type="email" placeholder="Enter email address" required>
                    <input type="text" placeholder="Enter your subject" required>
                    <textarea rows="8" placeholder="Message" required></textarea>
                    <button type="submit" class="hero-btn red-btn">Send Message</button>
                </form>
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
