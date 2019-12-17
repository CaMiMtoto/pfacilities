@extends('layouts.app')
@section('title','Renew facility document')
@section('content')



    <section class="content">
        Facility licence renew
        <div class="box box-primary flat">
            <div class="box-header with-border">
                <h3 class="box-title">
                    {{ $facility->name }}
                </h3>
                <div class="box-tools pull-right">
                    @if(Auth::user()->role=='admin')
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
                        <th>App Letter</th>
                        <th>District letter</th>
                        <th>Status</th>
                        <th>Comment</th>
                        <th>Issued At</th>
                        <th>Expires At</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($facility->facilityDocumentsRenews()->get() as $renew)
                        <tr>
                            <td>{{ $renew->created_at }}</td>
                            <td>
                                <a
                                    target="_blank"
                                    href="/view/document?path=storage/files/facilitydocs{{$renew->app_letter}}">
                                    View Document
                                </a>
                            </td>
                            <td>
                                <a
                                    target="_blank"
                                    href="/view/document?path=storage/files/facilitydocs{{$renew->district_report}}">
                                    View Document
                                </a>
                            </td>
                            <td>{{ $renew->status }}</td>
                            <td>{{ $renew->comment }}</td>
                            <td>{{ $renew->issued_at->format('d/m/Y') }}</td>
                            <td>{{ $renew->expires_at->format('d/m/Y') }}</td>
                            <td>
                                @if(\Illuminate\Support\Facades\Auth::user()->role=='admin')
                                    <button
                                        data-url="{{ route('updateRenew',[$renew->id]) }}"
                                        class="btn btn-default btn js-confirm">
                                        Confirm
                                    </button>
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

    <div class="modal fade myModal" id="confirmModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">
                        Confirm licence
                    </h4>
                </div>
                <form novalidate action="" autocomplete="off" method="post" id="confirmForm" class="form-horizontal">
                    <div class="modal-body">
                        @include('layouts._loader')
                        <div class="edit-result">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="status" class="control-label col-md-3">
                                    Decision
                                </label>
                                <div class="col-md-9">
                                    <select name="status" required class="form-control" id="status">
                                        <option value=""></option>
                                        <option value="pending">Pending</option>
                                        <option value="renewed">Renewed</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div id="hideDates" class="div-hide">
                                <div class="form-group">
                                    <label for="issued_at" class="control-label col-md-3">
                                        Issued At
                                    </label>
                                    <div class="col-md-9">
                                        <input name="issued_at" id="issued_at" class="form-control datepicker"
                                               required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="expires_at" class="control-label col-md-3">
                                        Expires At
                                    </label>
                                    <div class="col-md-9">
                                        <input name="expires_at" id="expires_at" class="form-control datepicker"
                                               required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="comment" class="control-label col-md-3">
                                    Comment
                                </label>
                                <div class="col-md-9">
                                    <textarea name="comment" id="comment" class="form-control" required></textarea>
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
                            <button type="submit" class="btn btn-primary" id="createBtn">
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

            $('#confirmForm').validate();

            $('#status').on('change', function () {
                var element = $(this);
                if (element.val() !== 'renewed') {
                    $('#hideDates').addClass('div-hide');
                } else {
                    $('#hideDates').removeClass('div-hide');
                }
            });


            $('.js-confirm').on('click', function () {
                var url = $(this).attr('data-url');
                $('#confirmModal').modal();
                $('#confirmForm').on('submit', function (e) {
                    e.preventDefault();
                    var form = $(this);
                    if (!form.valid()) return false;

                    var btn = $('#createBtn');
                    btn.button('loading');
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: form.serialize(),
                        success: function (data) {
                            location.reload();
                        }
                    }).fail(function () {
                        btn.button('reset');
                    });
                });
            });
        });
    </script>
@endsection
