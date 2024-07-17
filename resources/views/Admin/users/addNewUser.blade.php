@extends('Admin.layouts.master')
@section('title')
    Add New User
@endsection
@section('content')
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                <li class="breadcrumb-item">Add New User</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            <!-- Multi Columns Form -->
            <form class="row g-3 mt-2" action="{{ route('postUser') }}" method="POST">
                @csrf
                <div class="col-md-12">
                    <label for="inputName5" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="inputName5" name="name" value="{{old('name')}}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="inputEmail5" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmail5" name="email" value="{{old('email')}}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="inputPassword5" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword5" name="password" value="{{old('password')}}">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="inputAddress5" class="form-label">Role</label>
                    <select name="role" id="" class="form-control">
                        <option value="1"  @if (old('role') == 1) selected  @endif>Admin</option>
                        <option value="2" @if (old('role') == 2) selected  @endif>Customer</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form><!-- End Multi Columns Form -->

        </div>
    </div>
@endsection
