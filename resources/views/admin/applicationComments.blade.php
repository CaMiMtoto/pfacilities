@extends('layouts.app')
@section('title','Comments')
@section('styles')
    <style>
        .direct-chat-messages {
            height: auto !important;
        }
    </style>
@endsection
@section('content')
    <section class="content">
        <div class="box box-primary direct-chat direct-chat-primary flat">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Comments
                </h3>
                <p>
                    Application type: {{ $application->applicationType->name }}
                </p>
                <p>
                    Applicant: {{ $application->user->name }}
                </p>
                <p>
                    Tel: {{ $application->user->phone }}
                </p>

                <div class="box-tools pull-right">
                    <strong>
                        Status :
                        <span class="label label-info"
                              style="font-size: 15px;">{{ ucfirst($application->status) }}</span>
                    </strong>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">

                @foreach($comments as $comment)
                    <!-- Message. Default to the left -->
                        @if($comment->user_id!=\Illuminate\Support\Facades\Auth::id())
                            <div class="direct-chat-msg">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-left">
                                        {{ $comment->user->name }}
                                    </span>
                                    <span class="direct-chat-timestamp pull-right">
                                        {{ $comment->created_at->format('d M ,h:i a') }}
                                    </span>
                                </div>
                                <!-- /.direct-chat-info -->
                                {{--                                <span class="direct-chat-img">--}}
                                {{--                                    <i class="fa fa-user-circle-o"></i>--}}
                                {{--                                </span>--}}
                                <div class="direct-chat-text flat">
                                    {{ $comment->comment }}
                                </div>
                                <!-- /.direct-chat-text -->
                            </div>
                            <!-- /.direct-chat-msg -->
                        @else
                        <!-- Message to the right -->
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-right">{{ $comment->user->name }}</span>
                                    <span class="direct-chat-timestamp pull-left">
                                          {{ $comment->created_at->format('d M ,h:i a') }}
                                    </span>
                                </div>
                                {{--       <span class="direct-chat-img">
                                           <i class="fa fa-user-circle"></i>
                                       </span>--}}
                                <div class="direct-chat-text flat">
                                    {{ $comment->comment }}
                                </div>
                                <!-- /.direct-chat-text -->
                            </div>
                            <!-- /.direct-chat-msg -->
                        @endif
                    @endforeach
                </div>
                <!--/.direct-chat-messages-->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <form action="{{ route('applicationComment.save',[$application->id]) }}" id="form" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <textarea required type="text" name="comment" placeholder="Type a Comment Here ..."
                                  class="form-control"></textarea>
                        <span class="input-group-btn">
                      </span>
                    </div>

                    <button type="submit" id="createBtn" class="btn btn-primary btn-flat">
                        Send comment
                    </button>
                    @if($application->status=='verified' && Auth::user()->role == 'inspector')
                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-info btn-flat">
                            Change Status
                        </button>
                    @elseif($application->status=='inspected' && Auth::user()->role == 'approval')
                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-info btn-flat">
                            Change Status
                        </button>
                    @elseif($application->status=='approved' && Auth::user()->role == 'certifier')
                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-info btn-flat">
                            Change Status
                        </button>
                    @endif
                </form>


            </div>
            <!-- /.box-footer-->
        </div>
    </section>


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <strong> {{ Auth::user()->name }}</strong>
                        <small> Change Application Status</small>
                    </h4>
                </div>
                <form action="{{ route('changeStatus',[$application->id]) }}" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="status" class="control-label col-md-4">
                                Application Status
                            </label>
                            <div class="col-md-8">
                                <select name="status" id="status" required class="form-control">
                                    <option value=""> -- Status --</option>
                                    <option value="approved">Approved</option>
                                    <option value="not_approved">Not Approved</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection

@section('scripts')
    <script>
        $('#form').validate();
        $(function () {
            $('.nav-applications').addClass('active');

            $('#form').on('submit', function (e) {
                e.preventDefault();
                if (!$(this).valid()) return false;

                $('#createBtn').button('loading');
                e.target.submit();
            });
        });


    </script>
@endsection
