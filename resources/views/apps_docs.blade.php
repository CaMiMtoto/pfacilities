<br>
@foreach($appTypeDocs as $appType)
    <div class="col-md-6">
        <div class="form-group">
            <label for="{{$appType->document->id}}" class="control-label">{{ $appType->document->name }}</label>
            <input type="file" required class="form-control" id="{{$appType->document->id}}"
                   name="{{$appType->document->id}}">
        </div>
    </div>

@endforeach
<br>
