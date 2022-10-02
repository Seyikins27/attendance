@extends('layouts.app')
@section('body')


<!-- Wrapper-->
<div id="wrapper">

    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Page wraper -->
    <div id="page-wrapper" class="gray-bg">

        <!-- Page wrapper -->
        @include('layouts.topnavbar')

        @include('layouts.error')

        <!-- Main view  -->
        @yield('content')

        <!-- Footer -->
        @include('layouts.footer')

    </div>
    <!-- End page wrapper-->

</div>
<!-- End wrapper-->

<script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>
@if(isset($js) && ! empty($js))
@foreach($js as $js_files)
 <script src="{!! asset($js_files) !!}" type="text/javascript"></script>
@endforeach
@endif
<script>
    $(document).ready( function (e) {

      var url = window.location.pathname; //sets the variable "url" to the pathname of the current window
      var activePage = url.substring(url.lastIndexOf('/') + 1); //sets the variable "activePage" as the substring after the last "/" in the "url" variable
          $('.metismenu li a').each(function () { //looks in each link item within the primary-nav list
              var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1); //sets the variable "linkPage" as the substring of the url path in each &lt;a&gt;
              if (activePage == linkPage) { //compares the path of the current window to the path of the linked page in the nav item
                  $(this).parent('li').addClass('active'); //if the above is true, add the "active" class to the parent of the &lt;a&gt; which is the &lt;li&gt; in the nav list
              }
      });
    });
  </script>
@section('scripts')
@show
@endsection
