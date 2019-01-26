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
$id = @$_REQUEST['cmd'];
if (empty($id)) {
    echo '<h3>No Access !</h3>';
    exit(0);
}
//read from db
$sid = @$_SESSION[DP_ACCOUNT]->acc_num;
$db = new Db();
$acc = (empty($_SESSION[DP_ACCOUNT]->acc_num)) ? 'NODATA' : $_SESSION[DP_ACCOUNT]->acc_num;
$rd = $db->query("select * from moe_tokens where tok_identity='$acc'");
if ($rd->num_rows >= 5) {
    echo '<h3>You have reach the maximum no. of admin\'s !</h3>';
    exit(0);
}
?>
<div id="appupd">
    <h3>Add More Admin's</h3>
    <hr/>
    <div class="tab-pane active" id="add-records">
        <form id="tokenForm" method="post" onsubmit="return updateSingle()">
            <div class="row" style="padding-top: 10px">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Full name</label>
                        <input name="tok_name" value="" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Phone</label>
                        <input value="" name="tok_phone" type="text"
                               class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="bmd-label-floating">Level</label>
                        <select name="tok_level" type="text" class="form-control">
                            <option value="1">Global Admin</option>
                            <option selected value="2">Just Admin</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="card" id="updatemsg" style="width: 100%; text-align: right" v-html="resp.succ"></div>
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div id="updatemsg" style="width: 100%; text-align: right" v-html="resp.msg"></div>
            </div>
            <button type="submit" class="btn btn-success pull-right btn-round">Add New Admin</button>
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
    var msg = {msg: 'No data on cue', succ: ''};
    var app2 = new Vue({
        el: '#appupd',
        data: {resp: msg}
    });

    //single record update
    function updateSingle() {
        NProgress.start();
        msg.succ = "Please wait...";
        $.ajax({
            type: "POST",
            url: "xapi",
            data: $('#tokenForm').serialize() + '&cmd=tok-add',
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.status) {
                    msg.succ = obj.message;
                    $('#tokenForm')[0].reset();
                    NProgress.done();
                    return;
                }
                msg.msg = obj.message;
                NProgress.done();
                return false;
            }
        });
        return false;
    }
</script>
<!--End of modal class calling-->