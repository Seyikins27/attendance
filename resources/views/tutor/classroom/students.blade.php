@extends('layouts.body')
@section('title','Classroom Students')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>{{ucfirst($classroom->classroom->name)}} Students</h2>
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
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-clock-o"></i> View Classroom Students</a></li>
                </ul>
                <div class="tab-content"><!--Tab Content-->
                    <div role="tabpanel" id="tab-1" class="tab-pane active"><!--Tab PAnel 1-->
                        <div class="panel-body"><!--Panel Body 1-->
                            <div class="row"><!--Tab 1 Row-->
                                <div class="col-lg-12"><!--Tab 1 Col-->
                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5>View Students in {{ucfirst($classroom->classroom->name)}} </h5>
                                        </div>
                                        <div class="ibox-content">
                                            <div class="table-responsive">
                                            <table class="table table-bordered table-hover students">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Student ID</th>
                                                    <th>Student Name</th>
                                                    <th>Date Enrolled</th>
                                                    <th>View Attendance</th>
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
                                                    <td>{{$student->created_at}}</td>
                                                    <td>
                                                        <a href="{{route('tutor-student-attendance-log',['classroom'=>$classroom->classroom->id,'student_id'=>$student->student->id])}}" class="btn btn-info">View Attendance Log</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <th>S/N</th>
                                                    <th>Student ID</th>
                                                    <th>Student Name</th>
                                                    <th>Date Enrolled</th>
                                                    <th>View Attendance</th>
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
     $('.students').DataTable({
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
