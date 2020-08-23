<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/tgx-cinemas/Jaloliddin/Admin/AdminDashboard.php">TGX Cinemas</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage Movies</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="">Add New Movie</a>
                    <a class="dropdown-item" href="/tgx-cinemas/Jaloliddin/FetchMovieDetails.php">Display Existing Movie</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage Cinemas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="">Add Cinema Details</a>
                    <a class="dropdown-item" href="/tgx-cinemas/Jaloliddin/Cinema.php">Display Cinema Details</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage Promotions
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="">Add Promotion</a>
                    <a class="dropdown-item" href="">Update Promotion</a>
                    <a class="dropdown-item" href="">Delete Promotion</a>
                </div>
            </li>
        </ul>
        <div class="md-form my-0">
            <form action="Logout.php">
                <a href="/tgx-cinemas/Jaloliddin/Admin/Logout.php" class="btn btn-light"><strong>Logout</strong></a>
            </form>
        </div>
    </div>
</nav>