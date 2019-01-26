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
$rd = $db->row("select * from moe_projects where pro_identity='$sid' and pro_id=$id");
if (!$rd) {
    echo '<h3>No Records found !</h3>';
    exit(0);
}
?>
<div id="app-modal">
    <h3>Edit and Update</h3>
    <hr/>
    <div class="tab-pane active" id="add-records">
        <?php
        $newname = UPLOADS_FLD."/".$rd->pro_identity."_PRO_".$_REQUEST['id'].'.jpg';
        if(file_exists($newname)){
            ?>
        <img style="width: 160px; height: 100px;" src="<?php echo $newname; ?>">
        <?php
        }
        ?>
        <hr/>
        <form id="proform-upd" onsubmit="return updateSingle()">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="bmd-label-floating">Project Name</label>
                        <input value="<?php echo $rd->pro_name ?>" name="pro_name" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">Project By</label>
                        <input value="<?php echo $rd->pro_by ?>" name="pro_by" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="bmd-label-floating">Project Start Date</label>
                        <input value="<?php echo $rd->pro_s_date ?>" name="pro_s_date" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="bmd-label-floating">Project End Date</label>
                        <input value="<?php echo $rd->pro_e_date ?>" name="pro_e_date" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">PTA Phone</label>
                        <input value="<?php echo $rd->pro_phone ?>" name="pro_phone" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Project Cost &#8358;</label>
                        <input value="<?php echo $rd->pro_cost ?>" name="pro_cost" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Project Location</label>
                        <input value="<?php echo $rd->pro_address ?>" name="pro_address" type="text"
                               class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="bmd-label-floating"></label>
                    <select class="form-control" name="pro_state">
                        <option value="<?php echo $rd->pro_state ?>"
                                selected="selected"><?php echo $rd->pro_state ?></option>
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
                        <label class="bmd-label-floating">Project Desc</label>
                        <textarea id="desc" name="pro_desc" class="form-control"
                                  rows="3"><?php echo $rd->pro_desc ?></textarea>
                        <input accept=".jpg,.jpeg,.png" type="file" id="upics" name="upics" style="display: none;">
                    </div>
                </div>
            </div>
            <div v-html="msg.msg" class="clearfix"></div>
            <a href="#" onclick="deleteRecord()">Delete Project</a>
            <a  id="bupl" onclick="$('#upics').trigger('click')" style="color: white" class="btn btn-warning pull-right"><i
                        class="fa fa-camera"></i> Add Project Image</a>
            <button type="submit" class="btn btn-info pull-right">Update Project</button>
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
        max-width: 900px;
    }
</style>

<script>
    var msg = {msg: 'No data on cue'}
    var app = new Vue({
        el: '#app-modal',
        data: {msg: msg}
    });

    //uploads image
    $('#upics').change(function () {
        $('#upics').simpleUpload("xapi?cmd=upl-pic-pro&id=<?php echo $id; ?>", {

            start: function (file) {
                //upload started
//                showalert("Upload has started !", "warning", "stop");
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
                    $('#bupl').prop('disabled', false);
                    msg.msg = obj.message;
                    ready = false;
                } else {
                    $('#bupl').prop('disabled', false);
                    ready = false;
                }
            },
            error: function (error) {
                //upload failed
//                showalert("Failed to upload data !", "danger", "times");
            }

        });
    });

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
            data: {cmd: 'del-pro', id: <?php echo $id; ?>},
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
        msg.msg = "Updating, please wait....";
        NProgress.start();
        $.ajax({
            type: "POST",
            url: "xapi",
            data: $('#proform-upd').serialize() + '&cmd=pro-upd&id=<?php echo $id; ?>',
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.status) {
                    msg.msg = obj.message;
                    NProgress.done();
                    return;
                }
                msg.msg = obj.message;
                return false;
            }
        });
        return false;
    }

    $(document).ready(function () {
//        $('#desc').froalaEditor();
    });
</script>
<!--End of modal class calling-->