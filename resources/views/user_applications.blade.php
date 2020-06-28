@extends('layouts.app')
@section('title','Applications')
@section('content')
    <section class="content">
        @include('includes._alerts')
        <div class="box box-primary flat">
            <div class="box-header with-border">
                <div class="col-md-4">
                    <h3 class="box-title">
                        <i class="fa fa-file-archive-o"></i>
                        Applications {{ $userApps->total() }}
                    </h3>

                </div>
                <div class="box-tools">
                    @if(auth()->user()->role!='normal')
                        <div class="dropdown  pull-right">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu1"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                Filter Applications By
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="{{ route('userApplication',['filter'=>'all']) }}">All Applications</a></li>
                                <li><a href="{{ route('userApplication',['filter'=>'pending']) }}">Pending</a></li>
                                <li><a href="{{ route('userApplication',['filter'=>'certified']) }}">Certified</a></li>
                                <li><a href="{{ route('userApplication',['filter'=>'process']) }}">In Process</a></li>
                                <li><a href="{{ route('userApplication',['filter'=>'modification']) }}">Modification</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive" style="padding: 0;">
                <div class="col-md-6" style="padding-left: 0;">
                    @if(auth()->user()->role=='normal')
                        @foreach($appTypes as $type)
                            <button
                                style="margin: 5px;"
                                data-id="{{ $type->id }}"
                                class="btn btn-primary js-license">
                                {{ $type->name }}
                            </button>
                        @endforeach

                    @endif
                </div>
                <div class="col-md-6">

                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Application Id</th>
                        <th>Facility Name</th>
                        <th>Applicant</th>
                        <th>Phone Number</th>
                        <th>Application Type</th>
                        @if(auth()->user()->role!='normal')
                            <th>Progress</th>
                        @endif
                        <th>Status</th>
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
                                @if(auth()->user()->role==\App\Roles::$APPLICANT)
                                    {{ $app->application_id }}
                                @else
                                    <a href="{{ route('applicationHistories',$app->id) }}">{{ $app->application_id }}</a>
                                @endif
                            </td>
                            <td>
                                @if($app->facility)
                                    {{ $app->facility->name }}
                                @else
                                    <span class="label label-info">Not Found</span>
                                @endif
                            </td>
                            <td>{{ $app->user->name }}</td>
                            <td>
                                @if($app->user->phone)
                                    <span>{{ $app->user->phone }}</span>
                                @else
                                    <span class="label label-warning">Not Provided</span>
                                @endif
                            </td>
                            <td>{{ $app->applicationType->name }}</td>
                            @if(auth()->user()->role!=\App\Roles::$APPLICANT)
                                <td>In Progress</td>
                            @endif
                            <td>
                                @if($app->status=='pending')
                                    <span class="label label-info">{{ ucfirst($app->status) }}</span>
                                @elseif($app->status=='modification')
                                    <span class="label label-warning">{{ ucfirst($app->status) }}</span>
                                @elseif($app->status=='rejected')
                                    <span class="label label-danger">{{ ucfirst($app->status) }}</span>
                                @elseif($app->status=='verified')
                                    <span class="label label-success">{{ ucfirst($app->status) }}</span>
                                @else
                                    <span class="label label-default">{{ ucfirst($app->status) }}</span>
                                @endif

                            </td>
                            {{--                            <td>{{ $app->progress()['position']['name'] }}</td>--}}
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if(auth()->user()->role==\App\Roles::$APPLICANT)
                                        @if($app->status=='modification')
                                            <button
                                                data-id="{{ $app->application_type_id }}"
                                                data-facility_id="{{ $app->facility_id }}"
                                                data-url="{{ route('updateApplication',$app->id) }}"
                                                title="Appointment" class="btn btn-info btn-sm js-modify">
                                                Modify
                                            </button>
                                        @endif
                                    @endif

                                    @if(auth()->user()->role!=\App\Roles::$APPLICANT)
                                        {{-- <a href="{{ route('applicationComments',[$app->id]) }}"
                                            class="btn btn-default btn-sm">
                                             <i class="fa fa-comment"></i>
                                         </a>--}}
                                        <a href="{{ route('create.approvalLetter',$app->id) }}"
                                           title="Add feedback"
                                           class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        @if($app->license==null || $app->license->signed_at==null)
                                            <a href="{{ route('create.license',$app->id) }}"
                                               title="Add license"
                                               class="btn btn-primary btn-sm">
                                                <i class="fa fa-certificate"></i>
                                            </a>
                                        @endif
                                        <button class="btn btn-info btn-sm js-review"
                                                data-update-url="{{ route('updateReview',$app->id) }}"
                                                data-url="{{ route('reviewDocs',['userApplication'=>$app->id,'applicationType'=>$app->application_type_id,'user'=>$app->user_id]) }}">
                                            Docs
                                        </button>


                                    @endif
                                    @if($app->approvalLetter && $app->approvalLetter->signed_at)
                                        <a href="{{ route('viewLetter.approvalLetter',$app->approvalLetter->id) }}"
                                           target="_blank"
                                           class="btn btn-warning btn-sm">
                                            Feedback
                                        </a>
                                    @endif
                                    @if($app->license && $app->license->signed_at!=null)
                                        <a href="{{ route('view.license',$app->license->id) }}"
                                           target="_blank"
                                           class="btn btn-warning btn-sm">
                                            License
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                {{$userApps->links()}}
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
                        <div class="form-group form-group-sm">
                            <label for="picking_date" class="control-label col-sm-3">Pick Up Date</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control datepicker" name="picking_date"
                                       id="picking_date">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
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
        <div class="modal fade" id="licenseModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">
                            License Application
                        </h4>
                    </div>
                    <form novalidate action="{{ route('saveApplication') }}" enctype="multipart/form-data" method="post"
                          id="saveDocsForm">

                        <div class="modal-body">
                            @include('layouts._loader')
                            <div class="edit-result">
                                {{ csrf_field() }}
                                <div>
                                    <!-- Morris chart - Sales -->
                                    <div id="revenue-chart">
                                        @if($facilities->count() ==0)
                                            <div class="alert alert-danger flat">
                                                Please provide your facility information through
                                                <a style="color: whitesmoke" href="{{ route('facilities') }}">
                                                    <strong>health facilities</strong>
                                                </a>
                                                menu
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if($facilities->count() >0)
                                                    <div class="form-group form-group-sm">
                                                        <label for="facility_id" class="control-label">Facility</label>
                                                        <select required name="facility_id" id="facility_id"
                                                                class="form-control">
                                                            <option value="">--select facility--</option>
                                                            @foreach($facilities as $facility)
                                                                <option
                                                                    value="{{ $facility->id }}">{{ $facility->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="hidden" name="applicationType" required id="applicationType"/>
                                        </div>
                                    </div>
                                    @if($facilities->count() >0)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong class="text-danger">Please upload all required
                                                    documents</strong>
                                                <br><br>
                                            </div>
                                            <div id="sales-chart">

                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="modal-footer editFooter">

                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                    Close
                                </button>
                                @if($facilities->count() >0)
                                    <button type="submit" id="saveApplicationBtn" class="btn btn-primary">
                                        <i class="fa fa-check-circle"></i>
                                        Submit application
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="editLicenseModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">
                            License Application
                        </h4>
                    </div>
                    <form novalidate action="" enctype="multipart/form-data" method="post"
                          id="updateDocsForm">

                        <div class="modal-body">
                            @include('layouts._loader')
                            <div class="edit-result">
                                @csrf
                                <div>
                                    <!-- Morris chart - Sales -->
                                    <div id="revenue-chart">
                                        @if($facilities->count() ==0)
                                            <div class="alert alert-danger">
                                                Please provide your facility information through
                                                <a style="color: whitesmoke" href="{{ route('facilities') }}">
                                                    <strong>health facilities</strong>
                                                </a>
                                                menu
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if($facilities->count() >0)
                                                    <div class="form-group form-group-sm">
                                                        <label for="facility_id" class="control-label">Facility</label>
                                                        <select required name="facility_id" id="edit_facility_id"
                                                                class="form-control">
                                                            <option value="">--select facility--</option>
                                                            @foreach($facilities as $facility)
                                                                <option
                                                                    value="{{ $facility->id }}">{{ $facility->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="hidden" name="applicationType" required
                                                   id="editApplicationType"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong class="text-danger">Please upload all required documents</strong>
                                            <br><br>
                                        </div>
                                        <div id="docs_results">

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="modal-footer editFooter">

                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                    Close
                                </button>
                                <button type="submit" id="updatedApplicationBtn" class="btn btn-primary">
                                    <i class="fa fa-check-circle"></i>
                                    Update application
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
            $('#updateDocsForm').validate();

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

            $('.js-license').on('click', function () {
                $('#licenseModal').modal();
                let appTypeId = $(this).attr('data-id');
                $('#applicationType').val(appTypeId);
                $.ajax({
                    'url': '/app-types/documents/' + appTypeId,
                    'method': 'get',
                    'type': 'text/html'
                }).done(function (data) {
                    $('#sales-chart').html(data);
                    $('a[href="#sales-chart"]').tab('show') // Select tab by name
                });
            });

            $('.js-modify').on('click', function () {
                $('#editLicenseModal').modal();
                let appTypeId = $(this).attr('data-id');
                let facilityId = $(this).attr('data-facility_id');
                let url = $(this).attr('data-url');
                $('#edit_facility_id').val(facilityId);
                $('#editApplicationType').val(appTypeId);
                $('#updateDocsForm').attr('action', url);

                $.ajax({
                    'url': '/app-types/documents/' + appTypeId,
                    'method': 'get',
                    'type': 'text/html'
                }).done(function (data) {
                    $('#docs_results').html(data);
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
                        }).fail(function (err) {
                        $('#createBtn').button('reset');
                        alert('Not allowed to make any change now!')
                    });
                }
            });


            $(document).on('change', '#status', function () {
                let value = $(this).val();
                let shareApp = $(document).find('#shareApplicationId');
                if (value === 'modification') {
                    shareApp.addClass('div-hide');
                } else {
                    shareApp.removeClass('div-hide');
                }
            });


        });


    </script>
@endsection
