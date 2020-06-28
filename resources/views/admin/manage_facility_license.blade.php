@extends('layouts.app')
@section('title','Manage license')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('includes._alerts')
                <div class="box box-primary flat">
                    <div class="box-header with-border">
                        <div class="col-md-4">
                            <h3 class="box-title">
                                Manage license
                            </h3>
                            <h5>
                                Facility: <strong>{{ $application->facility->name }}</strong>
                            </h5>
                            <h5>
                                Applicant: <strong>{{ $application->user->name }}</strong>
                            </h5>

                        </div>
                    </div>
                    <form action="{{ route('store.license',$application->id) }}" method="post"
                          class="form-horizontal" id="addForm">
                        @csrf
                        <input type="hidden" name="id" value="{{ $license->id??'' }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="reason">Reason:</label>
                                <div class="col-md-9">
                                    <input type="text"
                                           value="{{ $license->reason??'' }}"
                                           required name="reason" id="reason" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="body">Body:</label>
                                <div class="col-md-9">
                                    <textarea rows="6" required name="body" id="body"
                                              class="form-control">{{ $license->body??'' }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="signature"></label>
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        <label>
                                            <input
                                                {{ $license!=null &&$license->signed_at!=null?'checked':'' }}  name="signed"
                                                type="checkbox">
                                            <strong>Mark as signed</strong>
                                        </label>
                                    </div>
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
            $('.nav-applications').addClass('active');
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
