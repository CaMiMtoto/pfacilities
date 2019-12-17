<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Update</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .billing-history tbody > tr > td {
            padding: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h4 class="text-center">Application Status</h4>
    <hr>
    @if($app->status=='certified')
        <p>
            Dear <strong>{{ $app->user->name }}</strong>,
            Your application is ready for signature. please wait for phone call to let you know when you can come and
            pick it.
            for more information , <a href="{{ route('login') }}">login</a> to view your application status or contact
            us
            <strong>
                <a href="telto:0782539657">0782539657</a>
            </strong>
        </p>
    @else
        <p>
            Dear <strong>{{ $app->user->name }}</strong>,
            Your application has sent for <strong>{{ $app->statusHandler() }}</strong>.
            for more information , <a href="{{ route('login') }}">login</a> to view your application status or contact
            us
            <strong>
                <a href="telto:0782539657">0782539657</a>
            </strong>
        </p>
    @endif
</div>


</body>
</html>
