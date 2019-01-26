<?php require('lib/config.php');
page_identity(4, "Projects");

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
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-tabs card-header-info">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#add-records" data-toggle="tab">
                                                <i class="fa fa-plus"></i> Add New Record
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#manage-data" data-toggle="tab">
                                                <i class="fa fa-pencil"></i> Manage Records
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
                                <div class="tab-pane active" id="add-records">
                                    <form id="proform" onsubmit="return addProjects()">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Project Name</label>
                                                    <input name="pro_name" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Project By</label>
                                                    <input name="pro_by" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Project Start Date</label>
                                                    <input name="pro_s_date" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Project End Date</label>
                                                    <input name="pro_e_date" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">PTA Phone</label>
                                                    <input name="pro_phone" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Project Cost &#8358;</label>
                                                    <input name="pro_cost" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Project Location</label>
                                                    <input name="pro_address" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="bmd-label-floating"></label>
                                                <select class="form-control" name="pro_state">
                                                    <option value="" selected="selected">- Select State -</option>
                                                    <option value="Abuja FCT">Abuja FCT</option>
                                                    <option value="Abia">Abia</option>
                                                    <option value="Adamawa">Adamawa</option>
                                                    <option value="Akwa Ibom">Akwa Ibom</option>
                                                    <option value="Anambra">Anambra</option>
                                                    <option value="Bauchi">Bauchi</option>
                                                    <option value="Bayelsa">Bayelsa</option>
                                                    <option value="Benue">Benue</option>
                                                    <option value="Borno">Borno</option>
                                                    <option value="Cross River">Cross River</option>
                                                    <option value="Delta">Delta</option>
                                                    <option value="Ebonyi">Ebonyi</option>
                                                    <option value="Edo">Edo</option>
                                                    <option value="Ekiti">Ekiti</option>
                                                    <option value="Enugu">Enugu</option>
                                                    <option value="Gombe">Gombe</option>
                                                    <option value="Imo">Imo</option>
                                                    <option value="Jigawa">Jigawa</option>
                                                    <option value="Kaduna">Kaduna</option>
                                                    <option value="Kano">Kano</option>
                                                    <option value="Katsina">Katsina</option>
                                                    <option value="Kebbi">Kebbi</option>
                                                    <option value="Kogi">Kogi</option>
                                                    <option value="Kwara">Kwara</option>
                                                    <option value="Lagos">Lagos</option>
                                                    <option value="Nassarawa">Nassarawa</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Ogun">Ogun</option>
                                                    <option value="Ondo">Ondo</option>
                                                    <option value="Osun">Osun</option>
                                                    <option value="Oyo">Oyo</option>
                                                    <option value="Plateau">Plateau</option>
                                                    <option value="Rivers">Rivers</option>
                                                    <option value="Sokoto">Sokoto</option>
                                                    <option value="Taraba">Taraba</option>
                                                    <option value="Yobe">Yobe</option>
                                                    <option value="Zamfara">Zamfara</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Project Desc</label>
                                                        <textarea name="pro_desc" class="form-control"
                                                                  rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-html="res.pro" class="clearfix"></div>
                                        <button type="submit" class="btn btn-info pull-right">Add Project</button>
                                    </form>
                                </div>

                                <!--manage data-->
                                <div class="tab-pane" id="manage-data">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Search any here...</label>
                                        <input id="searchany" type="text" class="form-control">
                                    </div>
                                    <div style="max-height: 500px; overflow-y: auto; width: 100%">
                                        <table id="mytable" class="table">
                                            <thead class="text-success">
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
                                                    Phone
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
                                                <th>
                                                    Sign
                                                </th>
                                                <th>
                                                    Action
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php getListProjectQuery(50000, "") ?>
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
        var msg = {pro: 'No Action'};
        //instantiate vue.js
        var app = new Vue({
            el: '#app',
            data: {res: msg}
        })
        //page loading
        NProgress.start();


        //remove admin's
        function addProjects() {
            NProgress.start();
            msg.pro = "<i class='fa fa-refresh druplay_rotate' ></i> Please wait !";
            $.ajax({
                type: "POST",
                url: "xapi",
                data: $('#proform').serialize() + '&cmd=add-pro',
                success: function (data) {
//                    alert(data);
                    var obj = JSON.parse(data);
                    if (obj.status) {
                        msg.pro = obj.message;
                        NProgress.done();
                        $('#proform')[0].reset();
                        return;
                    }
                    msg.pro = obj.message;
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
