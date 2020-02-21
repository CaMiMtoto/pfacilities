@extends('layouts.app')
@section('title','History')
@section('content')
    <section class="content">

        <div class="box box-default flat">
            <div class="box-header with-border">
               {{-- <p class="box-title">
                    Application History
                </p>--}}

                <p>
                    <strong>App ID</strong> :{{ $application->application_id }}
                </p>
                <p><strong>Facility Name</strong> :{{ $application->facility->name }}</p>
                <p><strong>Phone Number</strong> :{{ $application->user->phone }}</p>

                <div class="box-tools">
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Date Time</th>
                        <th>User</th>
                        <th>Shared Status</th>
                        <th>Shared To</th>
                        <th>Comment</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($application->history as $history)
                        <tr>
                            <td>{{ $history->created_at }}</td>
                            <td>{{ $history->sharedBy->name }}</td>
                            <td>{{ $history->status }}</td>
                            <td>{{ $history->position->name }}</td>
                            <td>{{ $history->comment }}</td>

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


@endsection

@section('scripts')
    {{--    <script src="{{ asset('bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>--}}
    <script>
        $(function () {
            $('.nav-applications').addClass('active');
        });


    </script>
@endsection
