<div class="form-group">
    <input name='name' value="{{old('name',$articleCategory->name)}}" type="text" class="form-control"/>
    @if($errors->has('name'))
    <span class="error">{{$errors->first('name')}}</span>
    @endif
</div>
<div class="form-group">
    <input type="submit" value="simpan" class="btn btn-primary"/>
</div>