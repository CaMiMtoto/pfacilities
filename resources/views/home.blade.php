@extends('layouts.app')
@section('title','Dashboard')
@section('content')
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{number_format(\App\Facility::count())}}</h3>

                        <p>Facilities</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-heart"></i>
                    </div>
                    <a href="{{ route('adminFacilities') }} " class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ number_format(\App\UserApplication::query()->where('status','Pending')->count()) }}</h3>
                        <p>Pending applications</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('userApplication') }}" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ \App\User::query()->where('role','!=','Normal')->count() }}</h3>
                        <p>Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-people"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{\App\Service::count()}}</h3>

                        <p>Services</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-list"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-info flat">
                    <div class="box-header with-border">
                        <h3 class="box-title">Latest Facilities</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Manager</th>
                                    <th>Phone</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(\App\Facility::with('category')->orderByDesc('id')->limit(5)->get() as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->category->name}}</td>
                                        <td>{{$item->manager_name}}</td>
                                        <td>
                                            <a href="tel:{{$item->phone}}">{{$item->phone}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix text-center">
                        <a href="{{ route('adminFacilities')}}" class="btn btn-sm btn-link btn-flat">View All Facilities</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-warning flat">
                    <div class="box-header with-border">
                        <h3 class="box-title">Latest Applications</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Applicant</th>
                                    <th>Facility</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(\App\UserApplication::with('facility')->orderByDesc('id')->limit(5)->get() as $item)
                                    <tr>
                                        <td>{{$item->application_id}}</td>
                                        <td>{{$item->user->name}}</td>
                                        <td>{{$item->facility->name}}</td>
                                        <td>{{$item->applicationType->name}}</td>
                                        <td>{{$item->status}}</td>
                                        <td>
                                            <a href="tel:{{$item->phone}}">{{$item->phone}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix text-center" style="">
                        <a href="{{ route('userApplication')}}" class="btn btn-sm btn-link btn-flat">View All Applications</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        </div>

    </section>
@endsection
@section('scripts')
    <script>
        $(function () {
            $('.nav-dashboard').addClass('active');
        });
    </script>
@endsection
