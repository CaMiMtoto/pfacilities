<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application </title>

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
    <h3>
        Dear {{ $app->position->name }}, {{ $app->sharedBy->name }} has shared Application
        ({{ $app->userApplication->application_id }}) for your consideration and approval. please click
        <a href="{{ route('my.shared.app.all') }}">Here</a> to view the application.
    </h3>
    <h1 class="text-center">Thank you!</h1>

</div>


</body>
</html>
