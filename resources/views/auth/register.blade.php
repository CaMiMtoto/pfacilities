<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/css/app.css">
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="bg-white">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-xl-5">
            <div class="card shadow-sm border rounded-sm">
                <div class="card-body">
                    <h5> Create an account</h5>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('Names') }}</label>

                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" placeholder="Full name" required
                                   autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email"
                            >{{ __('E-Mail Address') }}</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" placeholder="Valid email address"
                                   required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone"
                            >{{ __('Phone number') }}</label>

                            <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror"
                                   name="phone" value="{{ old('phone') }}" placeholder="Phone number"
                                   required autocomplete="phone">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password"
                            >{{ __('Password') }}</label>

                                <input id="password" type="password" placeholder="Enter your password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm"
                            >{{ __('Confirm Password') }}</label>

                                <input id="password-confirm" type="password" class="form-control"
                                       placeholder="Repeat your password"
                                       name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-block rounded-sm">
                                {{ __('Register') }}
                            </button>
                        </div>
                        <br>
                        <div class="form-group mb-0">
                            <span>
                                Already have account?
                            </span>
                            <a href="/login">
                                {{ __('Login') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
