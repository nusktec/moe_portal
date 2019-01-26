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
$id = @$_REQUEST['id'];
if (empty($id)) {
    echo '<h3>No Records found (WA) !</h3>';
    exit(0);
}
//read from db
$sid = @$_SESSION[DP_ACCOUNT]->acc_num;
$db = new Db();
$rd = $db->row("select * from moe_students where std_identity='$sid' and std_id=$id");
if (!$rd) {
    echo '<h3>No Records found !</h3>';
    exit(0);
}
?>
<div id="appupd">
    <h3>Edit and Update</h3>
    <hr/>
    <div class="tab-pane active" id="add-records">
        <form id="updateForm" method="post" onsubmit="return updateSingle()">
            <div class="row" style="padding-top: 10px">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Full name</label>
                        <input name="std_name" value="<?php echo $rd->std_name; ?>" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Parent full name</label>
                        <input value="<?php echo $rd->std_p_name; ?>" name="std_p_name" type="text"
                               class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Parent Phone</label>
                        <input value="<?php echo $rd->std_p_phone; ?>" name="std_p_phone" type="text"
                               class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Age (eg: 12)</label>
                        <input value="<?php echo $rd->std_age; ?>" name="std_age" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="bmd-label-floating">Address</label>
                        <input value="<?php echo $rd->std_address; ?>" name="std_address" type="text"
                               class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-control" name="std_gender">
                            <option value="<?php echo $rd->std_gender; ?>"
                                    selected><?php echo $rd->std_gender; ?></option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="std_class" type="text" class="form-control">
                            <option value="<?php echo $rd->std_class; ?>"
                                    selected><?php echo $rd->std_class; ?></option>
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
            </div>
            <div class="row col-md-12">
                <div id="updatemsg" style="width: 100%; text-align: right" v-html="resp.err2"></div>
            </div>
            <a onclick="deleteRecord()" style="color: white;" class="btn btn-danger pull-left">Delete Record</a>
            <button type="submit" class="btn btn-success pull-right">Update Record</button>
        </form>
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
        max-width: 800px;
    }
</style>

<script>
    //single record delete
    function deleteRecord() {
        var ask = confirm("Are you sure to permanently delete this record ?");
        if (!ask) {
            return;
        }
        NProgress.start();
        msg.err = "<i class='fa fa-refresh druplay_rotate' ></i> Please wait !";
        $.ajax({
            type: "POST",
            url: "xapi",
            data: {cmd: 'std-del', id: <?php echo $id; ?>},
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.status) {
                    alert("Deleted !");
                    window.location.reload(true);
                    NProgress.done();
                    return;
                }
                return false;
            }
        });
        return false;
    }

    //single record update
    function updateSingle() {
        NProgress.start();
        $.ajax({
            type: "POST",
            url: "xapi",
            data: $('#updateForm').serialize() + '&cmd=std-upd&id=<?php echo $id; ?>',
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.status) {
                    alert("Updated !");
                    window.location.reload(true);
                    NProgress.done();
                    return;
                }
                return false;
            }
        });
        return false;
    }
</script>
<!--End of modal class calling-->