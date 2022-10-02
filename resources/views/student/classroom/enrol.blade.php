@extends('layouts.body')
@section('title','Classroom')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Welcome {{ucfirst(session()->get('username'))}} - {{$student_id}}</h2>
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
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> <i class="fa fa-search"></i><i class="fa fa-book"></i> Enrolled Classrooms</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2"> <i class="fa fa-plus"></i> <i class="fa fa-book"></i> Enrol</a></li>
                </ul>
                <div class="tab-content"><!--Tab Content-->
                    <div role="tabpanel" id="tab-1" class="tab-pane active"><!--Tab PAnel 1-->
                        <div class="panel-body"><!--Panel Body 1-->
                            <div class="row"><!--Tab 1 Row-->
                                <div class="col-lg-12"><!--Tab 1 Col-->
                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5>Classrooms that i am enrolled in</h5>
                                        </div>
                                        <div class="ibox-content">
                                            <div class="table-responsive">
                                            <table class="table table-bordered table-hover classrooms">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Clasroom</th>
                                                    <th>Classroom Code</th>
                                                    <th>Classroom Teacher</th>
                                                    <th>Drop</th>
                                                    <th>Attendance Logs</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $count=0; ?>
                                                @foreach($classrooms as $classroom)
                                                <?php $count++; ?>
                                                <tr class="gradeU">
                                                    <td>{{$count}}</td>
                                                    <td>{{$classroom->classroom->name}}</td>
                                                    <td>{{$classroom->classroom->code}}</td>
                                                    <td>{{$classroom->classroom->teacher->_fullname()}}</td>
                                                    <td>
                                                        <a href="#" id="drop_enrolment" class="btn btn-info" data-student="{{$classroom->student_id}}" data-classroom="{{$classroom->classroom_id}}"><i class="fa fa-trash" ></i></a>
                                                    </td>
                                                    <td>
                                                        <a href="{{route('student-attendance-log',['classroom'=>$classroom->classroom->id])}}" class="btn btn-primary"> <i class="fa fa-clock-o"></i> Attendance Log</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <th>S/N</th>
                                                    <th>Clasroom</th>
                                                    <th>Classroom Code</th>
                                                    <th>Classroom Teacher</th>
                                                    <th>Drop</th>
                                                    <th>Attendance Logs</th>
                                                </tfoot>
                                            </table>
                                            </div>
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
                                            <h5>Enrol in Classroom</h5>
                                        </div>
                                        <div class="ibox-content">

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Classroom Code</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="classroom_code" id="classroom_code" placeholder="Enter Classroom Code" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name')}}">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <button class="btn btn-sm btn-primary" id="verify_classroom" type="submit">Verify Classroom</button>
                                                    </div>
                                                </div>
                                            <form class="m-t" role="form" id="enrolment_form">
                                                <input type="hidden" name="student" id="student" value="{{session()->get('id')}}">
                                                <div id="classroom_details">

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
    $(document).ready(function() {
     //CKEDITOR.config.autoParagraph = false;
     CKEDITOR.replace( 'description' );
     $('.classrooms').DataTable({
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
