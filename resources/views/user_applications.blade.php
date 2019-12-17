@extends('layouts.app')
@section('title','Applications')
@section('content')
    <section class="content">

        <div class="box box-primary flat">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-file-archive-o"></i>
                    Applications
                </h3>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Submitted At</th>
                        <th>Applicant</th>
                        <th>Phone Number</th>
                        <th>Application Type</th>
                        <th>Status</th>
                        <th>Comment</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($userApps as $app)
                        <tr>
                            <td>{{ $app->created_at }}</td>
                            <td>{{ $app->user->name }}</td>
                            <td>{{ $app->user->phone }}</td>
                            <td>{{ $app->applicationType->name }}</td>
                            <td>{{ $app->status }}</td>
                            <td>{{ $app->comment }}</td>
                            <td>
                                @if(Auth::user()->role=='admin' || Auth::user()->role=='verifier' || Auth::user()->role=='inspector')
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('applicationComments',[$app->id]) }}" class="btn btn-default btn-sm">
                                            <i class="fa fa-comment"></i>
                                            Comments
                                        </a>
                                        <button class="btn btn-info btn-sm js-review"
                                                data-update-url="{{ route('updateReview',$app->id) }}"
                                                data-url="{{ route('reviewDocs',['userApplication'=>$app->id,'applicationType'=>$app->application_type_id,'user'=>$app->user_id]) }}">
                                            Review
                                        </button>
                                    </div>
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



    <div class="modal fade" id="docsModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">
                        Review documents
                    </h4>
                </div>
                <form novalidate action="" class="form-horizontal" method="post" id="submitReviewForm">

                    <div class="modal-body">
                        @include('layouts._loader')
                        <div class="edit-result">
                            <input type="hidden" id="id" name="id" value="0">
                            {{ csrf_field() }}
                            <div id="docsResults"></div>
                            {{--                            <div class="clearfix"></div>--}}
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
            $('.nav-applications').addClass('active');
            // $('#form').validate();

            $('.js-review').on('click', function () {
                var url = $(this).attr('data-url');
                $('#submitReviewForm').attr('action', $(this).attr('data-update-url'));
                $('#docsModal').modal();
                showLoader();
                $.ajax({
                    'url': url,
                    'method': 'get',
                    'type': 'text/html'
                }).done(function (data) {
                    hideLoader();
                    $('#docsResults').html(data);
                });
            });

            $('#submitReviewForm').on('submit',function (e) {
               e.preventDefault();
               var form=$(this);
               if(form.valid()){
                   $('#createBtn').button('loading');
                   $.post(form.attr('action'),form.serialize())
                       .done(function (data) {
                        location.reload();
                       });
               }
            });


        });


    </script>
@endsection
