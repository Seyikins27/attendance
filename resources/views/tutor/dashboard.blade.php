@extends('layouts.body')
@section('title','Dashboard')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Welcome {{ucfirst(session()->get('username'))}}</h2>
    </div>

</div>
<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Current Date</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{date('Y-m-d')}}</h1>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Classrooms</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{count($classrooms)}}</h1>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Venues</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$venues}}</h1>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Students in all</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$students_in_all}}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
