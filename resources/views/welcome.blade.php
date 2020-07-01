<!DOCTYPE html>
<html lang="en">
<head>
    <title>MoH | Private Facilities </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style_new.css">
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans|Nunito:300&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Nunito", sans-serif !important;
            /*font-family: 'Nunito Sans', sans-serif;*/
        }

        .form-control, .btn {
            border-radius: 30px !important;
        }

        @media (min-width: 768px) {
            .pt-md-5, .py-md-5 {
                padding-top: 0 !important;
            }
        }

        .ftco-navbar-light {
            background: #407698 !important;
        }

        .nav {
            font-color: white;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
<div class="py-1 bg-black top">
    <div class="container">
        <div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
            <div class="col-lg-12 d-block">
                <div class="row d-flex">
                    <div class="col-md pr-4 d-flex topper align-items-center">
                        <div class="icon mr-2 d-flex justify-content-center align-items-center"><span
                                class="icon-phone2"></span></div>
                        <span class="text">+250 782539657</span>
                    </div>
                    <div class="col-md pr-4 d-flex topper align-items-center">
                        <div class="icon mr-2 d-flex justify-content-center align-items-center"><span
                                class="icon-paper-plane"></span></div>
                        <span class="text">info@moh.gov.rw</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light site-navbar-target"
     id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}" style="color: white">Ministry of Health</a>
        <button class="navbar-toggler js-fh5co-nav-toggle fh5co-nav-toggle" type="button" data-toggle="collapse"
                data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav nav ml-auto">
                {{--                <li class="nav-item"><a href="#about-section" class="nav-link"><span>About</span></a></li>--}}


            </ul>

        </div>
    </div>
</nav>

<section class="hero-wrap js-fullheight" data-section="home" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start"
             data-scrollax-parent="true">
            <div class="col-md-6 pt-5 ftco-animate">
                <div class="mt-5">
                    <span class="subheading">Welcome to the Ministry of Health - Rwanda</span>
                    {{--                    <h1 class="mb-4">We are here <br>for your Care</h1>--}}
                    <p class="mb-4">
                        Welcome
                        Welcome to Ministry of Health’s platform for enablining provate health facilities practitioners
                        share License application documents and other related services. Through this system, you can
                        create account and login, provide your facility's information, apply for new licence and apply
                        to renew your expiring licence. You can also send any other letter related to clinical services
                        under 'otherS' option by uploading and sharing your documents then wait for us to work on it as
                        and provide you the feedback through your account.Please Note: All information contained in this
                        system is strictly confidential. No information can be disclosed in any form to any individual
                        without appropriate level of authority vested in you.
                    </p>
                    <p>
                        <a href="{{ route('login') }}" class="btn btn-warning py-3 px-4">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary py-3 px-4">
                            Create Account
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>


<footer class="ftco-footer ftco-section img" style=" background-color:#407698" ;>
    <div class="overlay"></div>
    <div class="container-fluid px-md-5">
        <div class="row mb-5">
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">ABOUT MOH</h2>
                    <p>The mission of the Ministry of Health is to provide and continually improve affordable promotive,
                        preventive, curative and rehabilitative health care services of the highest quality,
                        thereby contributing to the reduction of poverty and enhancing the general well-being of the
                        population.</p>
                    <ul class="ftco-footer-social list-unstyled mt-5">
                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                        <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                        <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md">
                <div class="ftco-footer-widget mb-4 ml-md-4">
                    <h2 class="ftco-heading-2">AFFILIATED INSTITUTIONS</h2>
                    <ul class="list-unstyled">
                        <li><a href="https://moh.gov.rw"><span class="icon-long-arrow-right mr-2"></span>MoH Website</a>
                        </li>
                        <li><a href="http://rbc.gov.rw/index.php?id=188"><span
                                    class="icon-long-arrow-right mr-2"></span>Rwanda Biomedical Center</a></li>
                        <li><a href="http://chuk.rw/"><span class="icon-long-arrow-right mr-2"></span>CHUK</a></li>
                        <li><a href="https://moh.gov.rw/index.php?id=489"><span
                                    class="icon-long-arrow-right mr-2"></span>Rwanda FDA</a></li>
                        <li><a href="https://moh.gov.rw/index.php?id=551"><span
                                    class="icon-long-arrow-right mr-2"></span>Health Policies</a></li>

                    </ul>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">IMPORTANT LINKS</h2>
                    <ul class="list-unstyled">
                        <li><a href="http://gov.rw/home/"><span class="icon-long-arrow-right mr-2"></span>Government of
                                Rwanda</a></li>
                        <li><a href="https://www.minaloc.gov.rw/index.php?id=2"><span
                                    class="icon-long-arrow-right mr-2"></span>Ministry of Local Government</a></li>
                        <li><a href="http://rssb.rw/"><span class="icon-long-arrow-right mr-2"></span>Rwanda Social
                                Security Board</a></li>
                        <li><a href="https://www.rsb.gov.rw/index.php?id=8"><span
                                    class="icon-long-arrow-right mr-2"></span>Rwanda Standards Board</a></li>
                        <li><a href="https://police.gov.rw/home/"><span class="icon-long-arrow-right mr-2"></span>Rwanda
                                National Police</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">OUR CONTACT</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li><span class="icon icon-map-marker"></span><span class="text">Ministry of Health</span>
                            </li>
                            <li><span class="icon icon-map-marker"></span><span
                                    class="text">Address: KN 3 Rd, Kigali</span></li>
                            <li><span class="icon icon-map-marker"></span><span class="text">info@moh.gov.rw</span></li>
                            <li><span class="icon icon-map-marker"></span><span class="text">SAMU/Ambulances 912</span>
                            </li>
                            <li><span class="icon icon-map-marker"></span><span
                                    class="text">Rwanda Biomedical Center</span></li>
                            <li><span class="icon icon-map-marker"></span><span class="text">114/1110</span></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">

                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                    All rights reserved
                    <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://moh.gov.rw"
                                                                                     target="_blank">Ministry of
                        Health </a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
            </div>
        </div>
    </div>
</footer>

<!-- loader -->
<div id="ftco-loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
                stroke="#F96D00"/>
    </svg>
</div>


<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/scrollax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
<script src="js/google-map.js"></script>

<script src="js/main_new.js"></script>

</body>
</html>

{{--


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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>
<div class="container">
    <br>
    <br>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email"
                                   class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
--}}{{--
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                @if (Route::has('register'))
                                    <a class="btn btn-link" href="{{ route('register') }}">
                                        {{ __('Register now!') }}
                                    </a>
                                @endif
                            </div>
                        </div>--}}{{--
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>--}}
