@extends('Admin.layouts.master')
@section('title')
    List Category
@endsection
@section('content')

    <div class="card" style="height: 100px; padding: 10px">
        <h6>Search Category</h6>
        <form class="search-form d-flex align-items-center mt-1" method="GET" action="{{ URL::full() }}">
            @csrf
            <input type="text" name="search" placeholder="Search" title="Enter search keyword" class="form-control">
            <button type="submit" title="Search" class="btn btn-priamry"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Category_Name</th>
                <th scope="col">Category_Parent</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($categories as $item)
                <tr>
                    <th scope="row">{{ $item->id }} </th>
                    <td>{{ $item->category_name }}</td>
                    <td>
                        @foreach ($categories as $value)
                            @if ($value->id == $item->category_parent)
                                {{ $value->category_name }}
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('editcategory',$item->id) }}">
                            <button class="btn btn-warning">EDIT</button>
                        </a>
                        <a href="{{ route('deletecategory' , $item->id) }}"
                            onclick="return confirm('Do you wants delete item?')">
                            <button class="btn btn-danger">DELETE</button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (!isset($_GET['search']))
        <div class="text-start py-4">
            <div class="custom-pagination">
                @if (isset($_GET['page']) && $_GET['page'] > 1)
                    <a href="{{ url('ZenBlog-admin/listcategory' . '?page=' . $_GET['page'] - 1) }}" class="prev"><button
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
                    <a href='{{ url('ZenBlog-admin/listcategory' . '?page=' . $i) }}'><button
                            class="btn btn-secondary">{{ $i }}</button></a>
                @endif
                @if ($i + 1 <= $number)
                    <a href='{{ url('ZenBlog-admin/listcategory' . '?page=' . $i + 1) }}'><button
                            class="btn btn-dark">{{ $i + 1 }}</button></a>
                @endif
                @if ($i + 2 <= $number)
                    <a href='{{ url('ZenBlog-admin/listcategory' . '?page=' . $i + 1) }}'><button
                            class="btn btn-dark">{{ $i + 2 }}</button></a>
                @endif
                <?php
                    }}
                ?>
                @if ($_GET['page'] < $number)
                    <a href="{{ url('ZenBlog-admin/listcategory' . '?page=' . $_GET['page'] + 1) }}" class="next"><button
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

@endsection
