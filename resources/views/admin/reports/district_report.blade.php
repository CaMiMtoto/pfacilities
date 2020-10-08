@extends('layouts.app')
@section('title','District report')
@section('content')
    <section class="content">
        <div class="box box-primary flat">
            <div class="box-header with-border">
                <h4 class="box-title">Reports</h4>
                <div class="box-tools pull-right">
                    <button class="btn btn-primary btn-sm" id="addButton">
                        <i class="fa fa-plus"></i>
                        Add Report
                    </button>
                </div>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Facility</th>
                        <th>Title</th>
                        <th>Document</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $item)
                        <tr>
                            <td>{{ $item->facility->name }}</td>
                            <td>{{ $item->title }}</td>
                            <td>
                                <div class="btn-group flat">
                                    <button class="btn btn-primary btn-sm"
                                            data-url="{{ route('users.destroy',$item->id) }}">
                                        <i class="fa fa-download"></i>
                                        Download
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
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
                        District report
                    </h4>
                </div>
                <form enctype="multipart/form-data" class="form-horizontal" autocomplete="off"
                      action="{{ route('districts.reports.store') }}"
                      method="post">

                    <div class="modal-body">
                        @include('layouts._loader')
                        <div class="edit-result">
                            <input type="hidden" id="id" name="id" value="0">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="facility_id" class="col-sm-3 control-label">Facility</label>
                                <div class="col-sm-9">
                                    <select name="facility_id" class="form-control" id="facility_id">
                                        <option value=""></option>
                                        @foreach($facilities as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title" class="col-sm-3 control-label">Title</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"
                                           name="title" id="title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="document" class="col-sm-3 control-label">Document</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control"
                                           name="document" id="document">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer editFooter">
                        <div class="btn-group btn-group-sm">
                            <button type="submit" id="createBtn" class="btn btn-primary">
                                <i class="fa fa-check-circle"></i>
                                Save changes
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <i class="fa fa-close"></i>
                                Close
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@stop

@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest(App\Http\Requests\ValidateDistrictReport::class) !!}

    <script>
        $(function () {
            $('.nav-district-report').addClass('active');

            $('#addButton').on('click', function () {
                $('#addModal').modal();
                $('#id').val(0);
                $('#submitForm')[0].reset(); //resetting form
            });
        });
    </script>
@endsection
