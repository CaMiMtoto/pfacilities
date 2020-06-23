@extends('layouts.app')
@section('title','Edit Application Type')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('includes._alerts')
                <div class="box box-primary flat">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Edit Application Type
                            <strong>
                                <small>( {{ $type->name }} )</small>
                            </strong>

                        </h3>
                        <div class="box-tools pull-right">

                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <form action="{{ route('app-types.update',$type->id) }}" method="post" class="form-horizontal">
                        <div class="box-body">
                            <div class="edit-result">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" value="{{ $type->name }}" required id="name" class="form-control"
                                               placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Documents</label>
                                    <div class="col-sm-9">
                                        @foreach($documents as $doc)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input name="documents[]" id="documents{{ $doc->id }}"
                                                                   {{ in_array($doc->id,$applicationTypeDocuments->toArray()) ?'checked':'' }}
                                                                   value="{{ $doc->id }}" type="checkbox">
                                                            {{ $doc->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                          <div class="form-group">
                             <div class="col-sm-9 col-sm-offset-3">
                                 <button class="btn btn-primary">Update application type</button>
                             </div>
                          </div>
                        </div>
                    </form>

                </div>
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
                        Application type
                    </h4>
                </div>
                <form novalidate class="form-horizontal" action="{{ route('app-types.store') }}" method="post"
                      id="submitForm">

                    <div class="modal-body">
                        @include('layouts._loader')

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
            $('.nav-categories').addClass('active');

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
                    });
            });

        });
    </script>
@endsection
