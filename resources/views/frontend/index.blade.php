@extends('layouts.frontend')
@section('title')
    Home
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('images/1.png') }}" class="d-block w-100" alt="#">
                                </div>
                                <div class="carousel-item active">
                                    <img src="{{ asset('images/1.png') }}" class="d-block w-100" alt="#">
                                </div>
                                <div class="carousel-item active">
                                    <img src="{{ asset('images/1.png') }}" class="d-block w-100" alt="#">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                        <h2>FAQ Section</h2>
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <div class="iq-accordion career-style faq-style  ">
                                    <div class="iq-card iq-accordion-block accordion-active">
                                        <div class="active-faq clearfix">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12"><a class="accordion-title"><span> It is a long
                                                                established fact that a reader will be? </span> </a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-details">
                                            <p class="mb-0">Many desktop publishing packages and web page editors now use
                                                Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                                uncover many web sites still in their infancy. </p>
                                        </div>
                                    </div>
                                    <div class="iq-card iq-accordion-block ">
                                        <div class="active-faq clearfix">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12"><a class="accordion-title"><span> Distracted by
                                                                the readable content of a page whent? </span> </a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-details">
                                            <p class="mb-0">It has survived not only five centuries, but also the leap
                                                into electronic typesetting. Neque porro quisquam est, qui dolorem ipsum
                                                quia dolor sit amet, consectetur.</p>
                                        </div>
                                    </div>
                                    <div class="iq-card iq-accordion-block ">
                                        <div class="active-faq clearfix">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12"><a class="accordion-title"><span>What is user
                                                                interface kit? </span> </a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-details">
                                            <p class="mb-0">It has survived not only five centuries, but also the leap
                                                into electronic typesetting. Neque porro quisquam est, qui dolorem ipsum
                                                quia dolor sit amet, consectetur.</p>
                                        </div>
                                    </div>
                                    <div class="iq-card iq-accordion-block ">
                                        <div class="active-faq clearfix">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12"><a class="accordion-title"><span> The readable
                                                                content of a page when looking at its layout? </span> </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-details">
                                            <p class="mb-0">It has survived not only five centuries, but also the leap
                                                into electronic typesetting. Neque porro quisquam est, qui dolorem ipsum
                                                quia dolor sit amet, consectetur.</p>
                                        </div>
                                    </div>
                                    <div class="iq-card iq-accordion-block ">
                                        <div class="active-faq clearfix">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12"><a class="accordion-title"><span> The readable
                                                                content of a page when looking at its layout? </span> </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-details">
                                            <p class="mb-0">It has survived not only five centuries, but also the leap
                                                into electronic typesetting. Neque porro quisquam est, qui dolorem ipsum
                                                quia dolor sit amet, consectetur.</p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="iq-accordion career-style faq-style  ">
                                    <div class="iq-card iq-accordion-block ">
                                        <div class="active-faq clearfix">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12"><a class="accordion-title"><span> What is user
                                                                interface kit? </span> </a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-details">
                                            <p class="mb-0">It has survived not only five centuries, but also the leap
                                                into electronic typesetting. Neque porro quisquam est, qui dolorem ipsum
                                                quia dolor sit amet, consectetur.</p>
                                        </div>
                                    </div>
                                    <div class="iq-card iq-accordion-block ">
                                        <div class="active-faq clearfix">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12"><a class="accordion-title"><span> What is user
                                                                interface kit? </span> </a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-details">
                                            <p class="mb-0">It has survived not only five centuries, but also the leap
                                                into electronic typesetting. Neque porro quisquam est, qui dolorem ipsum
                                                quia dolor sit amet, consectetur.</p>
                                        </div>
                                    </div>
                                    <div class="iq-card iq-accordion-block ">
                                        <div class="active-faq clearfix">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12"><a class="accordion-title"><span> What is user
                                                                interface kit? </span> </a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-details">
                                            <p class="mb-0">It has survived not only five centuries, but also the leap
                                                into electronic typesetting. Neque porro quisquam est, qui dolorem ipsum
                                                quia dolor sit amet, consectetur.</p>
                                        </div>
                                    </div>
                                    <div class="iq-card iq-accordion-block ">
                                        <div class="active-faq clearfix">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12"><a class="accordion-title"><span> What is user
                                                                interface kit? </span> </a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-details">
                                            <p class="mb-0">It has survived not only five centuries, but also the leap
                                                into electronic typesetting. Neque porro quisquam est, qui dolorem ipsum
                                                quia dolor sit amet, consectetur.</p>
                                        </div>
                                    </div>
                                    <div class="iq-card iq-accordion-block ">
                                        <div class="active-faq clearfix">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12"><a class="accordion-title"><span> What is user
                                                                interface kit? </span> </a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-details">
                                            <p class="mb-0">It has survived not only five centuries, but also the leap
                                                into electronic typesetting. Neque porro quisquam est, qui dolorem ipsum
                                                quia dolor sit amet, consectetur.</p>
                                        </div>
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
