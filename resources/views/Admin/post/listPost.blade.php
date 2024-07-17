@extends('Admin.layouts.master')
@section('title')
    List Category
@endsection
@section('content')
    <div class="card" style="height: 150px; padding: 10px">
        <div class="row">
            <div class="col-md-8" style="border-right: solid 1px black ">
                <h6>Search Post</h6>
                <form class="search-form d-flex align-items-center mt-1" method="GET" action="{{ URL::full() }}">
                    @csrf
                    <input type="text" name="search" placeholder="Title Post ...." title="Enter search keyword"
                        class="form-control">
                    <button type="submit" title="Search" class="btn btn-dark"><i class="bi bi-search"></i></button>
                </form>
            </div>
            <div class="col-md-4">
                <h6>Categories</h6>
                <select name="category" id="category" class="form-control">
                    <option value="" selected>-None-</option>
                    @foreach ($categories as $item)
                        @if (isset($_GET['search']))
                            <option value="{{ '&category=' . $item->id }}"
                                @if (isset($_GET['category']) && $item->id == $_GET['category']) selected @endif>{{ $item->category_name }}</option>
                        @else
                            <option value="{{ '?category=' . $item->id }}"
                                @if (isset($_GET['category']) && $item->id == $_GET['category']) selected @endif>{{ $item->category_name }}</option>
                        @endif
                    @endforeach

                </select>
            </div>
        </div>

    </div>
    @if (count($posts) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">View</th>
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

                            @foreach ($categories as $value)
                                @if ($value->id == $item->cate_parent_id)
                                    <span class="badge text-bg-dark">
                                        {{ $value->category_name }}
                                    </span>
                                @endif

                                @if ($item->cate_parent_id == null)
                                @endif
                            @endforeach
                            <br>
                            @foreach ($categories as $value)
                                @if ($value->id == $item->cate_son_id)
                                    <span class="badge text-bg-dark">
                                        {{ $value->category_name }}
                                    </span>
                                @endif
                                @if ($item->cate_son_id == null)
                                @endif
                            @endforeach

                        </td>
                        <td class="text-center">{{ $item->view }}</td>
                        <td>
                            <a href="{{ route('editPost' , [$item->slug, $item->id]) }}">
                                <button class="btn btn-warning">EDIT</button>
                            </a>
                            <a href="{{ route('deletePost' , [$item->slug, $item->id]) }}"
                                onclick="return confirm('Do you wants delete item?')">
                                <button class="btn btn-danger">DELETE</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h4 class="text-center" style="color:rgb(162, 158, 158);">There are no articles you searched for</h4>
    @endif
    @if (!isset($_GET['search']) && !isset($_GET['category']))
        <div class="text-start py-4">
            <div class="custom-pagination">
                @if (isset($_GET['page']) && $_GET['page'] > 1)
                    <a href="{{ url('ZenBlog-admin/listPost' . '?page=' . $_GET['page'] - 1) }}" class="prev"><button
                            class="btn btn-dark">
                            << Prevous </button></a>
                @endif
                <?php
                for ($i=0; $i <= $number ; $i++) { 
                    if(empty($_GET['page'])){
                                $_GET['page'] = 1;
                    }
                if($i == $_GET['page']){
        ?>
                @if ($number > 1)
                    <a href='{{ url('ZenBlog-admin/listPost' . '?page=' . $i) }}'><button
                            class="btn btn-secondary">{{ $i }}</button></a>
                @endif
                @if ($i + 1 <= $number)
                    <a href='{{ url('ZenBlog-admin/listPost' . '?page=' . $i + 1) }}'><button
                            class="btn btn-dark">{{ $i + 1 }}</button></a>
                @endif
                @if ($i + 2 <= $number)
                    <a href='{{ url('ZenBlog-admin/listPost' . '?page=' . $i + 1) }}'><button
                            class="btn btn-dark">{{ $i + 2 }}</button></a>
                @endif
                <?php
                }}
            ?>
                @if ($_GET['page'] < $number)
                    <a href="{{ url('ZenBlog-admin/listPost' . '?page=' . $_GET['page'] + 1) }}" class="next"><button
                            class="btn btn-dark">Next >></button></a>
                @endif

            </div>
        </div>
    @else
        <div class="text-start py-4">
            <div class="custom-pagination">
                @if (isset($_GET['page']) && $_GET['page'] > 1)
                    <a href="{{ url(URL::full() . '&page=' . $_GET['page'] - 1) }}" class="prev"><button
                            class="btn btn-dark">
                            << Prevous </button></a>
                @endif
                <?php
            for ($i=0; $i <= $number ; $i++) { 
                if(empty($_GET['page'])){
                            $_GET['page'] = 1;
                }
            if($i == $_GET['page']){
    ?>
                @if ($number > 1)
                    <a href='{{ url(URL::full() . '&page=' . $i) }}' class="active"><button
                            class="btn btn-secondary">{{ $i }}</button></a>
                @endif
                @if ($i + 1 <= $number)
                    <a href='{{ url(URL::full() . '&page=' . $i + 1) }}'><button
                            class="btn btn-dark">{{ $i + 1 }}</button></a>
                @endif
                @if ($i + 2 <= $number)
                    <a href='{{ url(URL::full() . '&page=' . $i + 1) }}'><button
                            class="btn btn-dark">{{ $i + 2 }}</button></a>
                @endif
                <?php
            }}
        ?>
                @if ($_GET['page'] < $number)
                    <a href="{{ url(URL::full() . '&page=' . $_GET['page'] + 1) }}" class="next"><button
                            class="btn btn-dark">Next >></button></a>
                @endif

            </div>
        </div>
    @endif
    @if (isset($_GET['search']) && !empty($_GET['search']))
        <p id="url" hidden>{{ url('ZenBlog-admin/listPost?_token=' . $_GET['_token']) . '&search=' . $_GET['search'] }}</p>
    @else
        <p id="url" hidden>{{ url('ZenBlog-admin/listPost') }}</p>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        const select = document.getElementById('price');
        var URL = document.getElementById('url').innerText;
        console.log(window.location.href);
        $(document).ready(function() {
            var active = location.search;
            // console.log(active);
            $('#category option[value="' + active + '"]').attr('selected', 'selected');
        });
        $('#category').change(function() {
            const selectedValue = $(this).find(':selected').val();
            let url = URL + selectedValue;
            window.location.replace(url);
            console.log(url); // Hiển thị giá trị được chọn
        });
    </script>
@endsection
