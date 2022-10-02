@extends('layouts.body')
@section('title','Edit Venue')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Venue - <strong>{{$venue->name}} </strong></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{route('tutor-venue.index')}}">Home</a>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Edit Venue - <strong>{{$venue->name}} </strong></h5>
            </div>
            <div class="ibox-content">
                <form class="m-t" role="form" method="POST" action="{{route('tutor-venue.update',['venue'=>$venue])}}">
                    {{ method_field('PATCH') }}
                    @csrf

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Venue Name</label>
                        <div class="col-lg-10"><input type="text" name="name" value="{{$venue->name}}" placeholder="Venue Name" class="form-control @error('name') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Venue Longitude</label>
                        <div class="col-lg-10">
                            <input type="text" id="longitude" name="longitude" placeholder="Venue Longitude" class="form-control @error('longitude') is-invalid @enderror"  value="{{$venue->longitude}}">
                        </div>
                    </div>

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Venue Latitude</label>
                        <div class="col-lg-10">
                            <input type="text" id="latitude" name="latitude" placeholder="Venue Latitude" class="form-control @error('latitude') is-invalid @enderror"  value="{{$venue->latitude}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <a  class="btn btn-primary" id="set_location" title="Set to Current Location"><i class="fa fa-location-arrow"></i> Set to Current Location</a>
                    </div>

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Map</label>
                        <div id="mapholder"></div>
                          <iframe width="400" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Maximum Distance</label>
                        <div class="col-lg-10">
                            <input type="text" name="max_distance" placeholder="Maximum Distance from which to login" class="form-control @error('max_distance') is-invalid @enderror"  value="{{$venue->max_distance}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-sm btn-primary" type="submit">Update Venue</button>
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
    });
</script>
@endsection
