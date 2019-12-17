@extends('headers.header')
<head>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/main.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

<div id="container-login">
    <div id="title">
        <i class="material-icons lock">lock</i> Login
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input">
            <div class="input-addon">
                <i class="material-icons">face</i>
            </div>
            <input id="email" placeholder="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="clearfix"></div>

        <div class="input">
            <div class="input-addon">
                <i class="material-icons">vpn_key</i>
            </div>
            <input id="password" placeholder="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="clearfix"></div>
        
        <div class="form-group row">
            <div class="col-md-6 offset-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        Remember Me
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-2">
                <div class="submit_button">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>
                </div>

                @if (Route::has('password.request'))
                    <div class="forgot-password">
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </form>

    <div class="Github_Button">
        <a href="{{ route('social.login',['github']) }}">
            <img src="images/github.png" width="30px" height="30px"></i> <strong>Github 계정으로 로그인하기 </strong>
        </a>
    </div>

    <div class="register">
        Don't have an account yet?
        <a href="{{ route('register') }}"><button id="register-link">Register here</button></a>
    </div>
</div>
</body>