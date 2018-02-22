

<header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">



        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <li class="{{ Request::is('/') ? 'active' : '' }}" >
                    <a class="navbar-brand" href="{{url('/')}}" >
                        <i class="fas fa-leaf" style="font-size:20px; color:forestgreen"></i>
                        OutDoorSpot
                    </a>
                </li>

                <li class="nav-item" style="font-size:20px;" >
                    <a class="nav-link" href="#">Post</a>
                </li>
                <li class="nav-item" style="font-size:20px;">
                    <a class="nav-link" href="#">Parameter</a>
                </li>
                <li class="nav-item" style="font-size:20px;">
                    <a class="nav-link disabled" href="#">Search</a>
                </li>
            </ul>
        </div>
    </nav>

</header>

