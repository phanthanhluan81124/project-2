@extends('Client.layouts.master')
@section('title')
@section('content')
    <div class="container" style="margin:8%;">
        <h5 class="text-center">Forgot Password</h5>
        <div class="row ">
            <form action="" method="post" onsubmit="return checkPass()">
                @csrf
                @if (session()->exists('key'))
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Verification</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1"
                            placeholder="" name="verification" value="{{ old('Verification') }}">
                        @error('verification')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                @elseif(!session()->exists('key') && !session()->exists('newpass'))
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1"
                            placeholder="name@example.com" name="email" value="{{ old('email') }}">
                        @error('email')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                @elseif(session()->exists('newpass'))
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder=""
                            name="password" value="{{ old('password') }}">
                        @error('password')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="">
                            <span class="text-danger" id="error"></span>
                    </div>
                @endif

                <button class="btn btn-primary mt-4" type="submit" style="width: 100%">Send</button>
            </form>
            <div class="text-center mt-2">
                <a href="{{ route('login') }}">Login</a>
            </div>

        </div>
    </div>
    <script>
        function checkPass() {
            const pass = document.getElementById('password').value
            const cfpass = document.getElementById('confirmPassword').value
            if (pass == cfpass) {
                return true;
            } else{
                document.getElementById('error').innerHTML = "Password Incorrect"
                return false;
            }
        }
    </script>
@endsection
