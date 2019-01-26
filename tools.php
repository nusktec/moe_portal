<?php require('lib/config.php');
page_identity(5, "Tools");

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
    <?php require('dash.nav.php') ?>


    <!-- Main content here -->
    <div class="content pt-lg-5" id="app">

        <div class="container-fluid">
            <h3>System control and Administrative Tools</h3>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-footer">
                            <div class="margin15">
                                <h4>Add more staff to the system</h4>
                            </div>
                            <!--Contents-->
                            <a rel="modal:open" title="Action" href="plug.modal.assignstaff?cmd=true"
                               class="btn btn-success btn-round"><i class="fa fa-user"></i> Assign Admin</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-footer">
                            <div class="margin15">
                                <h4>Change System Password</h4>
                            </div>
                            <!--Contents-->
                            <a rel="modal:open" href="plug.modal.password?cmd=true"
                               class="btn btn-danger btn-round"><i class="fa fa-key"></i> Change Password</a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-footer">
                            <div class="margin15">
                                <h4>Live chat with our technical team</h4>
                            </div>
                            <!--Contents-->
                            <a title="Action" href="#"
                               class="btn btn-warning btn-round"><i class="fa fa-send"></i> Chat With Us</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-footer">
                            <div class="margin15">
                                <h4>Send us a mail</h4>
                            </div>
                            <!--Contents-->
                            <a href="mailto:tech@education.gov.ng"
                               class="btn btn-info btn-round"><i class="fa fa-mail-forward"></i> Send A Mail</a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-footer">
                            <div class="margin15">
                                <h4>Get an approved hard copy of your data</h4>
                            </div>
                            <!--Contents-->
                            <a title="Action" href="#"
                               class="btn btn-primary btn-round"><i class="fa fa-send"></i> Request RawData</a>
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
        })
        //page loading
        NProgress.start();


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
                    alert(data);
                    var obj = JSON.parse(data);
                    if (obj.status) {
                        msg.rma = obj.message;
                        window.location.href = 'dashboard';
                        NProgress.done();
                        return;
                    }
                    msg.rma = obj.message;
                    NProgress.done();
                }
            });
            return false;
        }


        //stop evry when page finishes loading
        $(document).ready(function () {
            NProgress.done();
        });
    </script>
