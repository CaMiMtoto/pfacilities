@extends('layouts.app')
@section('title','Applications Appointments')
@section('content')
    <section class="content">

        <div class="box box-primary flat">
            <div class="box-header with-border">

                <h3 class="box-title">
                    <i class="fa fa-file-archive-o"></i>
                    Appointments
                </h3>

                <div class="box-tools">
                    <form autocomplete="off" action="" class="form-inline">
                        <div class="form-group form-group-sm">
                            <input type="search" class="form-control form-control-sm" name="q" placeholder="Search ..">
                        </div>
                        <button class="btn btn-primary btn-sm">Go</button>
                    </form>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>App Id</th>
                        <th>App Type</th>
                        <th>Facility Name</th>
                        <th>Applicant Name</th>
                        <th>Phone</th>
                        <th>Picking Date</th>
                        <th>Picked By</th>
                        <th>Picked At</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->userApplication->application_id }}</td>
                            <td>{{ $appointment->userApplication->applicationType->name }}</td>
                            <td>{{ $appointment->userApplication->facility->name }}</td>
                            <td>{{ $appointment->userApplication->user->name }}</td>
                            <td>{{ $appointment->userApplication->user->phone }}</td>
                            <td>{{ $appointment->picking_date }}</td>
                            <td>{{ $appointment->picked_by }}</td>
                            <td>{{ $appointment->picked_at }}</td>
                            <th>
                                <button
                                    data-url="{{ route('pickCertificate',$appointment->id) }}"
                                    class="btn btn-default btn-sm js-pick">
                                    Picking
                                </button>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                {{ $appointments->links() }}
            </div>
        </div>
    </section>



    <div class="modal fade" id="pick_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        Picking form
                    </h4>
                </div>
                <form action="" id="appointment-form" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="picked_by" class="control-label col-sm-3">Picked By</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="picked_by"
                                       id="picked_by">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nid" class="control-label col-sm-3">National ID/Phone</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="nid"
                                       id="nid">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment" class="control-label col-sm-3">Comment</label>
                            <div class="col-sm-9">
                                <textarea name="comment" id="comment" class="form-control"></textarea>
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


@endsection

@section('scripts')
    <script>
        $(function () {
            $('.nav-appointments').addClass('active');

            $('#appointment-form').validate();

            $('.js-pick').on('click', function () {
                var url = $(this).attr('data-url');
                $('#pick_modal').modal();
                $('#appointment-form').on('submit', function (e) {
                    var btn = $('#appointmentBtn');
                    e.preventDefault();

                    if (!$(this).valid()) return false;

                    btn.button('loading');
                    $.post(url, $(this).serialize())
                        .done(function (data) {
                            location.reload();
                        }).fail(function (error) {
                        btn.button('reset');
                    })
                });
            });


        });


    </script>
@endsection
