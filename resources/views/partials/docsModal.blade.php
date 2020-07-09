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
                            Continue
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
