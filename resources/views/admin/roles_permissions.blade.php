@extends('layouts.app')
@section('title','Permissions for '.$role->name)
@section('content')


    <section class="content">

        <div class="box box-primary flat">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Manage permissions
                </h3>
                <div class="box-tools pull-right">

                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <form action="{{route('updateRolePermissions',$role->id) }}" method="post">
                @csrf
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>
                                <span class="label label-default">{{$role->name}}</span>
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($permissions as $item)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input
                                                {{in_array($item->id,$role->permissions->pluck('id')->toArray())?'checked':''}}  name="permissions[]"
                                                value="{{$item->id}}" type="checkbox">
                                            {{$item->name}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-sm btn-primary">
                        <i class="fa fa-check-circle"></i>
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </section>


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
