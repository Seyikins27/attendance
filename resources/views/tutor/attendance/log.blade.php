@extends('layouts.body')
@section('title','Attendance Logs')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>View Attendance Logs</h2>
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
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-clock-o"></i> View Attendance Logs</a></li>
                </ul>
                <div class="tab-content"><!--Tab Content-->
                    <div role="tabpanel" id="tab-1" class="tab-pane active"><!--Tab PAnel 1-->
                        <div class="panel-body"><!--Panel Body 1-->
                            <div class="row"><!--Tab 1 Row-->
                                <div class="col-lg-12"><!--Tab 1 Col-->
                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5>View Attendance Logs for {{ucfirst($classroom->name)}}</h5>
                                        </div>
                                        <div class="ibox-content">
                                            <div class="table-responsive">
                                            <table class="table table-bordered table-hover logs">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Student ID</th>
                                                    <th>Student Name</th>
                                                    @foreach($attendances as $date)
                                                    <th>{{$date->attendance_date}} ({{$date->venue->name}})</th>
                                                    @endforeach
                                                    <th>Total Marks / {{count($attendances)}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $count=0; ?>
                                                @foreach($students as $student)
                                                <?php $count++; ?>
                                                <tr class="gradeU">
                                                    <td>{{$count}}</td>
                                                    <td>{{$student->student->idno}}</td>
                                                    <td>{{$student->student->_fullname()}}</td>
                                                    <?php $total_score=0; ?>
                                                    @foreach($attendances as $attendance)
                                                    <td>
                                                        <?php $attendance_exists=$attendance_logs->where('attendance_id',$attendance->id); $student_attendance_exists=$attendance_exists->where('student_id',$student->student->id)->first(); ?>
                                                        @if($student_attendance_exists!=null && ($student_attendance_exists->time_in>=$student_attendance_exists->attendance->signin_start &&  $student_attendance_exists->time_in<=$student_attendance_exists->attendance->signin_end))
                                                           <span class="text-success">Signed in</span>
                                                           <?php $total_score+=0.5; ?>
                                                        @elseif($student_attendance_exists!=null && $student_attendance_exists->time_in==null)
                                                           <span class="text-warning">No Sign in</span>
                                                        @elseif($student_attendance_exists!=null && ((strtotime($student_attendance_exists->time_in)>strtotime($student_attendance_exists->attendance->signin_start)) && (strtotime($student_attendance_exists->time_in)<=strtotime($student_attendance_exists->attendance->signin_start)+($student_attendance_exists->attendance->late_minute*60)) ))
                                                        <span class="text-warning">Signed in Late</span>
                                                        <?php $total_score+=0.2; ?>
                                                        @else
                                                            <span class="text-danger">Absent</span>
                                                        @endif |
                                                        @if($student_attendance_exists!=null&&($student_attendance_exists->time_out>=$student_attendance_exists->attendance->signout_start &&  $student_attendance_exists->time_out<=$student_attendance_exists->attendance->signout_end))
                                                        <span class="text-success">Signed Out</span>
                                                        <?php $total_score+=0.5; ?>
                                                        @elseif($student_attendance_exists!=null&&$student_attendance_exists->time_out==null)
                                                           <span class="text-warning">No Sign out</span>
                                                        @else
                                                        <span class="text-danger">Absent</span>
                                                     @endif
                                                    </td>
                                                    @endforeach
                                                    <td>{{$total_score}}</td>
                                                </tr>
                                                @endforeach
                                                </tbody>
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

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
     $('.logs').DataTable({
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
