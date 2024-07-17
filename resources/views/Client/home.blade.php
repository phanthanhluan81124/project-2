@extends('Client.layouts.master')
@section('title')
    Trang Chủ
@endsection
@section('content')
    <section id="hero-slider" class="hero-slider">
        <div class="container-md" data-aos="fade-in">
            <div class="row">
                <div class="col-12">
                    <div class="swiper sliderFeaturedPosts">
                        <div class="swiper-wrapper">
                            @foreach ($banner as $item)
                                <div class="swiper-slide">
                                    <a href="{{ url('detail-post-' . $item->slug) }}" class="img-bg d-flex align-items-end"
                                        style="background-image: url('{{ asset('uploads/' . $item->image) }}')">
                                        <div class="img-bg-inner">
                                            <h2>{{ $item->title }}</h2>
                                            <p>{{ $item->short_description }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="custom-swiper-button-next">
                            <span class="bi-chevron-right"></span>
                        </div>
                        <div class="custom-swiper-button-prev">
                            <span class="bi-chevron-left"></span>
                        </div>

                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Hero Slider Section -->
    <!-- ======= Post Grid Section ======= -->
    <section id="posts" class="posts">
        <div class="container" data-aos="fade-up">
            <div class="row g-5">
                <div class="col-lg-12">
                    <div class="row g-5">
                        <div class="col-lg-4 border-start custom-border">
                            @foreach ($posts1 as $item)
                                <div class="post-entry-1">
                                    <a href="{{ url('detail-post-' . $item->slug) }}">
                                        <img src="{{ asset('uploads/' . $item->image) }}" alt=""
                                            class="img-fluid"></a>
                                    <div class="post-meta"><span class="date">{{ $item->category_name }}</span> <span
                                            class="mx-1">&bullet;</span>
                                        <span>{{ $item->created_at->format('d-m-Y') }}</span>
                                    </div>
                                    <h2><a href="{{ url('detail-post-' . $item->slug) }}">{{ $item->title }}</a></h2>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-4 border-start custom-border">
                            @foreach ($posts2 as $item)
                                <div class="post-entry-1">
                                    <a href="{{ url('detail-post-' . $item->slug) }}"><img
                                            src="{{ asset('uploads/' . $item->image) }}" alt=""
                                            class="img-fluid"></a>
                                    <div class="post-meta"><span class="date">{{ $item->category_name }}</span> <span
                                            class="mx-1">&bullet;</span>
                                        <span>>{{ $item->created_at->format('d-m-Y') }}</span>
                                    </div>
                                    <h2><a href="{{ url('detail-post-' . $item->slug) }}">{{ $item->title }}</a>
                                    </h2>
                                </div>
                            @endforeach
                        </div>

                        <!-- Trending Section -->
                        <div class="col-lg-4">

                            <div class="trending">
                                <h3>Trending</h3>
                                <ul class="trending-post">
                                    @foreach ($trending as $item)
                                        <li>
                                            <a href="{{ url('detail-post-' . $item->slug) }}">
                                                <h3>{{ $item->title }}</h3>
                                                <span class="author">{{ $item->created_at->format('d-m-Y') }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div> <!-- End Trending Section -->
                    </div>
                </div>

            </div> <!-- End .row -->
        </div>
    </section> <!-- End Post Grid Section -->
    <!-- ======= Culture Category Section ======= -->
    @foreach ($categories as $item)
        @if ($item->category_parent == null)
            <section class="category-section">
                <div class="container" data-aos="fade-up">
                    <div class="section-header d-flex justify-content-between align-items-center mb-5">
                        <h2>{{ $item->category_name }}</h2>
                        <div><a href="{{ route('Category', $item->id) }}" class="more">See All</a></div>
                    </div>
                    <div class="row">
                        <?php
                            $i = 0;
                            foreach ($posts as  $value) {
                            if($value->cate_parent_id == $item->id && $i<6){
                        ?>
                        <div class="col-lg-6">
                            <div class="d-lg-flex post-entry-2">
                                <a href="{{ url('detail-post-' . $value->slug) }}"
                                    class="me-4 thumbnail mb-4 mb-lg-0 d-inline-block">
                                    <img src="{{ asset('uploads/' . $value->image) }}" alt="" class="img-fluid"
                                        width="400" height="250">
                                </a>
                                <div>
                                    <div class="post-meta">
                                        <span>{{ $value->created_at->format('d-m-Y') }}</span>
                                    </div>
                                    <h3><a href="{{ url('detail-post-' . $value->slug) }}">{{ $value->title }}</a></h3>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                        }
                        }
                        ?>
                    </div>
                </div>
            </section>
        @endif
    @endforeach
@endsection
