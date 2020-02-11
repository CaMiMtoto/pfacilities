@foreach($docs->chunk(3) as $chunk)
    <div class="row">
        @foreach($chunk as $doc)
            <div class="col-md-4">
                <div class="thumbnail flat">
                    <p>{{ $doc->document->name }}</p>
                    <a href="{{ route('viewDoc',[$doc->id]) }}" class="btn btn-danger btn-sm pull-right"
                       target="_blank">
                        <i class="fa fa-file-pdf-o"></i>
                        View Document
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach
<div class="col-md-12">
    <div class="form-group">
        <label for="status" class="control-label col-md-3">Status</label>
        <div class="col-md-9">
            <select name="status" class="form-control" required id="status">
                <option value=""></option>
                @if(Auth::user()->role=='phf')
                    <option value="modification" {{ $userApplication->status=='modification'?'selected':'' }}>
                        For modification
                    </option>
                    <option value="process" {{ $userApplication->status=='process'?'selected':'' }}>In process</option>
                    <option value="pending" {{ $userApplication->status=='pending'?'selected':'' }}>Pending</option>
                    <option value="verified" {{ $userApplication->status=='verified'?'selected':'' }}>Verified</option>
                @elseif(Auth::user()->role!=App\Roles::$APPLICANT)
                    <option value="approved" {{ $userApplication->status=='approved'?'selected':'' }}>Approved</option>
                    <option value="rejected" {{ $userApplication->status=='rejected'?'selected':'' }}>Rejected</option>
                    <option value="not_clear" {{ $userApplication->status=='not_clear'?'selected':'' }}>Not Clear</option>
                @endif
            </select>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="comment" class="control-label col-md-3">Comment</label>
        <div class="col-md-9">
            <textarea name="comment" id="comment" class="form-control">{{ $userApplication->comment }}</textarea>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="position_id" class="control-label col-md-3">Share Application</label>
        <div class="col-md-9">
            <select class="form-control" name="position_id" id="position_id">
                <option value=""></option>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->name }} - {{ $position->description }}  </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="clearfix"></div>
