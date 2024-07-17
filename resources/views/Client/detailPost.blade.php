@extends('Client.layouts.master');
@section('title')
    {{ $inforPost[0]->title }}
@endsection
@section('content')
    <section class="single-post-content">
        <div class="container">
            <div class="row">
                <div class="col-md-9 post-content" data-aos="fade-up">

                    <!-- ======= Single Post Content ======= -->
                    <div class="single-post">
                        <div class="post-meta"><span class="date">{{ $inforPost[0]->category_name }}</span> <span
                                class="mx-1">&bullet;</span> <span>{{ $inforPost[0]->created_at->format('d-m-Y') }}</span>
                        </div>
                        <h1 class="mb-5">{{ $inforPost[0]->title }}</h1>
                        <p><span
                                class="firstcharacter">{{ Str::substr($inforPost[0]->short_description, 0, 1) }}</span>{{ Str::substr($inforPost[0]->short_description, 1) }}
                        </p>


                        <div class="container">
                            <img src="{{ asset('uploads/' . $inforPost[0]->image) }}" alt="" class=""
                                width="100%">
                        </div>
                        <p>
                            <?php
                                  $content = explode(' ', $inforPost[0]->content);
                                  $number = count($content);
                                  if(count($imagePost) == 0){
                                      $he = 1;
                                      $limit = (int) ($number / $he);
                                      $limit2 = (int) ($number / $he);
                                  }else{
                                      $limit = (int) ($number / count($imagePost));
                                      $limit2 = (int) ($number / count($imagePost));
                                  }
                                  $start = 0;
                                  // $number2 =  count($imagePost);
                                  $j = 0;
                                  $check =0;
                                  for ($i = $start; $i < $number; $i++) {
                                      echo $content[$i] . ' ';
                                      if ($i == $limit) {      
                                  ?>
                        <div class="container">
                            <img src="{{ asset('uploads/' . $imagePost[$j]->image_name) }}" alt="" class=""
                                width="100%">
                        </div>
                        <?php
                                          $j++;
                                          $start += $limit2;
                                          $limit += $limit2;  
                                      }
                                  }
                                  ?>
                        </p>


                    </div><!-- End Single Post Content -->

                    <!-- ======= Comments ======= -->
                    <div class="comments">
                        <h5 class="comment-title py-4">@php
                            $count = $postComments;
                            echo count($count) . ' Comment';
                        @endphp</h5>
                        <div class="comment  mb-4">
                            @foreach ($postComments as $item)
                                <div class="flex-grow-1 ms-2 ms-sm-3 mt-2">
                                    <div class="comment-meta d-flex align-items-baseline">
                                        <h6 class="me-2">{{ $item->name }}</h6>
                                        <span class="text-muted">{{ $item->created_at->format('d-m-Y') }}</span>
                                    </div>
                                    <div class="comment-body">
                                        {{ $item->content }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div><!-- End Comments -->

                    <!-- ======= Comments Form ======= -->
                    <div class="row justify-content-center mt-5">
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif
                        <div class="col-lg-12">
                            <h5 class="comment-title">Leave a Comment</h5>
                            <div class="row">
                                <form action="{{ url('detail-post-' . $inforPost[0]->slug) }}" method="post">
                                    @csrf
                                    <div class="col-lg-6 mb-3">
                                        <label for="comment-name">Name</label>
                                        <input type="text" class="form-control" id="comment-name"
                                            placeholder="Enter your name" name="name">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="comment-email">Email</label>
                                        <input type="text" class="form-control" id="comment-email"
                                            placeholder="Enter your email" name="email">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="comment-message">Message</label>

                                        <textarea class="form-control" id="comment-message" placeholder="Enter your name" cols="30" rows="10"
                                            name="content"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <input type="submit" class="btn btn-primary" value="Post comment">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- End Comments Form -->

                </div>
                <div class="col-md-3">
                    <!-- ======= Sidebar ======= -->
                    <div class="aside-block">

                        <ul class="nav nav-pills custom-tab-nav mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-popular-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-popular" type="button" role="tab"
                                    aria-controls="pills-popular" aria-selected="true">Relate</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-trending-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-trending" type="button" role="tab"
                                    aria-controls="pills-trending" aria-selected="false">Trending</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">

                            <!-- Popular -->
                            <div class="tab-pane fade show active" id="pills-popular" role="tabpanel"
                                aria-labelledby="pills-popular-tab">
                                @foreach ($postsLq as $item)
                                    <div class="post-entry-1 border-bottom">
                                        <div class="post-meta"><span class="date">{{ $item->category_name }}</span> <span
                                                class="mx-1">&bullet;</span>
                                            <span>{{ $item->created_at->format('d-m-Y') }}</span>
                                        </div>
                                        <h2 class="mb-2"><a
                                                href="{{ url('/detail-post-' . $item->slug) }}">{{ $item->title }}</a>
                                        </h2>
                                    </div>
                                @endforeach


                            </div> <!-- End Popular -->

                            <!-- Trending -->
                            <div class="tab-pane fade" id="pills-trending" role="tabpanel"
                                aria-labelledby="pills-trending-tab">
                                @foreach ($trending as $item)
                                    <div class="post-entry-1 border-bottom">
                                        <div class="post-meta"><span class="date">{{ $item->category_name }}</span>
                                            <span class="mx-1">&bullet;</span>
                                            <span>{{ $item->created_at->format('d-m-Y') }}</span>
                                        </div>
                                        <h2 class="mb-2"><a
                                                href="{{ url('/detail-post-' . $item->slug) }}">{{ $item->title }}</a>
                                        </h2>
                                    </div>
                                @endforeach
                            </div> <!-- End Trending -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End #main -->
@endsection
