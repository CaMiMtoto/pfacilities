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

@if( $userApplication->sharedToMe() || auth()->user()->role=='phf')
    <div class="col-md-12">
        <div class="form-group">
            <label for="status" class="control-label col-md-3">Status</label>
            <div class="col-md-9">
                <select name="status" class="form-control" required id="status">
                    <option value=""></option>
                    @if(auth()->user()->role=='phf')
                        <option
                            {{ $userApplication->status=='modification'?'selected':'' }}
                            value="modification">
                            For modification
                        </option>
                        <option
                            {{ $userApplication->status=='process'?'selected':'' }}
                            value="process">In process
                        </option>
                        <option
                            {{ $userApplication->status=='pending'?'selected':'' }}
                            value="pending">Pending
                        </option>
                        <option
                            {{ $userApplication->status=='verified'?'selected':'' }}
                            value="verified">Verified
                        </option>
                    @elseif(auth()->user()->role!=App\Roles::$APPLICANT)
                        <option
                            {{ $userApplication->status=='approved'?'selected':'' }}
                            value="approved">Approved
                        </option>
                        <option
                            {{ $userApplication->status=='rejected'?'selected':'' }}
                            value="rejected">Rejected
                        </option>
                        <option
                            {{ $userApplication->status=='not_clear'?'selected':'' }}
                            value="not_clear">Not Clear
                        </option>
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="comment" class="control-label col-md-3">Comment</label>
            <div class="col-md-9">
                <textarea required name="comment" id="comment" rows="5"
                          class="form-control">{{ $userApplication->comment }}</textarea>
            </div>
        </div>
    </div>
    <div class="col-md-12" id="shareApplicationId">
        <div class="form-group">
            <label for="position_id" class="control-label col-md-3">Share Application</label>
            <div class="col-md-9">
                <select required class="form-control" name="position_id" id="position_id">
                    <option value=""></option>
                    @foreach($positions as $position)
                        <option
                            {{ $userApplication->lastSharedTo()->position_id==$position->id?'selected':'' }}
                            value="{{ $position->id }}">{{ $position->name }}
                            - {{ $position->description }}  </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

@else

    <div class="alert alert-info flat">
        <p>
            <i class="fa fa-warning"></i>
            Note that is application is not shared to you!
        </p>
    </div>

@endif
