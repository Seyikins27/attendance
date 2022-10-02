<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{ucwords(session()->get('username'))}}</strong>
                            </span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"> <span class="nav-label">Logout</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf</li>
                    </ul>
                </div>
                <div class="logo-element">
                    <i class="fa fa-clock-o"></i>
                </div>
            </li>

         @if(session()->get('tutor_authenticated')==true)
            <li class="">
                <a href="{{ route('tutor-dashboard') }}"><i class="fa fa-home"></i> <span class="nav-label">Dashboard</span> </a>
            </li>
            <li class="">
                <a href="{{route('tutor-classroom.index')}}"><i class="fa fa-institution"></i> <span class="nav-label">Manage Classroom</span> </a>
            </li>

            <li class="">
                <a href="{{route('tutor-venue.index')}}"><i class="fa fa-institution"></i> <span class="nav-label">Manage Venue</span> </a>
            </li>
            <li class="">
                <a href="{{route('tutor-attendance.index')}}"><i class="fa fa-clock-o"></i> <span class="nav-label">Manage Attendance</span> </a>
            </li>
            <li class="">
            <a href="#"><i class="fa fa-key"></i> <span class="nav-label">Change Password</span> </a>
            </li>
          <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
          </li>
          @elseif(session()->get('student_authenticated')==true)
          <li class="">
            <a href="{{ route('student-dashboard') }}"><i class="fa fa-home"></i> <span class="nav-label">Dashboard</span> </a>
          </li>
          <li class="">
            <a href="{{ route('student-classroom-enrol') }}"><i class="fa fa-user-plus"></i> <span class="nav-label">Enrol in Classroom</span> </a>
          </li>
          <li class="">
            <a href="{{ route('student-active-attendance') }}"><i class="fa fa-clock-o"></i> <span class="nav-label">Active Attendance</span> </a>
          </li>
      <li>
        <a href="{{ route('logout') }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
      </li>
          @endif
        </ul>

    </div>
</nav>
