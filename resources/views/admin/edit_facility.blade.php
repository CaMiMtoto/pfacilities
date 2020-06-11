@extends('layouts.app')
@section('title',"Edit $facility->name Facility")
@section('styles')
    {{--    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">--}}
@endsection
@section('content')
    <section class="content">
        @include('includes._alerts')
        <div class="box box-primary flat">
            <div class="box-header with-border">
                <h4 class="box-title">Edit facility</h4>
                <div class="box-tools">
                    <a href="{{ auth()->user()->role=='normal'? route('facilities'):route('adminFacilities') }}"
                       class="btn btn-link btn-box-tool">
                        <i class="fa fa-arrow-circle-left"></i>
                        Back to facilities
                    </a>
                </div>
            </div>

            <form novalidate action="{{ route('facilities.store') }}" method="post"
                  enctype="multipart/form-data"
                  id="saveForm">

                <div class="box-body">
                    @include('layouts._loader')
                    <div class="edit-result">
                        <input type="hidden" id="id" name="id" value="{{ $facility->id }}">
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
                                                   {{ $facility->license_status=='new'?'checked':'' }}
                                                   class="license_status" value="new">
                                            I don't have license
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="license_status" id="inlineRadio2"
                                                   {{ $facility->license_status=='licensed'?'checked':'' }}
                                                   class="license_status" value="licensed">
                                            I have a valid licence
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="license_status" id="inlineRadio3"
                                                   {{ $facility->license_status=='renew'?'checked':'' }}
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
                                        <label for="license_issued_at" class="control-label">License Issued At</label>
                                        <div>
                                            <input required type="text" autocomplete="off" name="license_issued_at"
                                                   id="license_issued_at"
                                                   value="{{ $facility->license_expires_at? $facility->license_expires_at->format('Y-m-d'):'' }}"
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
                                        <label for="license_expires_at" class="control-label">License Expires At</label>
                                        <div>
                                            <input required type="text" autocomplete="off" name="license_expires_at"
                                                   id="license_expires_at"
                                                   value="{{$facility->license_expires_at? $facility->license_expires_at->format('Y-m-d'):'' }}"
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
                                                <input required value="{{ $facility->name }}" minlength="2"
                                                       maxlength="50" type="text"
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
                                                        <option
                                                            {{ $facility->category_id==$cat->id?'selected':'' }} value="{{ $cat->id }}">{{ $cat->name }}</option>
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
                                                       value="{{ $facility->ref_number }}"
                                                       name="ref_number"
                                                       id="ref_number"/>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-sm">
                                            <label for="ref_number" class="control-label">Select</label>
                                            <button
                                                style="display: flex;justify-content: space-between;background-image: none!important;background-color: white !important;"
                                                class="btn btn-default btn-block form-control" type="button"
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
                                                            {{ $facility->sector->district->province_id==$province->id?'selected':'' }}
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
                                                <select class="form-control" name="cell_id"
                                                        id="cell_id">
                                                    <option value="">Select cell</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <div class="collapse in" id="collapseExample">
                                            <div class="well">
                                                <div class="row">
                                                    <div class="form-group form-group-sm">
                                                        @foreach($services as $service)
                                                            <div class="col-md-6">
                                                                <div class="checkbox">
                                                                    <label for="service_id{{ $service->id }}">
                                                                        <input value="{{ $service->id }}"
                                                                               name="service_id[]"
                                                                               {{ in_array($service->id,$facility_services->toArray()) ?'checked':'' }}
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
                                                                        <textarea required type="text"
                                                                                  name="other_services"
                                                                                  id="other_services"
                                                                                  placeholder="Please provide other services if not provided above"
                                                                                  class="form-control">{{ $facility->other_services }}</textarea>
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
                                            <input type="radio"
                                                   {{ $facility->owner=='Facility owner'?'checked':'' }}
                                                   name="owner" id="owner1" value="Facility owner">
                                            Facility owner
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="owner" id="owner2"
                                                   {{ $facility->owner=='Employee'?'checked':'' }}
                                                   value="Employee">
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
                                                       value="{{ $facility->manager_name }}"
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
                                                       value="{{ $facility->nationalId }}"
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
                                                       value="{{ $facility->email }}"
                                                       placeholder="Your email address" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-sm">
                                            <label for="phone" class="control-label">Phone</label>
                                            <div>
                                                <input required type="tel" name="phone" id="phone"
                                                       value="{{ $facility->phone }}"
                                                       placeholder="Your phone number" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-sm">
                                            <label for="position" class="control-label">Position</label>
                                            <div>
                                                <input type="text" required name="position" id="position"
                                                       value="{{ $facility->position }}"
                                                       placeholder="Your position" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <div>
                        <a href="{{ auth()->user()->role=='normal'? route('facilities'):route('adminFacilities') }}" class="btn btn-link closeForm pull-left"
                           data-dismiss="modal">
                            <i class="fa fa-arrow-circle-left"></i>
                            Back to facilities
                        </a>
                        <button type="submit" id="createBtn" class="btn btn-primary pull-right">
                            <i class="fa fa-check-circle"></i>
                            Update facility
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <input type="hidden" value="{{ $facility->sector_id }}" id="sector">
        <input type="hidden" value="{{ $facility->sector->district_id }}" id="district">
        <input type="hidden" value="{{ $facility->license_status }}" id="license_status">
    </section>
@stop

@section('scripts')
    {{--    <script src="{{ asset('bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>--}}
    <script src="{{ asset('js/facilties.js') }}"></script>
    <script>
        $(function () {
            let districtId = $('#district').val();
            loadDistricts($('#province_id').val(), districtId);
            loadSector(districtId, $('#sector').val());
            changeLicenseStatus($('#license_status').val())
        });
    </script>
@endsection
