<?php require('lib/config.php');
page_identity(3, "Facilities");

//import modules
include 'modules.php';

//import facilities
include 'db.facilities.php';
global $facArray;

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
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-tabs card-header-success">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#add-items" data-toggle="tab">
                                                <i class="fa fa-plus"></i> Add New Item
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#manage-items" data-toggle="tab">
                                                <i class="fa fa-pencil"></i> Manage Items
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <!--Add new records-->
                                <div class="tab-pane active" id="add-items">

                                    <h3>Choose only the available items in your school</h3>
                                    <small v-html="resp.rma"></small>
                                    <hr/>
                                    <div class="row">
                                        <!--iterate from arrays-->
                                        <?php
                                        foreach ($facArray as $key => $value){
                                            ?>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="card card-stats">
                                                    <div class="card-footer">
                                                        <div class="margin15">
                                                            <h3><?php echo $value; ?></h3>
                                                            <small>Click to add this item to your facility group</small>
                                                        </div>
                                                        <!--Contents-->
                                                        <?php
                                                        if (!factExist($key)){
                                                            ?>
                                                            <a title="Action" href="javascript:void(0)"
                                                               class="btn btn-outline-success btn-round" onclick="addFacility('<?php echo $key; ?>','<?php echo $value; ?>')"><i
                                                                        class="fa fa-plus"></i> Add</a>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <a onclick="rmvFacility('<?php echo $key; ?>','<?php echo $value; ?>')" title="Action" href="javascript:void(0)"
                                                               class="btn btn-danger btn-round"><i
                                                                        class="fa fa-times"></i> Remove</a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                </div>

                                <!--manage data-->
                                <div class="tab-pane" id="manage-items">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Search any here...</label>
                                        <input id="searchany" type="text" class="form-control">
                                    </div>
                                    <div style="max-height: 500px; overflow-y: auto; width: 100%">
                                        <table id="mytable" class="table" >
                                            <thead class="text-success">
                                            <tr>
                                                <th>
                                                    ID
                                                </th>
                                                <th>
                                                    Facilities Group
                                                </th>
                                                <th>
                                                    Facilities Name
                                                </th>
                                                <th>
                                                    School
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php getListFactQuery(50000, "") ?>
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
    </div>

    <?php require('dash.footer.php') ?>
    <script>
        var msg = {rma: 'No Action'};
        //instantiate vue.js
        var app = new Vue({
            el: '#app',
            data: {resp: msg}
        });
        //page loading
        NProgress.start();

        //add facility
        function addFacility(key,value) {
            NProgress.start();
            msg.rma = "<i class='fa fa-refresh druplay_rotate' ></i> Please wait !";
            $.ajax({
                type: "POST",
                url: "xapi",
                data: {cmd: 'add-facility', fac_key: key, fac_value: value},
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.status) {
                        msg.rma = obj.message;
                        NProgress.done();
                        window.location.reload(true);
                        return;
                    }
                    msg.rma = obj.message;
                    NProgress.done();
                }
            });
            return false;
        }

        //remove facility
        function rmvFacility(key,value) {
            NProgress.start();
            msg.rma = "<i class='fa fa-refresh druplay_rotate' ></i> Please wait !";
            $.ajax({
                type: "POST",
                url: "xapi",
                data: {cmd: 'rmv-facility', fac_key: key, fac_value: value},
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.status) {
                        msg.rma = obj.message;
                        NProgress.done();
                        window.location.reload(true);
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
            new TableSearch('searchany', 'mytable', { noResultsText: 'Nothing found !' }).init();
        });
    </script>
