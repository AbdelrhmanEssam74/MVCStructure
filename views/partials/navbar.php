<nav id="main-navbar" class="navbar navbar-expand-md  navbar-before-scroll shadow-0">

<div class="container-fluid">
        <a class="navbar-brand" href="/">
            <span class="fw-bold ">MVC Structure</span>
        </a>
        <button class="navbar-toggler border" type="button" data-bs-toggle="collapse" data-bs-target="#nav_lc"
                aria-controls="nav_lc" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav_lc">
            <ul class="d-none d-lg-flex navbar-nav mx-auto  my-3 my-lg-0 position-absolute top-50 start-50 translate-middle">
                <li class="nav-item me-4"><a class="nav-link " href="#">About</a></li>
                <li class="nav-item me-4"><a class="nav-link " href="#">Services</a></li>
                <li class="nav-item"><a class="nav-link " href="#">Testimonials</a></li>
            </ul>
            <ul class="navbar-nav my-3 my-lg-0 d-lg-none">
                <li class="nav-item me-4"><a class="nav-link " href="#">About</a></li>
                <li class="nav-item me-4"><a class="nav-link " href="#">Services</a></li>
                <li class="nav-item"><a class="nav-link " href="#">Testimonials</a></li>
            </ul>
            <div class="ms-lg-auto">
                <?php if(!app()->session->exists('login')):?>
                <a class="btn btn-outline-primary me-2 " href="/login">Login</a>
                <a class="btn btn-primary" href="/signup">Sign Up</a>
                <?php else:?>
                <a class="btn btn-danger" href="/logout">Logout</a>
                <?php endif;?>
            </div>
        </div>
    </div>
</nav>