@extends('layouts.app')
@section('title','Users')
@section('content')
    <section class="content">
        <h4> Manage users</h4>
        <div class="box box-primary flat">
            <div class="box-header with-border">
                <div class="col-md-6">
                    <div class="box-title">
                        <form action="" class="" autocomplete="off">
                            <div class="input-group">
                                <input type="search" name="q" id="query" class="form-control flat"
                                       value="{{ request('q') }}"
                                       placeholder="Search .....">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary flat" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                             </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary float-right" id="addButton">
                            <i class="fa fa-plus"></i>
                            Add New
                        </button>
                    </div>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Position</th>
                        <th scope="col">Role</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->position==null)
                                    <span class="label label-info">Applicant</span>
                                @else
                                    <span class="label label-default"> {{ ucwords($user->position->name) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($user->role=='normal')
                                    <span class="label label-info">Applicant</span>
                                @else
                                    <span class="label label-default"> {{ ucwords($user->role) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group flat">
                                    <button class="btn flat btn-default js-edit"
                                            data-url="{{ route('users.show',$user->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button class="btn flat btn-danger js-delete"
                                            data-url="{{ route('users.destroy',$user->id) }}">
                                        <i class="fa fa-trash"></i>
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
                {{ $users->links() }}
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
                        User
                    </h4>
                </div>
                <form novalidate class="form-horizontal" autocomplete="off" action="{{ route('users.store') }}"
                      method="post">

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
                                <label for="email" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input required type="email" class="form-control"
                                           name="email" id="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="position" class="col-sm-3 control-label">Position</label>
                                <div class="col-sm-9">
                                    <select name="position" class="form-control" id="position">
                                        <option value=""></option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}">{{$position->name}}
                                                -{{ $position->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="role" class="col-sm-3 control-label">Role</label>
                                <div class="col-sm-9">
                                    <select name="role" class="form-control" required id="role">
                                        <option value=""></option>
                                        @foreach(\App\Roles::roles() as $role)
                                            <option value="{{$role}}">{{strtoupper($role)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control"
                                           name="password" id="password">
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
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

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest(App\Http\Requests\ValidateUser::class) !!}

    <script>
        $(function () {
            $('.nav-users').addClass('active');

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
                        $('#email').val(data.email);
                        $('#role').val(data.role);
                        $('#position').val(data.position_id);
                    });
            });

        });
    </script>
@endsection
