{!! csrf_field() !!}
<div class="form-group">
    <label for="name">Nama</label>
    <input type="text" name="name" value="{{request('name',$user->name)}}" id="name" class="form-control"/>
</div>
<div class="form-group">
    <label for="type">Kategori</label>
    <select name="type" id="type" class="form-control">
    @foreach($categories as $category)
        <option value="{{$category}}" @if($category == request('type',$user->type)) selected @endif>{{$category}}</option>
    @endforeach
    </select>
</div>
<div class="form-group">
    <input type="submit" class="btn btn-primary" value="simpan">
</div>