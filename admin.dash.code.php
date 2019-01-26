<?php require('lib/config.php');
page_identity(9, "Generate Access Code");

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
    <div class="content pt-lg-5" id="app">

        <div class="container-fluid">
            <h3>Access Code</h3>
            <a onclick="generateCode()" href="javascript:void()" class="btn btn-primary">Generate More 20 Codes</a>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="card card-stats">
                        <div>
                            <div class="col-lg-12" style="max-height: 1024px; overflow-y: auto; width: 100%">
                                <h5>New Access Code</h5>
                                <table class="table" style="width: 100%">
                                    <thead class="text-success">
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Access Code
                                        </th>
                                        <th>
                                            Status
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php getListAccessCodesNew(50000); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="card card-stats">
                        <div class="card-footer">
                            <div>
                                <h5>Used Access Code</h5>
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
                                                Access Code
                                            </th>
                                            <th>
                                                Status
                                            </th>
                                            <th>
                                                Used By
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php getListAccessCodes(50000); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
        function generateCode() {
            var conf = confirm("Are you sure to generate more 20 new codes ?");
            if (!conf) {
                return;
            }
            NProgress.start();
            msg.rma = "<i class='fa fa-refresh druplay_rotate' ></i> Please wait !";
            $.ajax({
                type: "POST",
                url: "xapi",
                data: {cmd: 'adm-generate-code'},
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.status) {
                        msg.rma = obj.message;
                        window.location.href = 'admin.dash.code';
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
