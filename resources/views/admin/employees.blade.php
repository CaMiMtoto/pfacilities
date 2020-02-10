@extends('layouts.app')
@section('title','Employees')
@section('content')
    <section class="content">

        <div class="box box-primary flat">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Manage Employees
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-primary  btn-sm float-right" id="addButton">
                        <i class="fa fa-plus"></i>
                        Add New
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Qualification</th>
                        <th>NID</th>
                        <th>Facility</th>
                        <th>Position</th>
                        <th>Hire Date</th>
                        <th>Contract End</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ $employee->qualification }}</td>
                            <td>{{ $employee->nid }}</td>
                            <td>{{ $employee->facility->name }}</td>
                            <td>{{ $employee->position->name }}</td>
                            <td>{{ $employee->hired_date}}</td>
                            <td>{{ $employee->contract_end}}</td>
                            <td>
                                <div class="btn-group flat">
                                    <button class="btn flat btn-default js-edit"
                                            data-url="{{ route('employees.show',$employee->id) }}">
                                        Edit
                                    </button>
                                    <button class="btn flat btn-danger js-delete"
                                            data-url="{{ route('employees.destroy',$employee->id) }}">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                {{ $employees->links() }}
            </div>
        </div>
    </section>

    <div class="modal fade myModal" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">
                        Employee
                    </h4>
                </div>
                <form novalidate class="form-horizontal" action="{{ route('employees.store') }}" method="post"
                      id="submitForm">

                    <div class="modal-body">
                        @include('layouts._loader')
                        <div class="edit-result">
                            <input type="hidden" id="id" name="id" value="0">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-9">
                                    <input required minlength="2" maxlength="50" type="text" class="form-control"
                                           name="name" id="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-sm-3 control-label">Phone</label>
                                <div class="col-sm-9">
                                    <input placeholder="Phone Number" required minlength="2" maxlength="50" type="text"
                                           class="form-control"
                                           name="phone" id="phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nid" class="col-sm-3 control-label">NID</label>
                                <div class="col-sm-9">
                                    <input required minlength="2" placeholder="NID" maxlength="50" type="text"
                                           class="form-control"
                                           name="nid" id="nid">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="position_id" class="col-sm-3 control-label">Position</label>
                                <div class="col-sm-9">
                                    <select required class="form-control" name="position_id" id="position_id">
                                        <option value=""></option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="facility_id" class="col-sm-3 control-label">Facility</label>
                                <div class="col-sm-9">
                                    <select required class="form-control" name="facility_id" id="facility_id">
                                        <option value=""></option>
                                        @foreach($facilities as $fac)
                                            <option value="{{ $fac->id }}">{{ $fac->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="license_number" class="col-sm-3 control-label">License Number</label>
                                <div class="col-sm-9">
                                    <input required minlength="2" placeholder="License number" maxlength="50"
                                           type="text" class="form-control"
                                           name="license_number" id="license_number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="qualification" class="col-sm-3 control-label">Qualification</label>
                                <div class="col-sm-9">
                                    <input required minlength="2" placeholder="Qualification" maxlength="50" type="text"
                                           class="form-control"
                                           name="qualification" id="qualification">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hired_date" class="col-sm-3 control-label">Hired Date</label>
                                <div class="col-sm-9">
                                    <input required placeholder="Hired Date" maxlength="50" type="text"
                                           class="form-control datepicker" name="hired_date" id="hired_date">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contract_end" class="col-sm-3 control-label">Contract End</label>
                                <div class="col-sm-9">
                                    <input required placeholder="Contract End" maxlength="50" type="text"
                                           class="form-control datepicker" name="contract_end" id="contract_end">
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

@endsection

@section('scripts')
    <script>
        $(function () {
            $('.nav-emp-positions').addClass('active');

            $('#addButton').on('click', function () {
                $('#addModal').modal();
                $('#id').val(0);
                $('#submitForm')[0].reset(); //resetting form
            });


            $('.js-edit').on('click', function () {
                var url = $(this).attr('data-url');
                $('#addModal').modal();
                showLoader();
                $.getJSON(url)
                    .done(function (data) {
                        hideLoader();
                        $('#id').val(data.id);
                        $('#name').val(data.name);
                        $('#phone').val(data.phone);
                        $('#nid').val(data.nid);
                        $('#license_number').val(data.license_number);
                        $('#qualification').val(data.qualification);
                        $('#position_id').val(data.position_id);
                        $('#facility_id').val(data.facility_id);
                        $('#hired_date').val(data.hired_date);
                        $('#contract_end').val(data.contract_end);
                    });
            });

        });
    </script>
@endsection
