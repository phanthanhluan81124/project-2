@extends('Client.layouts.master')
@section('title', 'inforAccount')
@section('content')
    <div class="container" style="padding: 20px">
        <h1 class="text-center">Thông tin tài khoản</h1>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form action="" method="post">
            @csrf
            <div class="row">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" value="{{ $infor[0]->email }}"
                        disabled>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="name"
                        value="{{ $infor[0]->name }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row mt-2">
                <h5>Change Password</h5>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleFormControlInput1" name="oldPassword"
                        value="{{ old('oldPassword') }}">
                    @error('oldPassword')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="exampleFormControlInput1" name="password"
                        value="{{ old('oldPassword') }}">
                    @error('passsword')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="exampleFormControlInput1" name="confirmPassword">
                    @error('confirmPassword')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary mt-4" type="submit" style="width: 100%">Update</button>
                </div>
            </div>
        </form>
    </div>
    {{-- <script>
        const btn = document.getElementById('btn')
        btn.addEventListener("click", function() {
            document.getElementById('change').style.display = 'none';
            document.getElementById('resetpass').style.display = 'inline';
        })
    </script> --}}
@endsection
