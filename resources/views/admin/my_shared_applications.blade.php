@extends('layouts.app')
@section('title','Applications')
@section('content')
    <section class="content">
        @include('includes._alerts')
        <div class="box box-primary flat">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-file-archive-o"></i>
                    Shared Applications
                </h3>

                <div class="box-tools">

                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                @if(count($applications)==0)
                    <div class="alert alert-info">
                        <h4>Nothing found</h4>
                    </div>
                @else
                    <table class="table">

                        <thead>
                        <tr>
                            <th>Shared At</th>
                            <th>Facility</th>
                            <th>Shared By</th>
                            <th>Applicant</th>
                            <th>Application Type</th>
                            <th>Status</th>
                            <th>Comment</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applications as $app)
                            @if($app->userApplication->shared())
                                @continue(true)
                            @endif
                            <tr>
                                <td>{{ $app->created_at }}</td>
                                <td>
                                    @if($app->userApplication->facility)
                                        {{ $app->userApplication->facility->name }}
                                    @else
                                        <span class="label label-info">Not found</span>
                                    @endif
                                </td>
                                <td>{{ $app->sharedBy->name }}</td>
                                <td>{{ $app->userApplication->user->name }}</td>
                                <td>{{ $app->userApplication->applicationType->name }}</td>
                                <td>{{ $app->userApplication->status }}</td>
                                <td>{{ $app->userApplication->comment }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm js-review"
                                            data-update-url="{{ route('updateReview',$app->user_application_id) }}"
                                            data-url="{{ route('reviewDocs',['userApplication'=>$app->userApplication->id,'applicationType'=>$app->userApplication->application_type_id,'user'=>$app->userApplication->user_id]) }}">
                                        Review
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endif
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                {{ $applications->links()}}
            </div>
        </div>
    </section>

    @include('partials.docsModal')

@endsection

@section('scripts')
    {{--    <script src="{{ asset('bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>--}}
    <script>
        $(function () {
            $('.nav-applications').addClass('active');

            $('#saveDocsForm').validate();

            $('#applicationType').on('change', function () {
                if (!$(this).val()) return;
                $.ajax({
                    'url': '/app-types/documents/' + $(this).val(),
                    'method': 'get',
                    'type': 'text/html'
                }).done(function (data) {
                    $('#sales-chart').html(data);
                    $('a[href="#sales-chart"]').tab('show') // Select tab by name
                });
            });

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

            $('#submitReviewForm').on('submit', function (e) {
                e.preventDefault();
                var form = $(this);
                if (form.valid()) {
                    $('#createBtn').button('loading');
                    // e.target.submit();
                    $.post(form.attr('action'), form.serialize())
                        .done(function (data) {
                            location.reload();
                        });
                }
            });


        });


    </script>
@endsection
