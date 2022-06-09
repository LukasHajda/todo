<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand nav-log" href="{{ route('index') }}">Scheduler</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Items</a>
            </li>
        </ul>

            <ul class="navbar-nav float-lg-right">
                <li>
                    <a class="nav-link dropdown-toggle" href="#" id="user" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Username
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user">
                        <form class="form-inline my-2 my-lg-0" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">
                                Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
    </div>
</nav>