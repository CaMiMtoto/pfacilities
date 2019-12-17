@extends('layouts.app')

@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>summary</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> MoH Private Facilities</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
       @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
       

    </section>


@endsection
