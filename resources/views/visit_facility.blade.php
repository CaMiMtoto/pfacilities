@extends('layouts.app')
@section('title','Facilities')
@section('styles')
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endsection
@section('content')



    <section class="content">
        Facility visits
        <div class="box box-primary flat">
            <div class="box-header with-border">
                <h3 class="box-title">
                    {{ $facility->name }}
                </h3>
                <div class="box-tools pull-right">
                    @if(Auth::user()->role=='admin')
                        <button class="btn flat btn-primary js-visit btn-sm"
                                data-url="{{ route('facilities.visit',[$facility->id]) }}">
                            Add New Visit
                        </button>
                    @endif
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Visitor</th>
                        <th>Purpose</th>
                        <th>Report</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($facility->facilityVisits()->get() as $visit)
                        <tr>
                            <td>{{ $visit->date }}</td>
                            <td>{{ $visit->visitor }}</td>
                            <td>{{ $visit->purpose }}</td>
                            <td>
                                <a href="{{ route('visits.summary',[$visit->id]) }}" target="_blank"
                                   class="btn btn-default btn">
                                    Summary
                                </a>
                                @if(\Illuminate\Support\Facades\Auth::user()->role !='normal')
                                    @if(!$visit->document)
                                        <button
                                            data-url="{{ route('facilities.uploadDoc',[$visit->id]) }}"
                                            class="btn btn-info btn js-upload">
                                            <i class="fa fa-file"></i>
                                        </button>
                                    @else
                                        <button
                                            data-url=""
                                            class="btn btn-success btn">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    @endif
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

    <div class="modal fade myModal" id="visitModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">
                        Visit facility
                    </h4>
                </div>
                <form novalidate action="" autocomplete="off" method="post" id="saveVisitForm" class="form-horizontal">
                    <div class="modal-body">
                        @include('layouts._loader')
                        <div class="edit-result">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="date" class="control-label col-md-3">
                                    Date
                                </label>
                                <div class="col-md-9">
                                    <input required type="text" name="date" id="date"
                                           class="form-control datepicker">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="visitor" class="control-label col-md-3">
                                    Visitor Name
                                </label>
                                <div class="col-md-9">
                                    <input required type="text" name="visitor" id="visitor"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="purpose" class="control-label col-md-3">
                                    Purpose
                                </label>
                                <div class="col-md-9">
                                    <input required type="text" name="purpose" id="purpose"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="comment" class="control-label col-md-3">
                                    Comment
                                </label>
                                <div class="col-md-9">
                                        <textarea required name="comment" id="comment"
                                                  class="form-control "></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="recommendations" class="control-label col-md-3">
                                    Recommendations
                                </label>
                                <div class="col-md-9">
                                        <textarea required name="recommendations" id="recommendations"
                                                  class="form-control "></textarea>
                                </div>
                            </div>

                            {{--                            <div class="form-group">--}}
                            {{--                                <label for="document" class="control-label col-md-3">--}}
                            {{--                                    Document--}}
                            {{--                                </label>--}}
                            {{--                                <div class="col-md-9">--}}
                            {{--                                    <input type="file" name="document" id="document"--}}
                            {{--                                           class="form-control ">--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                        </div>
                    </div>
                    <div class="modal-footer editFooter">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fa fa-close"></i>
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary" id="saveVisitBtn">
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

    <div class="modal fade myModal" id="visitDocModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">
                        Facility visit document
                    </h4>
                </div>
                <form novalidate action="" method="post" id="saveVisitDocForm" autocomplete="off"
                      class="form-horizontal">
                    <div class="modal-body">
                        @include('layouts._loader')
                        <div class="edit-result">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="documentFo" class="control-label col-md-3">
                                    Document
                                </label>
                                <div class="col-md-9">
                                    <input type="file" required name="document" id="documentFo"
                                           class="form-control ">
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
                            <button type="submit" class="btn btn-primary" id="saveVisitDocBtn">
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
    <script src="{{ asset('bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script>
        $(function () {

            $('#saveVisitForm').validate();
            $('#saveVisitDocForm').validate();

            $('#recommendations').wysihtml5();

            $('.js-visit').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('data-url');
                var modal = $('#visitModal');
                modal.modal();

                $('#saveVisitForm').on('submit', function (event) {
                    event.preventDefault();
                    var form = $(this);
                    var btn = $('#saveVisitBtn');
                    if (!form.valid()) return false;
                    var formData = new FormData(this);
                    btn.button('loading');

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        success: function (data) {
                            location.reload();
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    }).fail(function () {
                        btn.button('reset');
                    });

                });
            });


            $('.js-upload').on('click', function () {
                var url = $(this).attr('data-url');
                $('#visitDocModal').modal();
                $('#saveVisitDocForm').on('submit', function (e) {
                    e.preventDefault();
                    var form = $(this);
                    if (!form.valid()) return false;

                    var btn = $('#saveVisitDocBtn');
                    var formData = new FormData(this);
                    btn.button('loading');
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        success: function (data) {
                            location.reload();
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    }).fail(function () {
                        btn.button('reset');
                    });
                });
            });
        });
    </script>
@endsection
