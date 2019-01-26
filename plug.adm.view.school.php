<style>
    .blocker {
        z-index: 9999;
    }

    .close-modal {
        z-index: 99999;
        margin: 15px;
    }

    .modal {
        max-width: 800px;
    }
</style>
<!--Modal class calling-->
<?php
//import controller
require_once('lib/config.php');
//start reading...
$id = @$_REQUEST['acc'];
if (empty($id)) {
    echo '<h3>No Access !</h3>';
    exit(0);
}
//read from db
$sid = $_REQUEST['acc'];
$db = new Db();
$rd = $db->row("select * from accounts where acc_num='$sid'");
if (!$rd) {
    echo '<h3>No such account found !</h3>';
    exit(0);
}

function getDataDb($table,$col){
    global $sid;
    $db = new Db();
    return $db->query("select * from $table where $col='$sid'");
}
?>

<div class="content pt-lg-5" id="app">

    <div class="container-fluid">
        <h3>Manage: <?php echo $rd->name ?></h3>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-footer">
                        <div class="margin15">
                            <h4>
                                <?php
                                $std = getDataDb("moe_students","std_identity");
                                echo "All the registered no of students: ".$std->num_rows;
                                ?>
                            </h4>
                        </div>
                        <!--Contents-->
                        <a rel="modal:open" title="Action" href="#"
                           class="btn btn-success btn-round"><i class="fa fa-print"></i> Print Data</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-footer">
                        <div class="margin15">
                            <h4>
                                <?php
                                $stf = getDataDb("moe_staffs","stf_identity");
                                echo "Total no of staff(s): ".$stf->num_rows;
                                ?>
                            </h4>
                        </div>
                        <!--Contents-->
                        <a rel="modal:open" href="#"
                           class="btn btn-danger btn-round"><i class="fa fa-print"></i> Print Data</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-footer">
                        <div class="margin15">
                            <h4>
                                <?php
                                $pro = getDataDb("moe_projects","pro_identity");
                                echo "Total no of PTA project(s): ".$pro->num_rows;
                                ?>
                            </h4>
                        </div>
                        <!--Contents-->
                        <a rel="modal:open" href="#"
                           class="btn btn-primary btn-round"><i class="fa fa-print"></i> Print Data</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-footer">
                        <div class="margin15">
                            <h4>
                                <?php
                                $fac = getDataDb("moe_facilities","fac_identity");
                                echo "Total no of facilities(s): ".$fac->num_rows;
                                ?>
                            </h4>
                        </div>
                        <!--Contents-->
                        <a rel="modal:open" href="#"
                           class="btn btn-info btn-round"><i class="fa fa-print"></i> Print Data</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<style>
    .blocker {
        z-index: 9999;
    }

    .close-modal {
        z-index: 99999;
        margin: 15px;
    }

    .modal {
        max-width: 90%;
    }
</style>