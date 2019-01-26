<?php require('lib/config.php');
page_identity(2, "Manage Staff");

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
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-tabs card-header-success">
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
                                                <i class="fa fa-pencil"></i> Manage Staff Records
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
                                    <form id="addStfForm" method="post" onsubmit="return addSingle()">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Full name</label>
                                                    <input name="stf_name" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Staff Phone</label>
                                                    <input name="stf_phone" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select class="form-control" name="stf_gender">
                                                        <option value="" selected>Pick a gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select name="stf_class" type="text" class="form-control">
                                                        <option value="" selected>Choose Class</option>
                                                        <option value="primary-1">Primary 1</option>
                                                        <option value="primary-2">Primary 2</option>
                                                        <option value="primary-3">Primary 3</option>
                                                        <option value="primary-4">Primary 4</option>
                                                        <option value="primary-5">Primary 5</option>
                                                        <option value="primary-6">Primary 6</option>
                                                        <option value="JSS-1">JSS 1</option>
                                                        <option value="JSS-2">JSS 2</option>
                                                        <option value="JSS-3">JSS 3</option>
                                                        <option value="SSSC-1">SSSC 1</option>
                                                        <option value="SSSC-2">SSSC 2</option>
                                                        <option value="SSSC-3">SSSC 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Subject</label>
                                                    <input type="text" class="form-control" name="stf_subject"/>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success pull-right">Add New Staff</button>
                                        <div class="clearfix" v-html="resp.err"></div>
                                    </form>
                                </div>

                                <!--management start here-->
                                <div class="tab-pane" id="manage-data">
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
                                                <th>
                                                    Sign
                                                </th>
                                                <th>
                                                    Action
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php getListStaffQuery(50000, "") ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Tools Center (Staffs)</h4>
                            <p class="card-category">Download your system template for your data processing</p>
                        </div>
                        <div class="card-body">
                            <h6 class="card-category text-gray">Excel CSV (Comma Delimiter Type Only)</h6>
                            <a href="template?type=stf" target="_blank"
                               class="btn btn-success"><i class="fa fa-download"></i> Download Now</a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Batch Upload {{resp.batchNo}}</h4>
                            <p class="card-category">Upload more than a single record (Excel Sheet) </p>
                        </div>
                        <div class="card-body">
                            <h6 class="card-category text-gray">Data Processing Tips</h6>
                            <p class="card-description">
                            <li>Record must not less than 10 rows</li>
                            <li>Supported file type is (Excel CSV comma delimiter)</li>
                            <li>Do not create or add additional column to the template</li>
                            <li>Verify that the system has successfully processed your data using your session batch
                                code)
                            </li>
                            <li>Always refresh your browser after successful response, to confirm your data</li>
                            </p>
                            <input style="display: none" type="file" name="filed" id="filed" accept=".csv"/>
                            <a href="javascript:void(0);" onclick="$('#filed').trigger('click');"
                               class="btn btn-outline pull-left"><i class="fa fa-magnet"></i> Select File</a>
                            <a id="bupl" href="javascript:void(0);" onclick="startUploading();"
                               class="btn btn-success pull-right"><i class="fa fa-upload"></i> Upload</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <?php require('dash.footer.php') ?>
    <script>
        var msg = {rma: 'No Action', batchNo: '- Batch No: XXXXXXXX', err: 'No data on cue', err2: 'No Changes'};
        //instantiate vue.js
        var app = new Vue({
            el: '#app',
            data: {resp: msg}
        });

        //single record insert
        function addSingle() {
            NProgress.start();
            msg.err = "<i class='fa fa-refresh druplay_rotate' ></i> Please wait !";
            $.ajax({
                type: "POST",
                url: "xapi",
                data: $('#addStfForm').serialize() + '&cmd=stf&batch=false',
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.status) {
                        $('#addStfForm')[0].reset();
                        msg.err = obj.message;
//                        window.location.href = 'students';
                        NProgress.done();
                        return;
                    }
                    msg.err = obj.message;
                    NProgress.done();
                    return false;
                }
            });
            return false;
        }

        //Batch upload here
        var ready = false;
        $('#filed').change(function () {
            //file uploader
            showalert("Ready to upload", "info", "add_alert");
            $('#bupl').html('Start Upload');
            ready = true;
        });

        //start uploading
        function startUploading() {
            if (!ready) {
                showalert("Nothing to upload", "danger", "add_alert");
                return;
            }
            $('#bupl').html('Uploading...');
            $('#bupl').prop('disabled', true);
            $('#filed').simpleUpload("xapi?cmd=stf&batch=true", {

                start: function (file) {
                    //upload started
                    showalert("Upload has started !", "warning", "stop");
                },
                progress: function (progress) {
                    //received progress
                    $('#bupl').html('Uploading ' + parseInt(progress, 10) + "%");
                },
                success: function (data) {
                    //upload successful
                    $('#bupl').html('Done !');
                    var obj = JSON.parse(data);
                    if (obj.status) {
                        showalert(obj.message, "success", "check");
                        $('#bupl').prop('disabled', false);
                        $('#bupl').html('Upload More');
                        msg.batchNo = obj.meta.batch;
                        ready = false;
                    } else {
                        showalert(obj.message, "warning", "check");
                        $('#bupl').prop('disabled', false);
                        ready = false;
                    }
                },
                error: function (error) {
                    //upload failed
                    showalert("Failed to upload data !", "danger", "times");
                }

            });
        }

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

       //declare my search instance here
        $(document).ready(function () {
            new TableSearch('searchany', 'mytable', { noResultsText: 'Nothing found !' }).init();
        });
    </script>
