@extends('Client.layouts.master')
@section('title', 'About ZenBlog')
@section('content')

    <section id="contact" class="contact mb-5">
        <div class="container" data-aos="fade-up">
            {{-- {{ $subject }}
            {{ $mailMesage }} --}}
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h1 class="page-title">Contact us</h1>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="row gy-4">

                <div class="col-md-4">
                    <div class="info-item">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Address</h3>
                        <address>A108 Adam Street, NY 535022, USA</address>
                    </div>
                </div><!-- End Info Item -->

                <div class="col-md-4">
                    <div class="info-item info-item-borders">
                        <i class="bi bi-phone"></i>
                        <h3>Phone Number</h3>
                        <p><a href="tel:+155895548855">+1 5589 55488 55</a></p>
                    </div>
                </div><!-- End Info Item -->

                <div class="col-md-4">
                    <div class="info-item">
                        <i class="bi bi-envelope"></i>
                        <h3>Email</h3>
                        <p><a href="mailto:info@example.com">info@example.com</a></p>
                    </div>
                </div><!-- End Info Item -->

            </div>

            <div class="form mt-5">
                <form action="{{ route('send.email') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12 mt-3">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name"
                                value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 mt-3">
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Your Email" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 mt-3">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject"
                                value="{{ old('subject') }}">
                            @error('subject')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <textarea class="form-control" name="message" rows="5" placeholder="Message">{{ old('message') }}</textarea>
                        @error('message')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div> --}}
                    <div class="text-center mt-2"><button type="submit" class="btn btn-dark">Send Message</button></div>
                </form>
            </div><!-- End Contact Form -->

        </div>
    </section>
@endsection
