<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">

                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        Welcome!
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">@yield('student_name')</strong>
                            </span> <span class="text-muted text-xs block">@yield('student_id')</span>
                        </span>
                    </a>
                </div>

            </li>
            <li class="active">
                <a href="#"><span class="nav-label">Submitted Tests</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                   @yield('submitted_tests')
                </ul>
            </li>

          <li>
            <a href="{{ route('session-logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>
            <form id="logout-form" action="{{ route('session-logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
          </li>
        </ul>

    </div>
</nav>
