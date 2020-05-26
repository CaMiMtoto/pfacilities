<div>
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
                        <input {{ $facility->license_status=='new'?'selected':'' }}  type="radio" name="license_status"
                               id="inlineRadio1"
                               class="license_status" value="new">
                        I don't have license
                    </label>
                    <label class="radio-inline">
                        <input {{ $facility->license_status=='licensed'?'selected':'' }} type="radio"
                               name="license_status" id="inlineRadio2"
                               class="license_status" value="licensed">
                        I have a valid licence
                    </label>
                    <label class="radio-inline">
                        <input {{ $facility->license_status=='renew'?'selected':'' }}  type="radio"
                               name="license_status" id="inlineRadio3"
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
                            <input value="{{ $facility->name }}" required minlength="2" maxlength="50" type="text"
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
                                        {{ $facility->catrgory_id==$cat->id?'selected':'' }} value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <label for="ref_number" class="control-label">Facility Id (HMIS)</label>
                        <div>
                            <input value="{{ $facility->ref_number }}" class="form-control" placeholder="Facility Id"
                                   type="text"
                                   name="ref_number"
                                   id="ref_number"/>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="province_id" class="control-label">Province</label>
                        <div>
                            <select class="form-control" required name="province_id"
                                    id="province_id">
                                <option value="">Select province</option>
                                @foreach($provinces as $province)
                                    <option
                                        {{ $facility->province_id==$province->id?'selected':'' }}
                                        value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

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
                    <div class="form-group form-group-sm">
                        <br>
                        <button style="display: flex;justify-content: space-between;" class="btn btn-info btn-block"
                                type="button" data-toggle="collapse" data-target="#collapseExample"
                                aria-expanded="false" aria-controls="collapseExample">
                            <span>Choose all applied services</span>
                            <i class="pull-right fa fa-chevron-down"></i>
                        </button>
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
                                                    <input value="{{ $service->id }}" name="service_id[]"
                                                           id="service_id{{ $service->id }}"
                                                           type="checkbox"> {{ $service->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
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
            </div>

        </div>
    </div>
</div>
