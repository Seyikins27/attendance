<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            @if(session()->get('config')!=null)
            <li><a href="{{ route('session-logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"> <span class="nav-label">Logout</span></a>
                <form id="logout-form" action="{{ route('session-logout') }}" method="POST" style="display: none;">
                @csrf </form></li>
            @else
             <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"> <span class="nav-label">Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf </form></li>    
            @endif    
        </ul>
    </nav>
</div>
