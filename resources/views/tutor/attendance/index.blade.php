@extends('layouts.body')
@section('title','Attendance')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Attendance Event Management</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{route('tutor-dashboard')}}">Home</a>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row"><!--Row-->
        <div class="col-lg-12"><!--Column-->
            <div class="tabs-container"><!--Tab Container-->
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> <i class="fa fa-search"></i><i class="fa fa-book"></i> View Attendances</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2"> <i class="fa fa-plus"></i> <i class="fa fa-book"></i>Set Attendance</a></li>
                </ul>
                <div class="tab-content"><!--Tab Content-->
                    <div role="tabpanel" id="tab-1" class="tab-pane active"><!--Tab PAnel 1-->
                        <div class="panel-body"><!--Panel Body 1-->
                            <div class="row"><!--Tab 1 Row-->
                                <div class="col-lg-12"><!--Tab 1 Col-->
                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5>Manage Attendance Events</h5>
                                        </div>
                                        <div class="ibox-content">

                                            <table class="table table-bordered table-hover events">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Clasroom</th>
                                                    <th>Venue</th>
                                                    <th>Attendance Date</th>
                                                    <th>Signin Start time</th>
                                                    <th>Signin End time</th>
                                                    <th>Signout Start time</th>
                                                    <th>Signout End time</th>
                                                    <th>Late Minutes</th>
                                                    <th>Active</th>
                                                    <th>Edit/Delete</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $count=0; ?>
                                                @foreach($attendances as $attendance)
                                                <?php $count++; ?>
                                                <tr class="gradeU">
                                                    <td>{{$count}}</td>
                                                    <td>{{$attendance->classroom->name}}</td>
                                                    <td>{{$attendance->venue->name}}</td>
                                                    <td>{{$attendance->attendance_date}}</td>
                                                    <td>{{$attendance->signin_start}}</td>
                                                    <td>{{$attendance->signin_end}}</td>
                                                    <td>{{$attendance->signout_start}}</td>
                                                    <td>{{$attendance->signout_end}}</td>
                                                    <td>{{$attendance->late_minute}}</td>
                                                    <td>@if($attendance->active==1)
                                                        <strong class="text-success">Active</strong>
                                                        @else
                                                        <strong class="text-danger">Inactive</strong>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('tutor-attendance.edit',['attendance'=>$attendance])}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <th>S/N</th>
                                                    <th>Clasroom</th>
                                                    <th>Venue</th>
                                                    <th>Attendance Date</th>
                                                    <th>Signin Start time</th>
                                                    <th>Signin End time</th>
                                                    <th>Signout Start time</th>
                                                    <th>Signout End time</th>
                                                    <th>Late Minutes</th>
                                                    <th>Active</th>
                                                    <th>Edit/Delete</th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div><!--End Tab 1 Col-->
                            </div><!--End Tab 1 Row-->
                        </div><!--End Panel Body 1-->
                    </div><!--End Tab Panel 1-->
                    <div role="tabpanel" id="tab-2" class="tab-pane"> <!--Tab PAnel 2-->
                        <div class="panel-body"><!--Panel Body 2-->
                            <div class="row"><!--Tab 2 Row-->
                                <div class="col-lg-12"><!--Tab 2 Col-->
                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5>Add Attendance Event</h5>
                                        </div>
                                        <div class="ibox-content">
                                            <form class="m-t" role="form" method="POST" action="{{route('tutor-attendance.store')}}">
                                                @csrf

                                                <div class="form-group row">
                                                    <div class="col-lg-2">
                                                        <label for="">Select Classroom</label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <select name="classroom" class="classroom">
                                                            <option disabled selected>Select Classroom</option>
                                                            @foreach ($classrooms as $classroom)
                                                            <option class="text-black" value="{{$classroom->id}}">{{$classroom->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Signin Start Time</label>
                                                    <div class="col-lg-10">
                                                        <input type="time" name="signin_start" placeholder="Signin Start Time e.g 09:00AM" class="form-control @error('signin_start') is-invalid @enderror"  value="{{ old('signin_start')}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Signin End Time</label>
                                                    <div class="col-lg-10">
                                                        <input type="time" name="signin_end" placeholder="Signin End Time e.g 09:30AM" class="form-control @error('signin_end') is-invalid @enderror"  value="{{ old('signin_end')}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Signout Start Time</label>
                                                    <div class="col-lg-10">
                                                        <input type="time" name="signout_start" placeholder="Signout Start Time e.g 12:00PM" class="form-control @error('signout_start') is-invalid @enderror"  value="{{ old('signout_start')}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Signout End Time</label>
                                                    <div class="col-lg-10">
                                                        <input type="time" name="signout_end" placeholder="Sigout End Time e.g 12:15PM" class="form-control @error('signout_end') is-invalid @enderror"  value="{{ old('signout_end')}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Late Time</label>
                                                    <div class="col-lg-10">
                                                        <input type="number" name="late" placeholder="Accomodate lateness by e.g 10 miniutes" class="form-control @error('late') is-invalid @enderror"  value="{{ old('late')}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Attendance Date</label>
                                                    <div class="col-lg-10">
                                                        <input type="date" id="attendance_date" name="attendance_date" placeholder="Set Attendance Date" class="form-control @error('attendance_date') is-invalid @enderror"  value="{{ old('attendance_date')}}">
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
                                                            <option class="text-black" value="{{$venue->id}}">{{$venue->name}}</option>
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
                                                            <option value="1">Enable</option>
                                                            <option value="0">Disable</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-10">
                                                        <button class="btn btn-sm btn-primary" type="submit">Set Attendance</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div><!--End Tab 2 Col-->
                            </div><!--End Tab 2 Row-->
                        </div><!--End Panel Body 2-->
                    </div><!--Tab PAnel 2-->
                </div><!--End Tab Content-->
            </div><!--End of Tab Container-->
        </div><!--End of Column-->
    </div><!--End of Row-->
</div><!--End of Wrapper-->

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
     $('.events').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                }
                }
            ]

        });
    });
</script>
@endsection
