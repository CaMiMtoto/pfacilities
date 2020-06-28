<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Approval Letter for {{ $approval->userApplication->facility->name }} </title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        html, body {
            font-family: "Times New Roman", sans-serif !important;
        }
    </style>
</head>
<body class="bg-white">
<div>
    <div class="container mt-3">
        <button
            onclick="window.print()"
            class="btn btn-primary mb-3 no-print">
            Print
        </button>
        <div class="row justify-content-center">

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <div>
                            <p>
                                <strong class="text-uppercase">
                                    Republic of rwanda
                                </strong>
                            </p>
                            <img src="{{ asset('dist/img/moh.jpg') }}" class="img-fluid rounded border-white"
                                 style="height: 50px; object-fit: cover" alt="">
                            <p class="mt-2 mb-0">
                                <strong>
                                    P.O BOX 84 Kigali
                                </strong>
                            </p>
                            <p>
                                <small>
                                    <a href="http://www.moh.gov.rw">
                                        www.moh.gov.rw
                                    </a>
                                </small>
                            </p>
                        </div>
                        <div class="mt-3">

                            <p class="mb-0">
                                <strong>{{ $approval->userApplication->user->name }}</strong>
                            </p>
                            <p class="mb-0">
                                <strong>{{ $approval->userApplication->facility->name }}</strong>
                            </p>
                            <p class="mb-0">
                                <strong>Tel:</strong>
                                <span>{{ $approval->userApplication->user->phone }}</span>
                            </p>
                            <p class="mb-0">
                                <strong class="border-bottom border-dark text-uppercase">
                                    {{ $approval->userApplication->facility->sector->district->name }}
                                    District
                                </strong>
                            </p>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <p>
                            Kigali,
                        </p>
                        <p>
                            <strong>
                                {{ $approval->ref_number }}
                            </strong>
                        </p>
                    </div>
                </div>

                <div class="mt-5">
                    <p class="mb-0">
                        <span>
                            <strong class="text-uppercase border-bottom border-dark">RE:</strong>
                            <span> {{ $approval->reason }}</span>
                        </span>
                    </p>
                </div>
                <div class="mt-3 mb-3">
                    <p>{{ $approval->body }}</p>
                </div>
                <div>
                    <p class="mb-0">
                        Sincerely
                    </p>
                    <span>
                            <img src="{{ $approval->user->signature->signature_url }}" alt="Signature"
                                 class="img-fluid ml-5"
                                 style="height: 50px">

                      </span>
                </div>
                <div>
                    <p class="mb-0">
                        <strong>{{ $approval->done_by }}</strong>
                    </p>
                    <p class="mb-0">
                        <strong>{{ $approval->done_by_title }}</strong>
                    </p>
                    <p class="mb-0">
                        <strong class="border-bottom border-dark">
                            Cc:
                        </strong>
                    </p>

                    <ul style="list-style-type: none">
                        @foreach($approval->carbonCopies as $c)
                            <li>
                                <strong>- {{ $c->name }}</strong>
                            </li>
                        @endforeach
                    </ul>

                </div>

            </div>

        </div>
    </div>
</div>
</body>
</html>
