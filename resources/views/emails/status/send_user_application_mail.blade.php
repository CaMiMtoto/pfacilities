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
        <p>
            Dear, <br>
            <strong>{{ $app->applicationType->name }}</strong> for <strong>{{$app->facility->name}}</strong> is waiting for your approval.
            Please <a href="{{ route('login') }}">Login</a> to view  applications.
        </p>

</div>


</body>
</html>
