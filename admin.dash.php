<?php require('lib/config.php');
page_identity(7, "Administrator");

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

<div class="main-panel" style="background-color: white">
    <!-- Navbar -->
    <?php require('dash.nav.php');
    if (getRole() != 8) {
        echo "Global administrator only";
        exit(0);
    }
    ?>


    <!-- Main content here -->
    <!-- Main content here -->
    <div class="content pt-lg-5" id="app">

        <div class="container-fluid">
            <h3>Manage Registered Schools</h3>

            <div class="row">

                <div>
                    <div class="form-group bmd-form-group">
                        <label class="bmd-label-floating">Search any here...</label>
                        <input id="searchany" type="text" class="form-control">
                    </div>
                    <div class="col-lg-12" style="max-height: 1024px; overflow-y: auto; width: 100%">
                        <table id="mytable" class="table" style="width: 100%">
                            <thead class="text-success">
                            <tr>
                                <th>
                                    ID
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Access Code
                                </th>
                                <th>
                                    School Phone
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    State
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Admin Name
                                </th>
                                <th>
                                    Admin Key
                                </th>
                                <th>
                                    Days
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php getListSchoolQuery(50000); ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('dash.footer.php'); ?>
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
            new TableSearch('searchany', 'mytable', {noResultsText: 'Nothing found !'}).init();
        });
    </script>
