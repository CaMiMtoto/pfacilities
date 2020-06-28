@extends('layouts.app')
@section('title','Signature')
@section('content')
    <section class="content">
        @include('includes._alerts')
        <div class="box box-primary flat">
            <div class="box-header with-border">
                <div class="box-title">
                    <h4> Manage Signature</h4>
                </div>
            </div>

            <div class="box-body">
                <div class="col-md-6">
                    @if($signature==null)
                        <div class="alert alert-info">
                            <p>You don't have a signature. please upload one</p>
                        </div>
                    @endif
                    <form enctype="multipart/form-data" method="post" id="signForm"
                          action="{{ route('signature.store') }}">
                        @method("post")
                        @csrf
                        <input type="hidden" name="id" value="{{ $signature->id??'0' }}">
                        <div class="form-group">
                            <label for="exampleInputFile">Signature</label>
                            <input required type="file" name="signature" id="exampleInputFile">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check-circle"></i>
                            Save changes
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    @if($signature)
                        <h5>Signature</h5>
                        <img src="{{ $signature->signature_url }}" alt="" class="img-responsive" style="height: 100px;">
                    @endif
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">

            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        $(function () {
            $('.nav-settings').addClass('active');
            $('#signForm').validate();
        });
    </script>
@endsection
