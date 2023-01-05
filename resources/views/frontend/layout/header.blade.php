<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{route('home')}}">
            <img src="{{asset("images/logo.png")}}" alt="Logo" width="150px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

            </ul>
            @guest
                <div class="form-inline my-2 my-lg-0">
                    <a href="{{route("login")}}" class="btn btn-dark mr-2 px-4">Login</a>
                    <a href="{{route("register")}}" class="btn btn-outline-dark">Register</a>
                </div>
            @else
                <div class="form-inline my-2 my-lg-0">
                    <a href="{{route('dashboard')}}" class="btn btn-dark mr-2 px-4">Dashboard</a>
                </div>
            @endguest
        </div>
    </nav>
</header>
