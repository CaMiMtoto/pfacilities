@extends('layouts.app')
@section('title','Applications')
@section('content')
    <section class="content">

        <div class="box box-primary flat">
            <div class="box-header with-border">
                <div class="col-md-4">
                    <h3 class="box-title">
                        <i class="fa fa-file-archive-o"></i>
                        Applications
                    </h3>
                </div>
                <div class="col-md-4">
                    <form action="" class="form-inline">
                        <div class="form-group form-group-sm">
                            <label for="filter" class="control-label">Filter By</label>
                            <div class="input-group">
                                <select name="filter" class="form-control " id="filter">
                                    <option value="all">All Applications</option>
                                    <option value="pending">Pending</option>
                                    <option value="certified">Certified</option>
                                    <option value="process">In Process</option>
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-sm" type="submit">
                                       <i class="fa fa-filter"></i>
                                        Filter
                                    </button>
                                </span>
                            </div><!-- /input-group -->

                        </div>
                    </form>
                </div>
                <div class="box-tools">

                    @if(\Illuminate\Support\Facades\Auth::user()->role=='normal')
                        <button
                            data-toggle="modal" data-target="#addDocsModal"
                            class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i>
                            New Application
                        </button>
                    @endif
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table">
                    <tfoot>
                    <tr>
                        <td colspan="8">  {{$userApps->links()}}</td>
                    </tr>
                    </tfoot>

                    <thead>
                    <tr>
                        <th>Application Id</th>
                        <th>Facility Name</th>
                        <th>Applicant</th>
                        <th>Phone Number</th>
                        <th>Application Type</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($userApps as $app)
                        {{--  @if($app->shared())
                              @continue(true)
                          @endif--}}
                        <tr>
                            <td>
                                <a href="{{ route('applicationHistories',$app->id) }}">{{ $app->application_id }}</a>
                            </td>
                            <td>
                                @if($app->facility)
                                    {{ $app->facility->name }}
                                @else
                                    <span class="label label-info">Not Found</span>
                                @endif
                            </td>
                            <td>{{ $app->user->name }}</td>
                            <td>{{ $app->user->phone }}</td>
                            <td>{{ $app->applicationType->name }}</td>
                            <td>In Progress</td>
                            <td>{{ $app->progress()['position']['name'] }}</td>
                            <td>
                                @if(Auth::user()->role!='normal')
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('applicationComments',[$app->id]) }}"
                                           class="btn btn-default btn-sm">
                                            <i class="fa fa-comment"></i>
                                        </a>
                                        @if($app->status=='approved')
                                            <button
                                                data-url="{{ route('makeAppointment',$app->id) }}"
                                                title="Appointment" class="btn btn-primary btn-sm js-appoint">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        @endif
                                        <button class="btn btn-info btn-sm js-review"
                                                data-update-url="{{ route('updateReview',$app->id) }}"
                                                data-url="{{ route('reviewDocs',['userApplication'=>$app->id,'applicationType'=>$app->application_type_id,'user'=>$app->user_id]) }}">
                                            Review
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            </div>
        </div>
    </section>



    <div class="modal fade" id="picking_date_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        Appointment
                    </h4>
                </div>
                <form autocomplete="off" action="" id="appointment-form" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="picking_date" class="control-label col-sm-3">Pick Up Date</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control datepicker" name="picking_date"
                                       id="picking_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="picking_date" class="control-label col-sm-3">Pick Up Time</label>
                            <div class="col-sm-9">
                                <input required type="time" class="form-control" name="time"
                                       id="picking_date">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="appointmentBtn" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    @if(\Illuminate\Support\Facades\Auth::user()->role=='normal')
        <div class="modal fade" id="addDocsModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">
                            <i class="fa fa-heartbeat"></i>
                            New Application
                        </h4>
                    </div>
                    <form novalidate action="{{ route('saveApplication') }}" enctype="multipart/form-data" method="post"
                          id="saveDocsForm">

                        <div class="modal-body">
                            @include('layouts._loader')
                            <div class="edit-result">
                            {{ csrf_field() }}
                            <!-- Custom tabs (Charts with tabs)-->
                                <div class="nav-tabs-custom">
                                    <!-- Tabs within a box -->
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#revenue-chart" data-toggle="tab">
                                                Personal Information
                                            </a>
                                        </li>
                                        <li><a href="#sales-chart" data-toggle="tab">Documents</a></li>
                                    </ul>
                                    <div class="tab-content no-padding">
                                        <!-- Morris chart - Sales -->
                                        <div class="chart tab-pane active" id="revenue-chart">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="facility_id" class="control-label">Facility</label>
                                                    <select required name="facility_id" id="facility_id"
                                                            class="form-control">
                                                        <option value=""></option>
                                                        @foreach($facilities as $facility)
                                                            <option
                                                                value="{{ $facility->id }}">{{ $facility->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="applicationType" class="control-label">
                                                        Application type
                                                    </label>
                                                    <select name="applicationType" required id="applicationType"
                                                            class="form-control">
                                                        <option value=""></option>
                                                        @foreach($appTypes as $type)
                                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chart tab-pane" id="sales-chart">

                                        </div>
                                    </div>
                                </div>
                                <!-- /.nav-tabs-custom -->
                            </div>

                        </div>
                        <div class="modal-footer editFooter">

                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                    Close
                                </button>
                                <button type="submit" id="saveApplicationBtn" class="btn btn-primary">
                                    <i class="fa fa-check-circle"></i>
                                    Save changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    @endif



    @include('partials.docsModal')


@endsection

@section('scripts')
    {{--    <script src="{{ asset('bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>--}}
    <script>
        $(function () {
            $('.nav-applications').addClass('active');

            $('#saveDocsForm').validate();

            $('.js-appoint').on('click', function () {
                var url = $(this).attr('data-url');
                $('#picking_date_modal').modal();
                $('#appointment-form').on('submit', function (e) {
                    var btn = $('#appointmentBtn');
                    e.preventDefault();
                    // if (!$(this).valid()) return false;

                    btn.button('loading');
                    $.post(url, $(this).serialize())
                        .done(function (data) {
                            btn.button('reset');
                            location.reload();
                        }).fail(function (error) {
                        btn.button('reset');
                    })
                });
            });

            $('#applicationType').on('change', function () {
                if (!$(this).val()) return;
                $.ajax({
                    'url': '/app-types/documents/' + $(this).val(),
                    'method': 'get',
                    'type': 'text/html'
                }).done(function (data) {
                    $('#sales-chart').html(data);
                    $('a[href="#sales-chart"]').tab('show') // Select tab by name
                });
            });

            // $('#form').validate();

            $('.js-review').on('click', function () {
                var url = $(this).attr('data-url');
                $('#submitReviewForm').attr('action', $(this).attr('data-update-url'));
                $('#docsModal').modal();
                showLoader();
                $.ajax({
                    'url': url,
                    'method': 'get',
                    'type': 'text/html'
                }).done(function (data) {
                    hideLoader();
                    $('#docsResults').html(data);
                });
            });

            $('#submitReviewForm').on('submit', function (e) {
                e.preventDefault();
                var form = $(this);
                if (form.valid()) {
                    $('#createBtn').button('loading');
                    // e.target.submit();
                    $.post(form.attr('action'), form.serialize())
                        .done(function (data) {
                            location.reload();
                        });
                }
            });


        });


    </script>
@endsection
