@extends('layouts.app')
@section('title','Facilities')
@section('styles')
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endsection
@section('content')
    <section class="content">

        @include('includes._alerts')

        @if(Auth::user()->role=='admin')
            <a href="{{ route('summary') }}" class="btn btn-primary btn-sm">
                Summary
            </a>
            <div class="dropdown pull-right">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">
                    Filter facility By
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="?licensed=true">Licensed</a></li>
                    <li><a href="?expiring_soon=true">Expiring soon</a></li>
                    <li><a href="?expired=true">Expired</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
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

                <div class="box-tools">
                    <form action="" class="form-inline" autocomplete="off">
                        <input type="text" name="q" class="form-control form-control-sm" placeholder="Search.."/>
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
                        <th scope="col">Facility ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
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
                            <td>{{ $fac->manager_name }}</td>
                            <td>{{ $fac->phone }}</td>
                            <td>{{ $fac->license_issued_at!=null? $fac->license_issued_at->format('d/m/Y'):'Not set' }}</td>
                            <td>{{ $fac->license_expires_at!=null?$fac->license_expires_at->format('d/m/Y'):'Unknown' }}</td>
                            <td>
                                <?php
                                unset($daysRemain);
                                $color = 'black'; ?>
                                @if($fac->license_expires_at!=null)
                                    @php

                                        $daysRemain = $fac->license_expires_at->diffInDays($fac->license_issued_at);
                                        if ($daysRemain < 30)
                                            $color = 'red;font-weight:800;';
                                    @endphp
                                @endif
                                <span style="color: {{$color}}">{{ isset($daysRemain)? $daysRemain :'Unknown' }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm flat">
                                    @if(auth()->user()->role==\App\Roles::$ADMIN || auth()->user()->role==\App\Roles::$PHF)
                                        <a href="{{ route('facilities.edit',$fac->id) }}"
                                           class="btn flat btn-default btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
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
                    <button type="button" class="close closeForm" data-dismiss="modal" aria-label="Close">
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
                            <div class="box box-info flat">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        License information
                                    </h4>
                                </div>
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-sm">
                                            <label class="radio-inline">
                                                <input type="radio" name="license_status" id="inlineRadio1"
                                                       class="license_status" value="new">
                                                I don't have license
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="license_status" id="inlineRadio2"
                                                       class="license_status" value="licensed">
                                                I have a valid licence
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="license_status" id="inlineRadio3"
                                                       class="license_status" value="renew">
                                                My license expired
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group form-group-sm div-hide" id="app_letter_form">
                                            <label for="app_letter" class="control-label">
                                                Application letter
                                            </label>
                                            <div>
                                                <input required type="file" name="app_letter" id="app_letter"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group form-group-sm div-hide"
                                             id="license_issued_at_group">
                                            <label for="license_issued_at" class="control-label">License Issued
                                                At</label>
                                            <div>
                                                <input required type="tel" autocomplete="off" name="license_issued_at"
                                                       id="license_issued_at"
                                                       placeholder="" class="form-control datepicker">
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group form-group-sm div-hide"
                                             id="district_report_form">
                                            <label for="district_report" class="control-label">
                                                District report
                                            </label>
                                            <div>
                                                <input required type="file" name="district_report" id="district_report"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group form-group-sm div-hide"
                                             id="license_expires_at_group">
                                            <label for="license_expires_at" class="control-label">License Expires
                                                At</label>
                                            <div>
                                                <input required type="text" autocomplete="off" name="license_expires_at"
                                                       id="license_expires_at"
                                                       placeholder="" class="form-control datepicker">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-info flat">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        Facility information
                                    </h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm">
                                                <label for="name" class="control-label">Facility Name</label>
                                                <div>
                                                    <input required minlength="2" maxlength="50" type="text"
                                                           class="form-control" placeholder="Type facility name"
                                                           name="name" id="name">
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm">
                                                <label for="category_id" class="control-label">Facility Category</label>
                                                <div>
                                                    <select class="form-control" required name="category_id"
                                                            id="category_id">
                                                        <option value="">Select facility category</option>
                                                        @foreach($categories as $cat)
                                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group form-group-sm">
                                                <label for="ref_number" class="control-label">Facility Id (HMIS)</label>
                                                <div>
                                                    <input class="form-control"
                                                           {{ auth()->user()->role=='admin' || auth()->user()->role=='phf'?'':'disabled' }} placeholder="Facility Id"
                                                           type="text"
                                                           name="ref_number"
                                                           id="ref_number"/>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm">
                                                <label for="plot_number" class="control-label">Plot Number</label>
                                                <div>
                                                    <input required type="text" class="form-control" name="plot_number"
                                                           id="plot_number">
                                                </div>
                                            </div>

                                            <div class="form-group form-group-sm">
                                                <br>
                                                <button style="display: flex;justify-content: space-between;"
                                                        class="btn btn-info btn-block" type="button"
                                                        data-toggle="collapse" data-target="#collapseExample"
                                                        aria-expanded="false" aria-controls="collapseExample">
                                                    <span>Choose all applied services</span>
                                                    <i class="pull-right fa fa-chevron-down"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group form-group-sm">
                                                <label for="province_id" class="control-label">Province</label>
                                                <div>
                                                    <select class="form-control" required name="province_id"
                                                            id="province_id">
                                                        <option value="">Select province</option>
                                                        @foreach($provinces as $province)
                                                            <option
                                                                value="{{ $province->id }}">{{ $province->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm">
                                                <label for="district_id" class="control-label">District</label>
                                                <div>
                                                    <select class="form-control" required name="district_id"
                                                            id="district_id">
                                                        <option value="">Select district</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm">
                                                <label for="sector_id" class="control-label">Sector</label>
                                                <div>
                                                    <select class="form-control" required name="sector_id"
                                                            id="sector_id">
                                                        <option value="">Select sector</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm">
                                                <label for="cell_id" class="control-label">Cell</label>
                                                <div>
                                                    <select required class="form-control" name="cell_id"
                                                            id="cell_id">
                                                        <option value="">Select cell</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-12">

                                            <div class="collapse" id="collapseExample">
                                                <div class="well">
                                                    <div class="row">
                                                        <div class="form-group form-group-sm">
                                                            @foreach($services as $service)
                                                                <div class="col-md-6">
                                                                    <div class="checkbox">
                                                                        <label for="service_id{{ $service->id }}">
                                                                            <input value="{{ $service->id }}"
                                                                                   name="service_id[]"
                                                                                   id="service_id{{ $service->id }}"
                                                                                   type="checkbox"> {{ $service->name }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            <div class="col-md-6">
                                                                <div class="form-group form-group-sm">
                                                                    <label for="other_services" class="control-label">Other
                                                                        services</label>
                                                                    <div>
                                                                        <textarea type="text"
                                                                                  name="other_services"
                                                                                  id="other_services"
                                                                                  placeholder="Please provide other services if not provided above"
                                                                                  class="form-control"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="box box-info flat">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        Management information
                                    </h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>
                                                <strong>Registering as?</strong>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="owner" id="owner1" value="Facility owner">
                                                Facility owner
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="owner" id="owner2" value="Employee">
                                                Employee
                                            </label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm">
                                                <label for="manager_name" class="control-label">Names</label>
                                                <div>
                                                    <input required type="text" name="manager_name" id="manager_name"
                                                           placeholder="Full name" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm">
                                                <label for="nationalId" class="control-label">ID Number</label>
                                                <div>
                                                    <input required type="text" maxlength="16" name="nationalId"
                                                           id="nationalId"
                                                           placeholder="Id Number" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm">
                                                <label for="email" class="control-label">Email</label>
                                                <div>
                                                    <input required type="email" name="email" id="email"
                                                           placeholder="Your email address" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm">
                                                <label for="phone" class="control-label">Phone</label>
                                                <div>
                                                    <input required type="tel" name="phone" id="phone"
                                                           placeholder="Your phone number" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm">
                                                <label for="position" class="control-label">Position</label>
                                                <div>
                                                    <input type="text" required name="position" id="position"
                                                           placeholder="Your position" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 hide" id="ownersNames">
                                            <div class="form-group form-group-sm">
                                                <label for="facility_owner" class="control-label">Facility Owner's
                                                    Names</label>
                                                <div>
                                                    <input type="text" required name="facility_owner"
                                                           id="facility_owner"
                                                           placeholder="Facility owner" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer editFooter">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary closeForm" data-dismiss="modal">
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
                            <div class="form-group form-group-sm">
                                <label for="district_report" class="control-label">
                                    District report
                                </label>
                                <div>
                                    <input required type="file" name="district_report" id="district_report"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="form-group form-group-sm">
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
                                                <div class="form-group form-group-sm">
                                                    <label for="names" class="control-label">Name</label>
                                                    <input type="text" disabled id="names" class="form-control"
                                                           placeholder="Full name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-sm">
                                                    <label for="idNumber" class="control-label">Id Number</label>
                                                    <input type="text" disabled id="idNumber" class="form-control"
                                                           placeholder="National Id">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-sm">
                                                    <label for="phoneNumberId" class="control-label">Phone
                                                        Number</label>
                                                    <input type="text" disabled id="phoneNumberId" class="form-control"
                                                           placeholder="Phone number">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-sm">
                                                    <label for="emailId" class="control-label">Email</label>
                                                    <input type="email" disabled id="emailId" class="form-control"
                                                           placeholder="Email address">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group form-group-sm">
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
                                <div class="form-group form-group-sm">
                                    <label for="license_issued_at" class="control-label col-md-3">
                                        Licence Issued At
                                    </label>
                                    <div class="col-md-9">
                                        <input required type="text" name="license_issued_at" id="license_issued_at"
                                               class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
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
