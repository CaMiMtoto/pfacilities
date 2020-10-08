@extends('layouts.app')
@section('title','Dashboard')
@section('styles')
    <!-- Morris chart -->
    <link rel="stylesheet" href="bower_components/morris.js/morris.css">
@endsection
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
                <div class="box box-primary flat">
                    <div class="box-header with-border">
                        <i class="fa fa-pie-chart"></i>

                        <h3 class="box-title">Facilities chart by categories</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <canvas id="barChart" style="height:250px"></canvas>
                    </div>
                    <!-- /.box-body-->
                </div>
                <!-- /.box -->
            </div>
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
                        <a href="{{ route('adminFacilities')}}" class="btn btn-sm btn-link btn-flat">View All
                            Facilities</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        </div>

        <div class="row">

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
                        <a href="{{ route('userApplication')}}" class="btn btn-sm btn-link btn-flat">View All
                            Applications</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        </div>

    </section>
@endsection
@section('scripts')

    <script src="{{ asset('bower_components/chart.js/Chart.js') }}"></script>
    <script>
        $('.nav-dashboard').addClass('active');

        $(function () {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */

            //--------------
            //- AREA CHART -
            //--------------


            var areaChartData = {
                labels: {!! json_encode($labels) !!},
                datasets: [
                    {
                        label: 'Electronics',
                        fillColor: '#2aab70',
                        strokeColor: 'rgba(210, 214, 222, 1)',
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: {!! json_encode($values) !!}
                    }
                ]
            }

            var PieData = [
                {
                    value: 700,
                    color: '#f56954',
                    highlight: '#f56954',
                    label: 'Chrome'
                },
                {
                    value: 500,
                    color: '#00a65a',
                    highlight: '#00a65a',
                    label: 'IE'
                },
                {
                    value: 400,
                    color: '#f39c12',
                    highlight: '#f39c12',
                    label: 'FireFox'
                },
                {
                    value: 600,
                    color: '#00c0ef',
                    highlight: '#00c0ef',
                    label: 'Safari'
                },
                {
                    value: 300,
                    color: '#3c8dbc',
                    highlight: '#3c8dbc',
                    label: 'Opera'
                },
                {
                    value: 100,
                    color: '#d2d6de',
                    highlight: '#d2d6de',
                    label: 'Navigator'
                }
            ]
            var pieOptions = {
                //Boolean - Whether we should show a stroke on each segment
                segmentShowStroke: true,
                //String - The colour of each segment stroke
                segmentStrokeColor: '#fff',
                //Number - The width of each segment stroke
                segmentStrokeWidth: 2,
                //Number - The percentage of the chart that we cut out of the middle
                percentageInnerCutout: 50, // This is 0 for Pie charts
                //Number - Amount of animation steps
                animationSteps: 100,
                //String - Animation easing effect
                animationEasing: 'easeOutBounce',
                //Boolean - Whether we animate the rotation of the Doughnut
                animateRotate: true,
                //Boolean - Whether we animate scaling the Doughnut from the centre
                animateScale: false,
                //Boolean - whether to make the chart responsive to window resizing
                responsive: true,
                // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                maintainAspectRatio: true,
                //String - A legend template
                legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
            }


            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChart = new Chart(barChartCanvas)
            var barChartData = areaChartData;
            var barChartOptions = {
                //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                scaleBeginAtZero: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: true,
                //String - Colour of the grid lines
                scaleGridLineColor: 'rgba(0,0,0,.05)',
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - If there is a stroke on each bar
                barShowStroke: true,
                //Number - Pixel width of the bar stroke
                barStrokeWidth: 2,
                //Number - Spacing between each of the X value sets
                barValueSpacing: 5,
                //Number - Spacing between data sets within X values
                barDatasetSpacing: 1,
                //String - A legend template
                legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                //Boolean - whether to make the chart responsive
                responsive: true,
                maintainAspectRatio: true
            }

            barChartOptions.datasetFill = false
            barChart.Bar(barChartData, barChartOptions)
        });

    </script>
@endsection
