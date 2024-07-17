@extends('Admin.layouts.master')
@section('title')
    Add New Category
@endsection
@section('content')
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item">Add New Category</li>
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
                        <form action="{{ route('postcategory') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Name Category:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="category_name" name="category_name" value="{{old('category_name')}}">
                                    <span id="error" class="text-danger"></span>
                                    @error('category_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Parent Category:</label>
                                <div class="col-sm-10">
                                    <select name="category_parent" id="" class="form-control">
                                        <option value="" selected>None</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}" @if (old('category_parent') == $item->id)
                                                selected
                                            @endif> {{ $item->category_name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form><!-- End Horizontal Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
