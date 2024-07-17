<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('theme/Admin/assets/img/logo.png') }}" alt="">
                <h1>ZenBlog</h1>
            </a>
        </div>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="dropdown"><a><span>Categories</span> <i
                            class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul>

                        @foreach ($categories as $value)
                            @if ($value->category_parent == null)
                                <li class="dropdown"><a
                                        href="{{ url('category-' . $value->id) }}"><span>{{ $value->category_name }}</span>
                                        <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                                    <ul>
                                        @foreach ($categories as $item)
                                            @if ($item->category_parent == $value->id)
                                                <li><a
                                                        href='{{ url('category-' . $item->id) }}'>{{ $item->category_name }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach

                    </ul>
                </li>

                <li><a href="{{route('about')}}">About</a></li>
                <li><a href="{{route('contact')}}">Contact</a></li>
            </ul>
        </nav><!-- .navbar -->

        <div class="position-relative d-flex">
            <div class="dropdown">
                <a class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-fill"></i>
                </a>

                <ul class="dropdown-menu">
                    @if (Auth::check())
                        @if (Auth::user()->role == 1)
                            <li><a class="dropdown-item" href="{{ route('admin.home') }}">Admin</a></li>
                        @endif
                        <li><a class="dropdown-item" href="{{ route('infor') }}">Infor Account</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    @else
                        <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                    @endif


                </ul>
            </div>


            <a href="#" class="mx-2 js-search-open mt-2"><span class="bi-search"></span></a>
            <i class="bi bi-list mobile-nav-toggle"></i>

            <!-- ======= Search Form ======= -->
            <div class="search-form-wrap js-search-form-wrap">
                <form action="{{ route('clinet.search') }}" class="search-form" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-primary"><span class="icon bi-search"></span></button>
                    <input type="text" placeholder="Search" class="form-control" name="search">
                    <button class="btn js-search-close"><span class="bi-x"></span></button>
                </form>
            </div><!-- End Search Form -->

        </div>

    </div>

</header>
