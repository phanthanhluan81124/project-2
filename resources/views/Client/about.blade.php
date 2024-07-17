@extends('Client.layouts.master')
@section('title', 'About ZenBlog')
@section('content')
    <section>
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h1 class="page-title">About us</h1>
                </div>
            </div>

            <div class="row mb-12">
                <div class="col-5 mb-12 ">
                    <div class="post-entry-2 half mt-3">
                        <div class="" style="margin-bottom: 20px;">
                            <a href="#" class="me-4 thumbnail">
                                <img src="{{ asset('uploads/' . $about[0]->image) }}" alt="" class="img-fluid">
                            </a>
                        </div>
                        @foreach ($image as $item)
                            <div class="mt-1">
                                <a href="#" class="me-4 thumbnail">
                                    <img src="{{ asset('uploads/' . $item->image_name) }}" alt="" class="img-fluid">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-7 ps-md-5 mt-4 mt-md-0">
                    <div class="post-meta mt-4">About us</div>
                    <h2 class="mb-4 display-4">{{ $about[0]->title }}</h2>
                    @php
                        $content = explode(' ', $about[0]->content);
                        $number = count($content);
                        for ($i = 0; $i < $number; $i++) {
                            echo $content[$i] . ' ';
                        }
                    @endphp
                </div>
            </div>
        </div>
    </section>
@endsection
