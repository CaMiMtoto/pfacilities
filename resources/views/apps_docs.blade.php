<br>

<div class="container-fluid">
    @foreach($appTypeDocs->chunk(2) as $chunk)
        <div  style="border: 1px solid #f3f1f1;padding: 5px;margin-top: 5px;">
            <div class="row">
                @foreach($chunk  as $appType)
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="{{$appType->document->id}}" class="control-label">{{ $appType->document->name }}</label>
                            <input type="file" required class="form-control" id="{{$appType->document->id}}"
                                   name="{{$appType->document->id}}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @endforeach
</div>
