<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="site_url" content="{{url("")}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{"Attendance Box "}} - @yield('title') </title>

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    {{-- <link href="http://webapplayers.com/inspinia_admin-v2.9.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://webapplayers.com/inspinia_admin-v2.9.3/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="http://webapplayers.com/inspinia_admin-v2.9.3/css/animate.css" />
    <link rel="stylesheet" href="http://webapplayers.com/inspinia_admin-v2.9.3/css/style.css" /> --}}



    {{-- <link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}" /> --}}
    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />
    <link rel="stylesheet" href="{!! asset('font-awesome/css/font-awesome.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/modal-css.css') !!}" />


    @if(isset($css) && ! empty($css))
      @foreach($css as $css_files)
    <link rel="stylesheet" href="{!! asset($css_files) !!}" />
      @endforeach
    @endif

</head>
<body>

 @yield('body')


</body>
</html>
