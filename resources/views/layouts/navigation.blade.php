
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/">Employees</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Home</a>
            </li>
            @if (Auth::check())
                <li class="nav-item active">
                    <a class="nav-link" href="/employees">Search</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/employees/create">Add employee</a>
                </li>
            @endif
        </ul>
        <div>
            @if (Auth::guest())
                <a href="{{ route('login') }}" class="btn btn-success">Login</a>
                <a href="{{ route('register') }}" class="btn btn-success">Register</a>
            @else
                <a href="{{ route('logout') }}" class="btn btn-success"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                   Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @endif
        </div>
    </div>
</nav>