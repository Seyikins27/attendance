@extends('layouts.body')
@section('title','Edit Attendance Event')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Attendance For Classroom - <strong>{{$attendance->classroom->name}} - Venue {{$attendance->venue->name}} </strong></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{route('tutor-attendance.index')}}">Home</a>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Attendance For Classroom - <strong>{{$attendance->classroom->name}} - Venue {{$attendance->venue->name}}</strong></h5>
            </div>
            <div class="ibox-content">
                <form class="m-t" role="form" method="POST" action="{{route('tutor-attendance.update',['attendance'=>$attendance])}}">
                    {{ method_field('PATCH') }}
                    @csrf

                    <div class="form-group row">
                        <div class="col-lg-2">
                            <label for="">Select Classroom</label>
                        </div>
                        <div class="col-lg-10">
                            <select name="classroom" class="classroom">
                                <option disabled selected>Select Classroom</option>
                                @foreach ($classrooms as $classroom)
                                <option class="text-black" {{$classroom->id==$attendance->classroom_id?"selected":""}} value="{{$classroom->id}}">{{$classroom->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Signin Start Time</label>
                        <div class="col-lg-10">
                            <input type="time" name="signin_start" placeholder="Signin Start Time e.g 09:00AM" class="form-control @error('signin_start') is-invalid @enderror"  value="{{$attendance->signin_start}}">
                        </div>
                    </div>

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Signin End Time</label>
                        <div class="col-lg-10">
                            <input type="time" name="signin_end" placeholder="Signin End Time e.g 09:30AM" class="form-control @error('signin_end') is-invalid @enderror"  value="{{ $attendance->signin_end}}">
                        </div>
                    </div>

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Signout Start Time</label>
                        <div class="col-lg-10">
                            <input type="time" name="signout_start" placeholder="Signout Start Time e.g 12:00PM" class="form-control @error('signout_start') is-invalid @enderror"  value="{{ $attendance->signout_start}}">
                        </div>
                    </div>

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Signout End Time</label>
                        <div class="col-lg-10">
                            <input type="time" name="signout_end" placeholder="Sigout End Time e.g 12:15PM" class="form-control @error('signout_end') is-invalid @enderror"  value="{{ $attendance->signout_end}}">
                        </div>
                    </div>

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Late Time</label>
                        <div class="col-lg-10">
                            <input type="number" name="late" placeholder="Accomodate lateness by e.g 10 miniutes" class="form-control @error('late') is-invalid @enderror"  value="{{ $attendance->late_minute}}">
                        </div>
                    </div>

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Attendance Date</label>
                        <div class="col-lg-10">
                            <input type="date" id="attendance_date" name="attendance_date" placeholder="Set Attendance Date" class="form-control @error('attendance_date') is-invalid @enderror"  value="{{ $attendance->attendance_date}}">
                        </div>
                        <a class="btn btn-sm btn-success" id="set_date">Set Today's date</a>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-2">
                            <label for="">Select Venue</label>
                        </div>
                        <div class="col-lg-10">
                            <select name="venue" class="venue">
                                <option disabled selected>Select Venue</option>
                                @foreach ($venues as $venue)
                                <option class="text-black" {{$venue->id==$attendance->venue_id?"selected":""}} value="{{$venue->id}}">{{$venue->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-2">
                            <label class="">Set Attendance Status</label>
                        </div>
                        <div class="col-lg-10">
                            <select name="active" id="active" class="form-control" required>
                                <option value="" disabled selected>--Select Status--</option>
                                <option value="1" {{$attendance->active==1?"selected":""}}>Enable</option>
                                <option value="0" {{$attendance->active==0?"selected":""}}>Disable</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-sm btn-primary" type="submit">Update Attendance Event</button>
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
    function set_date()
    {
       let today = new Date();
       document.getElementById('attendance_date').value=today.toISOString().split('T')[0];
    }

    $("body").on("click", "#set_date", set_date);
    $('.classroom').chosen({width: "100%"});
    $('.venue').chosen({width: "100%"});
    $(document).ready(function() {

    });
</script>
@endsection
