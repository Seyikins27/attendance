<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="site_url" content="{{url("")}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{"Attendance Box "}} - Home </title>

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    {{-- <link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}" /> --}}
    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />
    <link rel="stylesheet" href="{!! asset('font-awesome/css/font-awesome.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/modal-css.css') !!}" />
</head>
<body class="gray-bg">
<div class="middle-box text-center loginscreen   animated fadeInDown">
    <div>
        <div>

            <h3>Welcome to Attendance Box</h3>
            <h1 class="logo-name"><i class="fa fa-clock-o"></i></h1>
        </div>
        <p>
            <a href="{{route('student-index')}}" class="btn btn-primary block full-width m-b">Student</a>
            <a href="{{route('tutor-index')}}" class="btn btn-primary block full-width m-b">Tutor</a>
        </p>

        <p class="m-t"> <small>Attendance Box &copy; {{date('Y')}}</small> </p>
    </div>
</div>
</body>
</html>

