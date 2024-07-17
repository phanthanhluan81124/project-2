@extends('Admin.layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Posts</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-postcard"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ count($allPost) }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Accounts</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ count($allUser) }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->
                    <!-- Top Selling -->
                    <div class="col-12">
                        <div class="card top-selling overflow-auto">
                            <div class="card-body pb-0">
                                <h5 class="card-title">Top View <span></span></h5>

                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Preview</th>
                                            <th scope="col">Post</th>
                                            <th scope="col">View</th>
                                            <th scope="col">Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topView as $item)
                                            <tr>
                                                <th scope="row">
                                                    <a href="#">
                                                        <img src="{{ asset('uploads/' . $item->image) }}"alt="">
                                                    </a>
                                                </th>
                                                <td>
                                                    <a href="#" class="text-primary fw-bold">{{ $item->title }}</a>
                                                </td>
                                                <td class="text-center" style="font-weight: 800">{{ $item->view }}</td>
                                                <td>
                                                    <span class="badge text-bg-dark">
                                                        @foreach ($allCategory as $value)
                                                            @if ($value->id == $item->cate_parent_id)
                                                                {{ $value->category_name }}
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                    <br>
                                                    <span class="badge text-bg-dark">
                                                        @foreach ($allCategory as $value)
                                                            @if ($value->id == $item->cate_son_id)
                                                                {{ $value->category_name }}
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Top Selling -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">
                <!-- Website Traffic -->
                {{-- <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">Website Traffic <span>| Today</span></h5>

              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      top: '5%',
                      left: 'center'
                    },
                    series: [{
                      name: 'Access From',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: false,
                      label: {
                        show: false,
                        position: 'center'
                      },
                      emphasis: {
                        label: {
                          show: true,
                          fontSize: '18',
                          fontWeight: 'bold'
                        }
                      },
                      labelLine: {
                        show: false
                      },
                      data: [{
                          value: 1048,
                          name: 'Search Engine'
                        },
                        {
                          value: 735,
                          name: 'Direct'
                        },
                        {
                          value: 580,
                          name: 'Email'
                        },
                        {
                          value: 484,
                          name: 'Union Ads'
                        },
                        {
                          value: 300,
                          name: 'Video Ads'
                        }
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div><!-- End Website Traffic --> --}}

                <!-- News & Updates Traffic -->
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="card-title">News Today</h5>
                        <div class="news">
                            @if (count($posts) == 0)
                                <span class="card-title" style="color: rgb(140, 138, 138); font-size:14px;">No New Post
                                    Today</span>
                            @else
                                @foreach ($posts as $item)
                                    <div class="post-item clearfix" style="margin-bottom:10px">
                                        <img src="{{ asset('uploads/' . $item->image) }}" alt="">
                                        <h4><a href="#">{{ $item->title }}</a></h4>
                                    </div>
                                @endforeach
                            @endif
                        </div><!-- End sidebar recent posts-->

                    </div>
                </div><!-- End News & Updates -->

            </div><!-- End Right side columns -->

        </div>
    </section>
    {{-- <div class="row" style="width: 100%;">
        <div class="col-md-7">
            <div class="alert alert-primary " role="alert">
                <div class="col-md-4">
                    <h3>Posts</h3>
                </div>
                <div class="col-md-8 text-end mt-1">
                    <h3> {{ count($allPost) }}</h3>
                </div>
            </div>
            <div class="alert alert-secondary" role="alert">
                <div class="col-md-4">
                    <h3>Accounts</h3>
                </div>
                <div class="col-md-8 text-end mt-1">
                    <h3> {{ count($allUser) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="canvas" style="width:80%; height:410px;border-radius:10px;margin-left:30px;"><canvas
                    id="myChart"></canvas></div>
        </div>
    </div>
    <div class="row" style="margin-top: -90px; margin-bottom:50px">
        <h3 class="text-center">New Article Today</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($posts as $item)
                    <tr>
                        <th scope="row" class="text-center">{{ $item->id }} </th>
                        <td><img src="{{ asset('uploads/' . $item->image) }}" alt="" width="100"></td>
                        <td>{{ $item->title }}</td>
                        <td class="text-center">
                            <span class="badge text-bg-dark">
                                @foreach ($allCategory as $value)
                                    @if ($value->id == $item->cate_parent_id)
                                        {{ $value->category_name }}
                                    @endif
                                @endforeach
                            </span>
                            <br>
                            <span class="badge text-bg-dark">
                                @foreach ($allCategory as $value)
                                    @if ($value->id == $item->cate_son_id)
                                        {{ $value->category_name }}
                                    @endif
                                @endforeach
                            </span>
                        </td>
                        <td>
                            <a href="{{ url('/admin-editPost-' . $item->slug . '=' . $item->id) }}">
                                Xem thêm
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div> --}}


    <script>
        const next = document.getElementById('next');
        setInterval(() => {
            next.click();
        }, 2000);
    </script>
    <script>
        const carousel = new bootstrap.Carousel('#myCarousel');
    </script>
@endsection
