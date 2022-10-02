@extends('layouts.body')
@section('title','Classroom')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Classrooms</h2>
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
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> <i class="fa fa-search"></i><i class="fa fa-book"></i> View Classrooms</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2"> <i class="fa fa-plus"></i> <i class="fa fa-book"></i> Add Classrooms</a></li>
                </ul>
                <div class="tab-content"><!--Tab Content-->
                    <div role="tabpanel" id="tab-1" class="tab-pane active"><!--Tab PAnel 1-->
                        <div class="panel-body"><!--Panel Body 1-->
                            <div class="row"><!--Tab 1 Row-->
                                <div class="col-lg-12"><!--Tab 1 Col-->
                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5>Classrooms</h5>
                                        </div>
                                        <div class="ibox-content">

                                            <table class="table table-bordered table-hover classrooms">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Clasroom</th>
                                                    <th>Classroom Code</th>
                                                    <th>Status</th>
                                                    <th>Edit/Delete</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $count=0; ?>
                                                @foreach($classrooms as $class)
                                                <?php $count++; ?>
                                                <tr class="gradeU">
                                                    <td>{{$count}}</td>
                                                    <td>{{$class->name}}</td>
                                                    <td>{{$class->code}}</td>
                                                    <td>@if($class->active==1)
                                                        <strong class="text-success">Active</strong>
                                                        @else
                                                        <strong class="text-danger">Inactive</strong>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('tutor-classroom.edit',['classroom'=>$class])}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                        <a href="{{route('tutor-classroom-students',['classroom'=>$class->id])}}" class="btn btn-primary">Students</a>
                                                        <a href="{{route('tutor-attendance-log',['classroom'=>$class->id])}}" class="btn btn-primary">Attendance Logs</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <th>S/N</th>
                                                    <th>Clasroom</th>
                                                    <th>Classroom Code</th>
                                                    <th>Status</th>
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
                                            <h5>Add Test</h5>
                                        </div>
                                        <div class="ibox-content">
                                            <form class="m-t" role="form" method="POST" action="{{route('tutor-classroom.store')}}">
                                                @csrf

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Classroom Name</label>
                                                    <div class="col-lg-10">
                                                        <input type="text" name="name" placeholder="Classroom Name" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name')}}">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Classroom Description</label>
                                                    <textarea placeholder="Enter Classroom Description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description')}}</textarea>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-2">
                                                        <label class="">Set Classroom Status</label>
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
                                                        <button class="btn btn-sm btn-primary" type="submit">Add Classroom</button>
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
