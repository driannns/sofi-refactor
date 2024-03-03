<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="/home">
        <img class="navbar-brand-full" src="{{ asset('images/telkom.png') }}" width="30" height="30"
             alt="InfyOm Logo">
        <img class="navbar-brand-minimized" src="{{ asset('images/telkom.png') }}" width="30"
             height="30" alt="InfyOm Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav ml-auto">
        <li class="c-header-nav-item dropdown d-md-down-none mx-2">
            <a class="c-header-nav-link" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="c-icon icon-bell"></i>
                <span class="badge badge-pill badge-danger">{{ count(Auth::user()->unreadNotifications) }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0" style="height:300px; overflow-y:scroll">
                <div class="dropdown-header bg-light"><strong>You have {{ count(Auth::user()->unreadNotifications) }} new notification</strong></div>
                @foreach(auth()->user()->unreadNotifications as $notif)
                <a class="dropdown-item" href="{{ $notif->data['actionURL'] }}">
                    <div class="message">
                        <div class="py-3 mfe-3 float-left">
                            <div class="c-icon"><i class="c-icon icon-bell"></i></div>
                        </div>
                        <div><small class="text-muted"> {{$notif->data['created_by']}} </small><small class="text-muted float-right mt-1">{{ $notif->created_at }}</small></div>
                        <div class="text-truncate font-weight-bold">{{$notif->data['title']}}</div>
                        <div class="small text-muted text-truncate">{{$notif->data['message']}}</div>
                    </div>
                </a>
                @endforeach
            <a class="dropdown-item text-center border-top" href="{{ Url('notification') }}"><strong>View all notification</strong></a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link font-weight-bold" style="margin-right: 40px" data-toggle="dropdown" href="#" role="button"
               aria-haspopup="true" aria-expanded="false">
                {{ ucwords(Auth::user()->nama) }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" style="margin-right: 40px">
                <div class="dropdown-header text-center">
                    <strong>Account</strong>
                </div>
                <a href="{{ url('/logout') }}" class="dropdown-item btn btn-default btn-flat"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i>Logout
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</header>
