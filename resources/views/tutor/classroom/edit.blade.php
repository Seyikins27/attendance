@extends('layouts.body')
@section('title','Edit Classroom')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Classroom - <strong>{{$classroom->name}} </strong></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{route('tutor-classroom.index')}}">Home</a>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Edit Classroom - <strong>{{$classroom->name}} </strong></h5>
            </div>
            <div class="ibox-content">
                <form class="m-t" role="form" method="POST" action="{{route('tutor-classroom.update',['classroom'=>$classroom])}}">
                    {{ method_field('PATCH') }}
                    @csrf

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Classroom Name</label>
                        <div class="col-lg-10"><input type="text" name="name" value="{{$classroom->name}}" placeholder="Classroom Name" class="form-control @error('name') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Classroom Description</label>
                        <textarea placeholder="Enter Classroom Description" class="form-control @error('description') is-invalid @enderror" name="description">{{$classroom->description }}</textarea>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-2">
                            <label class="">Set Classroom Status</label>
                        </div>
                        <div class="col-lg-9">
                            <select name="active" id="" class="form-control">
                                <option value="" disabled selected>--Select Option--</option>
                                <option value="1" {{$classroom->active==1?"selected":""}}>Enable</option>
                                <option value="0"  {{$classroom->active==0?"selected":""}}>Disable</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-sm btn-primary" type="submit">Update Classroom</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>

    $(document).ready(function() {
     //CKEDITOR.config.autoParagraph = false;
     CKEDITOR.replace( 'description' );
    });
</script>
@endsection
