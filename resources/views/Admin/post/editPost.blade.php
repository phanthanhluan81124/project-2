@extends('Admin.layouts.master')
@section('title')
    Edit Post
@endsection
@section('content')
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                <li class="breadcrumb-item">Edit Post</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <!-- Horizontal Form -->
                        <form action="{{ route('updatePost' , [$post->slug ,$post->id]) }}" method="POST"
                            class="row g-3" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label for="inputName5" class="form-label">Title</label>
                                <input type="text" class="form-control" id="inputName5" name="title"
                                    value="{{ $post->title }}">
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail5" class="form-label">Category_parent</label>
                                <select name="category_parent" id="" class="form-control">
                                    <option value="" selected>None</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}"
                                            @if (isset($post->cate_parent_id) && $post->cate_parent_id != null && $item->id == $post->cate_parent_id) selected @endif>
                                            {{ $item->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword5" class="form-label">Category_son</label>
                                <select name="category_son" id="" class="form-control">
                                    <option value="" selected>None</option>
                                    @foreach ($categories as $item)
                                        @if ($item->category_parent != null)
                                            <option value="{{ $item->id }}"
                                                @if (isset($post->cate_son_id) && $post->cate_son_id != null && $item->id == $post->cate_son_id) selected @endif>
                                                {{ $item->category_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="col-12">
                                        <label for="inputAddress2" class="form-label">Avatar</label> <br>
                                        <img src="{{ asset('uploads/' . $post->image) }}" alt="" width="150">
                                        <input type="file" class="form-control mt-1" id="inputAddress2" name="avatar">
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label for="inputAddress2" class="form-label">Image_Post</label>
                                        <div class="row">
                                            @foreach ($image_post as $item)
                                                <div class="col-md-5 mt-1">
                                                    <img src="{{ asset('uploads/' . $item->image_name) }}" alt=""
                                                        width="150" height="100">
                                                </div>
                                            @endforeach
                                        </div>
                                        <input type="file" class="form-control mt-1" id="" name="image[]"
                                            multiple accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-12  ">
                                        <label for="inputAddress5" class="form-label">Short_description</label>
                                        <textarea name="short_description" id="" cols="20" rows="4" class="form-control">{{ $post->short_description }}</textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12">
                                <label for="inputAddress2" class="form-label">Content</label>
                                <textarea name="content" id="" class="form-control" id="content">{{ $post->content }}</textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
