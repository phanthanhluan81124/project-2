@extends('Client.layouts.master')
@section('name', 'category')
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-9" data-aos="fade-up">
                    <h3 class="category-title">Category:
                        @foreach ($categories as $item)
                            @if ($item->id == $id)
                                {{ $item->category_name }}
                                @foreach ($categories as $key)
                                    @if ($item->category_parent == $key->id)
                                        | {{ $key->category_name }}
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </h3>
                    @foreach ($postCategory as $item)
                        <div class="d-md-flex post-entry-2 half">
                            <a href="{{route('detailPost',$item->slug)}}" class="me-4 thumbnail">
                                <img src="{{ asset('uploads/' . $item->image) }}" alt="" class="img-fluid"
                                    width="500">
                            </a>
                            <div>
                                <div class="post-meta">
                                    <span>{{ $item->created_at->format('d-m-Y') }}</span>
                                </div>
                                <h3><a href="{{route('detailPost',$item->slug)}}">{{ $item->title }}</a></h3>
                                <p>{{ $item->short_description }}</p>
                            </div>
                        </div>
                    @endforeach


                    <div class="text-start py-4">
                        <div class="custom-pagination">
                            @if (isset($_GET['page']) && $_GET['page'] > 1)
                                <a href="{{ url('category-' . $id . '?page=' . $_GET['page'] - 1) }}"
                                    class="prev">Prevous</a>
                            @endif
                            <?php
                                    for ($i=0; $i <= $number ; $i++) { 
                                        if(empty($_GET['page'])){
                                                    $_GET['page'] = 1;
                                        }
                                    if($i == $_GET['page']){
                                ?>
                            <a href='{{ url('category-' . $id . '?page=' . $i) }}' class="active">{{ $i }}</a>
                            @if ($i + 1 <= $number)
                                <a href='{{ url('category-' . $id . '?page=' . $i + 1) }}'>{{ $i + 1 }}</a>
                            @endif
                            @if ($i + 2 <= $number)
                                <a href='{{ url('category-' . $id . '?page=' . $i + 1) }}'>{{ $i + 1 }}</a>
                            @endif
                            <?php
                                    }}
                                ?>
                            @if ($_GET['page'] < $number)
                                <a href="{{ url('category-' . $id . '?page=' . $_GET['page'] + 1) }}" class="next">Next</a>
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
