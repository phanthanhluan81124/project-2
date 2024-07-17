@extends('Client.layouts.master')
@section('title','Search')
@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-9" data-aos="fade-up">
                @foreach ($searchPost as $item)
                    <div class="d-md-flex post-entry-2 half">
                        <a href="single-post.html" class="me-4 thumbnail">
                            <img src="{{ asset('uploads/' . $item->image) }}" alt="" class="img-fluid"
                                width="500">
                        </a>
                        <div>
                            <div class="post-meta">
                                <span>{{ $item->created_at->format('d-m-Y') }}</span>
                            </div>
                            <h3><a href="single-post.html">{{ $item->title }}</a></h3>
                            <p>{{ $item->short_description }}</p>
                        </div>
                    </div>
                @endforeach
                <div class="text-start py-4">
                    <div class="custom-pagination">
                        @if (isset($_GET['page']) && $_GET['page'] > 1)
                            <a href="{{ url(URL::full() . '&page=' . $_GET['page'] - 1) }}"
                                class="prev">Prevous</a>
                        @endif
                        <?php
                                for ($i=0; $i <= $number ; $i++) { 
                                    if(empty($_GET['page'])){
                                                $_GET['page'] = 1;
                                    }
                                if($i == $_GET['page']){
                        ?>
                        <a href='{{ url(URL::full() . '&page=' . $i) }}' class="active">{{ $i }}</a>
                        @if ($i + 1 <= $number)
                            <a href='{{ url(URL::full() . '&page=' . $i + 1) }}'>{{ $i + 1 }}</a>
                        @endif
                        @if ($i + 2 <= $number)
                            <a href='{{ url(URL::full() . '&page=' . $i + 1) }}'>{{ $i + 1 }}</a>
                        @endif
                        <?php
                                }}
                            ?>
                        @if ($_GET['page'] < $number)
                            <a href="{{ url(URL::full() . '&page=' . $_GET['page'] + 1) }}" class="next">Next</a>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- ======= Sidebar ======= -->
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
            </div>
        </div>
    </div>
</section>
@endsection