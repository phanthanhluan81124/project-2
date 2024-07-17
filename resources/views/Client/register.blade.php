@extends('Client.layouts.master')
@section('title')
@section('content')
    <div class="container" style="margin:8%;">
        <h5 class="text-center">Register</h5>
        <div class="row ">
            <form action="{{route('register')}}" method="POST" onsubmit="return check()">
                @csrf
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com"
                        name="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="name"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        value="{{ old('password') }}">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmpassword">
                    <span class="text-danger" id="error"></span>
                </div>
                <button class="btn btn-primary mt-4" type="submit" style="width: 100%">Register</button>
            </form>
            <a href="{{ url('login') }}" class="text-center mt-2">Login</a>
        </div>
    </div>
    <script>
        function check() {
            var pass = document.getElementById('password').value;
            var passCheck = document.getElementById('confirmpassword').value;
            if (pass != passCheck) {
                document.getElementById('error').innerHTML = "Passwords do not match";
                return false;
            } else {
                document.getElementById('error').innerHTML = "";
                return true
            }
        }
    </script>
@endsection
