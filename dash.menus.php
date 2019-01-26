<?php
//admin script controller
check_login();
function getRoleGlo()
{
    return $_SESSION[DP_ACCOUNT]->tok_level;
}

?>

<div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="green" data-image="assets/img/sidebar-1.jpg">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

          Tip 2: you can also add an image using data-image tag
      -->
        <div class="logo">
            <a href="dashboard" class="simple-text logo-normal">
                <img width="64" src="images/<?php echo $info['site-image']; ?>"><br>
                <small style="font-size: 12px">Portal Identity</small>
                <br/><strong>AC: <?php echo @$_SESSION[DP_ACCOUNT]->acc_num; ?></strong>
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <?php
                if (getRoleGlo() != 8){
                ?>
                <li data-color="green" class="nav-item <?php echo ($_SESSION['menu'] == 0) ? ' active' : ''; ?>">
                    <a class="nav-link" href="dashboard">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($_SESSION['menu'] == 1) ? ' active' : ''; ?>">
                    <a class="nav-link" href="students">
                        <i class="fa fa-users"></i>
                        <p>Maanage Students</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($_SESSION['menu'] == 2) ? ' active' : ''; ?>">
                    <a class="nav-link" href="staffs">
                        <i class="fa fa-user"></i>
                        <p>Manage Staffs</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($_SESSION['menu'] == 3) ? ' active' : ''; ?>">
                    <a class="nav-link" href="facilities">
                        <i class="fa fa-gears"></i>
                        <p>Manage Facilities</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($_SESSION['menu'] == 4) ? ' active' : ''; ?>">
                    <a class="nav-link" href="projects">
                        <i class="fa fa-home"></i>
                        <p>PTA Projects</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($_SESSION['menu'] == 5) ? ' active' : ''; ?>">
                    <a class="nav-link" href="tools">
                        <i class="fa fa-gear"></i>
                        <p>Tools</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($_SESSION['menu'] == 6) ? ' active' : ''; ?>">
                    <a class="nav-link" href="subscription">
                        <i class="fa fa-credit-card-alt"></i>
                        <p>Subscription</p>
                    </a>
                </li>
            </ul>
            <?php
            } else {
                ?>
                <li class="nav-item <?php echo ($_SESSION['menu'] == 7) ? ' active' : ''; ?>">
                    <a class="nav-link" href="admin.dash">
                        <i class="fa fa-list"></i>
                        <p>List Schools</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($_SESSION['menu'] == 8) ? ' active' : ''; ?>">
                    <a class="nav-link" href="admin.dash.access">
                        <i class="fa fa-key"></i>
                        <p>Schools Access</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($_SESSION['menu'] == 9) ? ' active' : ''; ?>">
                    <a class="nav-link" href="admin.dash.code">
                        <i class="fa fa-arrow-right"></i>
                        <p>Generate Access Code</p>
                    </a>
                </li>
                <?php
            }
            ?>
        </div>
    </div>