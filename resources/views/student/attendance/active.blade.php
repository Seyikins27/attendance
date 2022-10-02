@extends('layouts.body')
@section('title','Active Attendance Events')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Active Attendance Event</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{route('student-dashboard')}}">Home</a>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row"><!--Row-->
        <div class="col-lg-12"><!--Column-->
            <div class="tabs-container"><!--Tab Container-->
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> <i class="fa fa-search"></i><i class="fa fa-book"></i> View Active Attendances</a></li>
                </ul>
                <div class="tab-content"><!--Tab Content-->
                    <div role="tabpanel" id="tab-1" class="tab-pane active"><!--Tab PAnel 1-->
                        <div class="panel-body"><!--Panel Body 1-->
                            <div class="row"><!--Tab 1 Row-->
                                <div class="col-lg-12"><!--Tab 1 Col-->
                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5>Active Attendance Events</h5>
                                        </div>
                                        <div class="ibox-content">
                                            <input type="hidden" id="lon" name="longitude">
                                            <input type="hidden" id="lat" name="latitude">
                                            <div class="table-responsive">
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
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $count=0; ?>
                                                @foreach($active_attendances as $attendance)
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
                                                    <td>@if(strtotime($attendance->signin_start)>strtotime(date('H:i:s')))
                                                        <strong class="text-success">Attendance Upcoming in {{ceil(abs(strtotime($attendance->signin_start)-strtotime(date('H:i:s')))/60)}} Minutes</strong>
                                                        @elseif(strtotime($attendance->signout_end)<strtotime(date('H:i:s')))
                                                        <strong class="text-danger">Attendance is Past</strong>
                                                        @else
                                                          @if(strtotime(date('H:i:s'))>=strtotime($attendance->signout_start) && strtotime(date('H:i:s'))<=strtotime($attendance->signout_end))
                                                           <button class="btn btn-danger" id="signout" data-att="{{$attendance->id}}" data-student="{{session()->get('id')}}">Signout</button>
                                                          @else
                                                           <button class="btn btn-primary" data-toggle="modal" data-target="#webcamModal" id="signin" data-att="{{$attendance->id}}" data-student="{{session()->get('id')}}">Signin</button>
                                                          @endif
                                                        @endif
                                                    </td>
                                                    <td>

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
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                </tfoot>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--End Tab 1 Col-->
                            </div><!--End Tab 1 Row-->
                        </div><!--End Panel Body 1-->
                    </div><!--End Tab Panel 1-->

                </div><!--End Tab Content-->
            </div><!--End of Tab Container-->
        </div><!--End of Column-->
    </div><!--End of Row-->
</div><!--End of Wrapper-->

<div class="modal fade" tabindex="-1" role="dialog" id="webcamModal" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" id="modal-content">

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
