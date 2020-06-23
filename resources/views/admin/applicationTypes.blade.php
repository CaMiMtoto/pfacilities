@extends('layouts.app')
@section('title','Application Types')
@section('content')
    <section class="content">
        @include('includes._alerts')
        <div class="box box-primary flat">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Application Types
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
            <div class="box-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th>Required Documents</th>
                        <th style="width: 15%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($applicationTypes as $appType)
                        <tr>
                            <td>{{ $appType->name }}</td>
                            <td>

                                <ul>
                                    @forelse ($appType->applicationTypeDocuments as $document)
                                        <li>{{ $document->document->name }}</li>
                                    @empty
                                        <p>
                                            <span class="label label-info">No documents</span>
                                        </p>
                                    @endforelse
                                </ul>
                            </td>
                            <td>
                                <a href="{{ route('app-types.edit',$appType->id) }}" class="btn btn-primary">
                                    <i class="fa fa-edit"></i>
                                    Edit
                                </a>
                                <button data-url="{{ route('app-types.destroy',$appType->id) }}"
                                        class="btn btn-danger js-delete">
                                    <i class="fa fa-trash"></i>
                                    Delete
                                </button>
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
                        <div class="edit-result">
                            <input type="hidden" id="id" name="id" value="0">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" required id="name" class="form-control"
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
