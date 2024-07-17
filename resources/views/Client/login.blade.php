@extends('Client.layouts.master')
@section('title')
@section('content')
    <div class="container" style="margin:8%;">
        <h5 class="text-center">Login</h5>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row ">
            <form action="" method="post">
                @csrf
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com"
                        name="email"
                        @if (isset($_COOKIE['email'])) value = "{{ $_COOKIE['email'] }}"
                    @else
                    value="{{ old('email') }}"> @endif
                        </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleFormControlInput1" name="password"
                            @if (isset($_COOKIE['password'])) value = "{{ $_COOKIE['password'] }}" @endif>
                    </div>
                    <div class="form-footer d-flex justify-content-between">
                        <div class="custom-control custom-checkbox mb-0">
                            <input type="checkbox" class="custom-control-input" id="lost-password" name="remeber"  @if (isset($_COOKIE['email'])) checked = "" @endif>
                            <label class = "custom-control-label mb-0"for="lost-password" >Remeber me</label>
                        </div>
                        <div class="text-center mt-2">
                            <a href="{{ url('register') }}">Register</a>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-4" type="submit" style="width: 100%">Login</button>
            </form>
            <div class="text-center mt-2">
                <a href="{{ route('Forgotpassword') }}">Forgot password</a>
            </div>

        </div>
    </div>
@endsection
