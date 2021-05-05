<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>--Login--</title>
    <link rel="stylesheet" href="{{ asset('css/backend.css') }}">
</head>
<body>
    <div class="boxlogin">
        <div class="boxlogin1">
            <div class="logo">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                      <div class="input-group mb-8">
                        <input id="email" type="email" name="email" class="form-email @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email">
                        <span class="divuser"></span>
                        @error('email')
                            <span class="invalid-email" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                      <div class="input-group mb-3">
                        <input id="password" type="password" name="password" class="form-password @error('password') is-invalid @enderror" placeholder="Password">
                        <span class="divlock"></span>
                        @error('password')
                            <span class="invalid-password" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                          <div class="divremember">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label>
                                Ingat Saya
                                </label>
                          </div>
                            @if (Route::has('password.request'))
                                <a class="buttonlink" href="{{ route('password.request') }}">Lupa Password</a>
                            @endif
                          <button type="submit" class="button">Sign In</button>
                    </form>

                    @if (Route::has('password.request'))
                        <a class="buttonlink" href="{{ route('password.request') }}">Lupa Password</a>
                    @endif
                    <p class="linktextakun">Belum Punya Akun?</p>
                        @if (Route::has('register'))
                            <a class="linkregis" href="{{ route('register') }}">"Daftar"</a>
                        @endif

                    <div class="box1">
                </div>

            </div>
        </div>
    </div>
</body>
</html>



{{-- @extends('layouts.login')

@section('content')
<div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
          <div class="input-group mb-3">
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <div class="social-auth-links text-center mb-3">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-primary">
              <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
              <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a>
        </div>
          <!-- /.social-auth-links -->

        <p class="mb-1">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">I forgot my password</a>
            @endif
        </p>
        <p class="mb-0">
            @if (Route::has('register'))
                <a href="{{ route('register') }}">Register a new membership</a>
            @endif
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>

@endsection --}}
