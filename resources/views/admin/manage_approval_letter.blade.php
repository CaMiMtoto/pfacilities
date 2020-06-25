@extends('layouts.app')
@section('title','Manage letter')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('includes._alerts')
                <div class="box box-primary flat">
                    <div class="box-header with-border">
                        <div class="col-md-4">
                            <h3 class="box-title">
                                Applications
                            </h3>
                            <h5>
                                Facility: <strong>{{ $application->facility->name }}</strong>
                            </h5>
                            <h5>
                                Applicant: <strong>{{ $application->user->name }}</strong>
                            </h5>

                        </div>
                    </div>
                    <form action="{{ route('store.approvalLetter',$application->id) }}" method="post"
                          enctype="multipart/form-data"
                          class="form-horizontal" id="addForm">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="ref_number">Reference Number:</label>
                                <div class="col-md-9">
                                    <input type="text" required name="ref_number" id="ref_number" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="reason">Reason:</label>
                                <div class="col-md-9">
                                    <input type="text" required name="reason" id="reason" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="body">Body:</label>
                                <div class="col-md-9">
                                    <textarea rows="6" required type="text" name="body" id="body"
                                              class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="done_by">Done By:</label>
                                <div class="col-md-9">
                                    <input type="text" required name="done_by" id="done_by" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="done_by_title">Done Title:</label>
                                <div class="col-md-9">
                                    <input type="text" required name="done_by_title" id="done_by_title"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="signature">Signature:</label>
                                <div class="col-md-9">
                                    <input type="file" required name="signature" id="signature" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="signature">Carbon copy:</label>
                                <div class="col-md-9">
                                    <input type="text" required name="carbonCopies[]" placeholder="CC"
                                           class="form-control"> <br>
                                    <input type="text" name="carbonCopies[]" placeholder="CC" class="form-control"> <br>
                                    <input type="text" name="carbonCopies[]" placeholder="CC" class="form-control"> <br>
                                    <input type="text" name="carbonCopies[]" placeholder="CC" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <button id="saveBtn" class="btn btn-primary">
                                        <span class="fa fa-check-circle"></span>
                                        Save changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('#addForm').validate();
            $('#addForm').on('submit', function (e) {
                e.preventDefault();
                var form = $(this);
                if (form.valid()) {
                    $('#saveBtn').button('loading');
                    e.target.submit();
                }
            });
        });
    </script>
@endsection
