
<h4>Classroom Name: {{ucfirst($classroom->name)}}</h4>
<p>Classroom Teacher: {{$classroom->teacher->_fullname()}}</p>
<p>Classroom Description: {!!$classroom->description!!}</p>
<div class="form-group row">
    <div class="col-lg-offset-2 col-lg-10">
        <input type="hidden"  name="classroom" id="classroom" value="{{$classroom->id}}">
        <button class="btn btn-sm btn-primary" id="classroom_enrol" type="submit">Enrol</button>
    </div>
</div>
