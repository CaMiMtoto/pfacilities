@extends('layouts.app')
@section('title','Services')
@section('content')
    <section class="content">

        <div class="box box-primary flat">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Manage services
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
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->description }}</td>
                            <td>
                                <div class="btn-group flat">
                                    <button class="btn flat btn-default js-edit"
                                            data-url="{{ route('services.show',$service->id) }}">
                                        Edit
                                    </button>
                                    <button class="btn flat btn-danger js-delete"
                                            data-url="{{ route('services.destroy',$service->id) }}">
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
                {{ $services->links() }}
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
                        Service
                    </h4>
                </div>
                <form novalidate class="form-horizontal" action="{{ route('services.store') }}" method="post"
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
                                <label for="description" class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea name="description" id="description" class="form-control" placeholder="Description"></textarea>
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
            $('.nav-services').addClass('active');

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
                        $('#description').val(data.description);
                    });
            });

        });
    </script>
@endsection
