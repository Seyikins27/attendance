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
                                            <h5>{{ucfirst($classroom->name)}} attendance Logs For {{ucfirst($student_details->idno)}} {{$student_details->_fullname()}}</h5>
                                        </div>
                                        <div class="ibox-content">
                                            <div class="table-responsive">
                                            <table class="table table-bordered table-hover logs">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Clasroom</th>
                                                    <th>Venue</th>
                                                    <th>Attendance Date</th>
                                                    <th>Signin Date/Time</th>
                                                    <th>Signout Date/Time</th>
                                                    <th>Comment</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $count=0; ?>
                                                @foreach($attendance_logs as $log)
                                                <?php $count++; ?>
                                                <tr class="gradeU">
                                                    <td>{{$count}}</td>
                                                    <td>{{$log->attendance->classroom->name}}</td>
                                                    <td>{{$log->attendance->venue->name}}</td>
                                                    <td>{{$log->attendance->attendance_date}}</td>
                                                    <td>{{$log->date_in}} {{$log->time_in}}</td>
                                                    <td>{{$log->date_out}} {{$log->time_out}}</td>
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
                                                    <th>Signin Date/Time</th>
                                                    <th>Signout Date/Time</th>
                                                    <th>Comment</th>
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
