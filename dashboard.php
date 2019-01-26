<?php require('lib/config.php');
page_identity(0, "Dashboard");

//import modules
include 'modules.php';
?>
<!DOCTYPE html>
<html lang="en">

<!--Import your head here-->
<?php require('dash.header.js.php'); ?>

<body class="">
<!--Menus here-->
<?php require('dash.menus.php'); ?>

<div class="main-panel">
    <!-- Navbar -->
    <?php require('dash.nav.php');
    if (getRole() == 8) {
        ?>
        <script>
            window.location.href = 'admin.dash';
        </script>
        <?php
        return;
    }
    ?>

    <!-- Main content here -->
    <div class="content pt-lg-5" id="app">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <p class="card-category">Total Students</p>
                            <h3 class="card-title">
                                <?php $rec = @getAny("moe_students", "std_identity")->num_rows;
                                echo ($rec == 0) ? '0' : $rec; ?>
                            </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="fa fa-arrow-right text-success"><a style="color: green; font-family: Arial;"
                                                                             href="students"> Manage Records</a></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-pills card-header-icon">
                            <div class="card-icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <p class="card-category">Total Staffs</p>
                            <h3 class="card-title"><?php $rec = @getAny("moe_staffs", "stf_identity")->num_rows;
                                echo ($rec == 0) ? '0' : $rec; ?></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="fa fa-arrow-right text-gray"><a style="color: gray; font-family: Arial;"
                                                                          href="staffs"> Manage Records</a></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-danger card-header-icon">
                            <div class="card-icon">
                                <i class="fa fa-gears"></i>
                            </div>
                            <p class="card-category">School Facilities</p>
                            <h3 class="card-title">
                                <?php $rec = @getAny("moe_facilities", "fac_identity")->num_rows;
                                echo ($rec == 0) ? '0' : $rec; ?>
                            </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="fa fa-arrow-right text-danger"><a style="color: #ff114b; font-family: Arial;"
                                                                            href="facilities"> Manage Records</a></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="fa fa-home"></i>
                            </div>
                            <p class="card-category">PTA Projects</p>
                            <h3 class="card-title">
                                <?php $rec = @getAny("moe_projects", "pro_identity")->num_rows;
                                echo ($rec == 0) ? '0' : $rec; ?>
                            </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="fa fa-arrow-right text-info"><a style="color: #26c6da; font-family: Arial;"
                                                                          href="projects"> Manage Records</a></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-tabs card-header-success">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <span class="nav-tabs-title">Data Summary:</span>
                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#students" data-toggle="tab">
                                                <i class="fa fa-users"></i> Students
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#staffs" data-toggle="tab">
                                                <i class="fa fa-user"></i> Staffs
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#pta" data-toggle="tab">
                                                <i class="fa fa-home"></i> PTA Projects
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#facilities" data-toggle="tab">
                                                <i class="fa fa-gears"></i> Facilities
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="students"
                                     style="max-height: 400px; overflow-y: scroll;">
                                    <table class="table">
                                        <tbody>
                                        <thead class=" text-success">
                                        <tr>
                                            <th>
                                                ID
                                            </th>
                                            <th>
                                                Name
                                            </th>
                                            <th>
                                                Gender
                                            </th>
                                            <th>
                                                Class
                                            </th>
                                            <th>
                                                School
                                            </th>
                                            <th>
                                                Sign
                                            </th>
                                        </tr>
                                        </thead>
                                        <?php getListStudents(20) ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane" id="staffs" style="max-height: 400px; overflow-y: scroll;">
                                    <table class="table">
                                        <tbody>
                                        <thead class=" text-success">
                                        <tr>
                                            <th>
                                                ID
                                            </th>
                                            <th>
                                                Name
                                            </th>
                                            <th>
                                                Gender
                                            </th>
                                            <th>
                                                Phone
                                            </th>
                                            <th>
                                                Subject
                                            </th>
                                            <th>
                                                Class
                                            </th>
                                        </tr>
                                        </thead>
                                        <?php getListStaff(20) ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane" id="pta" style="max-height: 400px; overflow-y: scroll;">
                                    <table class="table">
                                        <tbody>
                                        <thead class=" text-success">
                                        <tr>
                                            <th>
                                                ID
                                            </th>
                                            <th>
                                                Project Name
                                            </th>
                                            <th>
                                                Project By
                                            </th>
                                            <th>
                                                Cost
                                            </th>
                                            <th>
                                                Date
                                            </th>
                                            <th>
                                                Image
                                            </th>
                                        </tr>
                                        </thead>
                                        <?php getListProject(50) ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane" id="facilities" style="max-height: 400px; overflow-y: scroll;">
                                    <table id="mytable" class="table">
                                        <thead class="text-success">
                                        <tr>
                                            <th>
                                                ID
                                            </th>
                                            <th>
                                                Facility Group
                                            </th>
                                            <th>
                                                Facility Name
                                            </th>
                                            <th>
                                                School
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php getListFactQuery(20, "") ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Admin's Stats</h4>
                            <small class="card-category">Staff here can also maanage the portal</small>
                            <small class="pull-right card-category" v-html="resp.rma"></small>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover">
                                <thead class="text-info">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Level</th>
                                <th>Actions</th>
                                </thead>
                                <tbody>
                                <!--iterate admins data here-->
                                <?php getAllAdmins(); ?>
                                <!--End of iterations-->
                                </tbody>
                            </table>
                            <small class="card-category"><a rel="modal:open" href="plug.modal.assignstaff?cmd=true"
                                                            class="text_white">Add More Admins</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('dash.footer.php') ?>
    <script>
        var msg = {rma: 'No Action'};
        //instantiate vue.js
        var app = new Vue({
            el: '#app',
            data: {resp: msg}
        });

        //remove admin's
        function removeAdmin(phone) {
            var conf = confirm("Are you sure to remove the selected admin ?");
            if (!conf) {
                return;
            }
            NProgress.start();
            msg.rma = "<i class='fa fa-refresh druplay_rotate' ></i> Please wait !";
            $.ajax({
                type: "POST",
                url: "xapi",
                data: {cmd: 'remove-admin', ph: phone},
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.status) {
                        msg.rma = obj.message;
                        NProgress.done();
                        return;
                    }
                    msg.rma = obj.message;
                    NProgress.done();
                }
            });
            return false;
        }

    </script>
