<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="site_url" content="{{url("")}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{"Attendance Box "}} - Register</title>

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    {{-- <link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}" /> --}}
    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />
    <link rel="stylesheet" href="{!! asset('font-awesome/css/font-awesome.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/modal-css.css') !!}" />
</head>
<body class="gray-bg">
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        @include('layouts.error')
        <div>
            <h3>Welcome to Attendance Box</h3>
            <h1 class="logo-name"><i class="fa fa-clock-o"></i></h1>
        </div>
        <p> <strong>Create an account as a tutor.</strong> </p>
            <form class="m-t" role="form" action="{{route('tutor-add')}}" method="POST">
                @csrf

                <div class="form-group">
                    <select name="title" class="form-control">
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Ms">Ms</option>
                        <option value="Dr">Dr</option>
                        <option value="Prof">Prof</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Fullame" required="">
                </div>

                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required="">
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>

                <div class="form-group">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required="">
                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{route('tutor-login')}}">Login</a>
            </form>
        <p class="m-t"> <small>Attendance Box &copy; {{date('Y')}}</small> </p>
    </div>
</div>
</body>
</html>

