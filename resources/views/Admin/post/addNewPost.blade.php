@extends('Admin.layouts.master')
@section('avatar')
    Add New Post
@endsection
@section('content')
    <div class="pageavatar">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                <li class="breadcrumb-item">Add New Category</li>
            </ol>
        </nav>
    </div><!-- End Page avatar -->
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-avatar"></h5>
                        <!-- Horizontal Form -->
                        <form action="{{ route('postPost') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <label for="inputName5" class="form-label">Title</label>
                                <input type="text" class="form-control" id="inputName5" name="title"
                                    value="{{ old('title') }}">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail5" class="form-label">Category</label>
                                <select name="category_parent" id="" class="form-control">
                                    <option value="" selected>None</option>
                                    @foreach ($categories as $item)
                                        @if ($item->category_parent == null)
                                            <option value="{{ $item->id }}"
                                                @if (old('category_parent') == $item->id) selected @endif>{{ $item->category_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('category_parent')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword5" class="form-label">Category_son</label>
                                <select name="category_son" id="" class="form-control">
                                    <option value="" selected>None</option>
                                    @foreach ($categories as $item)
                                        @if ($item->category_parent != null)
                                            <option value="{{ $item->id }}"
                                                @if (old('category_son') == $item->id) selected @endif>{{ $item->category_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('category_son')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="col-12">
                                        <label for="inputAddress2" class="form-label">Avatar</label>
                                        <input type="file" class="form-control" id="inputAddress2" name="avatar">
                                    </div>
                                    @error('avatar')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="col-12 mt-3">
                                        <label for="inputAddress2" class="form-label">Image_Post</label>
                                        <input type="file" class="form-control" id="" name="image[]" multiple
                                            accept="image/*">
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="col-12  ">
                                        <label for="inputAddress5" class="form-label">Short_description</label>
                                        <textarea name="short_description" id="" cols="20" rows="4" class="form-control">{{ old('short_description') }}</textarea>
                                    </div>
                                    @error('short_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="inputAddress2" class="form-label">Content</label>
                                <textarea name="content" id="" class="form-control" id="content">{{ old('content') }}</textarea>
                                @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
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
