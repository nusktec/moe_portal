<nav class="navbar navbar-expand-lg  navbar-absolute fixed-top bg-success">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="col-md-12 centered left text-left">
                <h3>Federal Ministry Of Education Unity School Portal</h3>
                <small><?php echo $_SESSION[DP_ACCOUNT]->tok_name; ?> Logged In :</small>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
<!--            <form class="navbar-form">-->
<!--                <div class="input-group no-border">-->
<!--                    <input type="text" value="" class="form-control" placeholder="Search...">-->
<!--                    <button type="submit" class="btn btn-white btn-round btn-just-icon">-->
<!--                        <i class="material-icons">search</i>-->
<!--                        <div class="ripple-container"></div>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </form>-->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-sign-out"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="logout">LogOut Now</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                <?php echo getNotification(); ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="material-icons">person</i>
                        <p class="d-lg-none d-md-block">
                            Account
                        </p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>