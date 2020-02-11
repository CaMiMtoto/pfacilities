@extends('layouts.app')
@section('title','Facilities')
@section('styles')
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endsection
@section('content')
    <section class="content">
        @if(Auth::user()->role=='admin')
            <a href="{{ route('summary') }}" class="btn btn-primary btn-sm">
                Summary
            </a>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->role=='normal')
            <button class="btn btn-primary  btn-sm pull-right" id="addButton">
                <i class="fa fa-plus"></i>
                Register facility
            </button>
        @endif
        <div class="clearfix"></div>
        <div class="box box-primary flat">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-heartbeat"></i>
                    Health Facility { {{count($facilities)}} }
                </h3>

                <div class="box-tools pull-right">
                    <form action="" class="form-inline" autocomplete="off">
                        <input type="text" name="q" class="form-control" placeholder="Search.."/>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>

                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Ref Number</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Service</th>
                        <th scope="col">Manager</th>
                        <th scope="col">Phone</th>
                        <th scope="col">L.Issued</th>
                        <th scope="col">L.Expire</th>
                        <th scope="col">Rem Days</th>
                        <th style="width: 20%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($facilities as $fac)
                        <tr>
                            <td>
                                @if($fac->ref_number)
                                    <span>{{$fac->ref_number}}</span>
                                @else
                                    <span class="label label-info">Not Given</span>
                                @endif
                            </td>
                            <td>{{ $fac->name }}</td>
                            <td>{{ $fac->category->name }}</td>
                            <td>{{ $fac->service->name }}</td>
                            <td>{{ $fac->manager_name }}</td>
                            <td>{{ $fac->phone }}</td>
                            <td>{{ $fac->license_issued_at!=null? $fac->license_issued_at->format('d/m/Y'):'Not set' }}</td>
                            <td>{{ $fac->license_expires_at!=null?$fac->license_expires_at->format('d/m/Y'):'Unknown' }}</td>
                            <td>
                                <?php
                                $color = 'black'; ?>
                                @if($fac->license_expires_at!=null)
                                    <?php
                                    $daysRemain = $fac->license_expires_at->diff($fac->license_issued_at)->format('%a');
                                    if ($daysRemain < 30)
                                        $color = 'red;font-weight:800;';
                                    ?>
                                @endif
                                <span style="color: {{$color}}">{{ isset($daysRemain)?$daysRemain :'Unknown' }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm flat">
                                    @if(Auth::user()->role!='normal')
                                        <button class="btn flat btn-default js-edit btn-sm"
                                                data-url="{{ route('facilities.show',$fac->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    @endif
                                    <a class="btn flat btn-primary btn-sm"
                                       title="View facility visits"
                                       href="{{ route('facilities.visits',[$fac->id]) }}">
                                        View Visits
                                    </a>
                                    @if(Auth::user()->role=='normal')
                                        @if(isset($daysRemain) && $daysRemain <=30)
                                            <button class="btn flat btn-warning js-renew btn-sm"
                                                    data-url="{{ route('renew.facility.doc',$fac->id) }}">
                                                <i class="fa fa-calendar"></i>
                                                Renew
                                            </button>
                                        @endif
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
                {{ $facilities->links() }}
            </div>
        </div>
    </section>


    <div class="modal fade myModal" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">
                        Health Facility
                    </h4>
                </div>
                <form novalidate action="{{ route('facilities.store') }}" method="post"
                      enctype="multipart/form-data"
                      id="saveForm">

                    <div class="modal-body">
                        @include('layouts._loader')
                        <div class="edit-result">
                            <input type="hidden" id="id" name="id" value="0">
                            {{ csrf_field() }}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="control-label">Facility Name</label>
                                    <div>
                                        <input required minlength="2" maxlength="50" type="text" class="form-control"
                                               name="name" id="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category_id" class="control-label">Facility Category</label>
                                    <div>
                                        <select class="form-control" required name="category_id" id="category_id">
                                            <option value=""></option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="service_id" class="control-label">Service</label>
                                    <div>
                                        <select class="form-control" required name="service_id" id="service_id">
                                            <option value=""></option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="other_service" class="control-label">Other Service</label>
                                    <div>
                                        <input class="form-control" type="text" name="other_service"
                                               id="other_service"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="control-label">Email</label>
                                    <div>
                                        <input required type="email" name="email" id="email"
                                               placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nationalId" class="control-label">ID Number</label>
                                    <div>
                                        <input required type="text" maxlength="16" name="nationalId" id="nationalId"
                                               placeholder="Id Number" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group div-hide" id="license_issued_at_group">
                                    <label for="license_issued_at" class="control-label">License Issued At</label>
                                    <div>
                                        <input required type="tel" autocomplete="off" name="license_issued_at"
                                               id="license_issued_at"
                                               placeholder="" class="form-control datepicker">
                                    </div>
                                </div>


                                <div class="form-group div-hide" id="district_report_form">
                                    <label for="district_report" class="control-label">
                                        District report
                                    </label>
                                    <div>
                                        <input required type="file" name="district_report" id="district_report"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="province_id" class="control-label">Province</label>
                                    <div>
                                        <select class="form-control" required name="province_id" id="province_id">
                                            <option value=""></option>
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="district_id" class="control-label">District</label>
                                    <div>
                                        <select class="form-control" required name="district_id" id="district_id">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sector_id" class="control-label">Sector</label>
                                    <div>
                                        <select class="form-control" required name="sector_id" id="sector_id">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="manager_name" class="control-label">Manager/Facility Representative</label>
                                    <div>
                                        <input required type="text" name="manager_name" id="manager_name"
                                               placeholder="Manager" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label">Phone</label>
                                    <div>
                                        <input required type="tel" name="phone" id="phone"
                                               placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="license_status" class="control-label">
                                        Licence status
                                    </label>
                                    <div>
                                        <select required name="license_status" id="license_status" class="form-control">
                                            <option value=""></option>
                                            <option value="new">New license</option>
                                            <option value="licensed">Valid licence</option>
                                            <option value="renew">Renew licence</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group div-hide" id="license_expires_at_group">
                                    <label for="license_expires_at" class="control-label">License Expires At</label>
                                    <div>
                                        <input required type="text" autocomplete="off" name="license_expires_at"
                                               id="license_expires_at"
                                               placeholder="" class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="form-group div-hide" id="app_letter_form">
                                    <label for="app_letter" class="control-label">
                                        Application letter
                                    </label>
                                    <div>
                                        <input required type="file" name="app_letter" id="app_letter"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                        </div>

                    </div>
                    <div class="modal-footer editFooter">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fa fa-close"></i>
                                Close
                            </button>
                            <button type="submit" id="createBtn" class="btn btn-primary">
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

    <div class="modal fade " id="renewModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">
                        Renewing documents
                    </h4>
                </div>
                <form novalidate action="" method="post"
                      enctype="multipart/form-data"
                      id="renewForm">

                    <div class="modal-body">
                        @include('layouts._loader')
                        <div class="edit-result">
                            <input type="hidden" id="id" name="id" value="0">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="district_report" class="control-label">
                                    District report
                                </label>
                                <div>
                                    <input required type="file" name="district_report" id="district_report"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="app_letter" class="control-label">
                                    Application letter
                                </label>
                                <div>
                                    <input required type="file" name="app_letter" id="app_letter"
                                           class="form-control">
                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="modal-footer editFooter">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fa fa-close"></i>
                                Close
                            </button>
                            <button type="submit" id="saveRenewBtn" class="btn btn-primary">
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

    @if(\Illuminate\Support\Facades\Auth::user()->role=='normal')
        <div class="modal fade" id="addDocsModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">
                            Add Documents
                        </h4>
                    </div>
                    <form novalidate action="" enctype="multipart/form-data" method="post"
                          id="saveDocsForm">

                        <div class="modal-body">
                            @include('layouts._loader')
                            <div class="edit-result">
                                <input type="hidden" id="id" name="id" value="0">
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="names" class="control-label">Name</label>
                                                    <input type="text" disabled id="names" class="form-control"
                                                           placeholder="Full name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="idNumber" class="control-label">Id Number</label>
                                                    <input type="text" disabled id="idNumber" class="form-control"
                                                           placeholder="National Id">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phoneNumberId" class="control-label">Phone
                                                        Number</label>
                                                    <input type="text" disabled id="phoneNumberId" class="form-control"
                                                           placeholder="Phone number">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="emailId" class="control-label">Email</label>
                                                    <input type="email" disabled id="emailId" class="form-control"
                                                           placeholder="Email address">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="applicationType" class="control-label">Application
                                                        type</label>
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
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                    Close
                                </button>
                                <button type="submit" id="createBtn" class="btn btn-primary">
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



    @if(\Illuminate\Support\Facades\Auth::user()->role=='admin')
        <div class="modal fade myModal" id="licenceModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">
                            Manage License
                        </h4>
                    </div>
                    <form novalidate action="" method="post" id="submitLicenceDateForm" class="form-horizontal">
                        <div class="modal-body">
                            @include('layouts._loader')
                            <div class="edit-result">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="license_issued_at" class="control-label col-md-3">
                                        Licence Issued At
                                    </label>
                                    <div class="col-md-9">
                                        <input required type="text" name="license_issued_at" id="license_issued_at"
                                               class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="license_expires_at" class="control-label col-md-3">
                                        Licence Expires At
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" required name="license_expires_at" id="license_expires_at"
                                               class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer editFooter">
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">
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
@endsection

@section('scripts')
    <script src="{{ asset('bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script src="{{ asset('js/facilties.js') }}"></script>
@endsection
