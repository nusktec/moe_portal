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
//read from db;
if ($_SESSION[DP_ACCOUNT]->tok_level!=1) {
    echo '<h3>You do not have permission to change system password</h3>';
    exit(0);
}
?>
<div id="appupd">
    <h3>Change system password</h3>
    <hr/>
    <div class="tab-pane active" id="add-records">
        <form id="passForm" method="post" onsubmit="return updateSingle()">
            <div class="row" style="padding-top: 10px">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="bmd-label-floating">Old Password</label>
                        <input name="old_pass" value="" type="password" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="bmd-label-floating">New Password</label>
                        <input value="" name="pass1" type="password"
                               class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="bmd-label-floating">Confirm New Password</label>
                        <input value="" name="pass2" type="password"
                               class="form-control">
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div id="updatemsg" style="width: 100%; text-align: right" v-html="resp.msg"></div>
            </div>
            <button type="submit" class="btn btn-danger pull-right btn-round">Change Password</button>
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
    var msg = {msg: 'No data on cue'};
    var app2 = new Vue({
        el: '#appupd',
        data: {resp: msg}
    });

    //single record update
    function updateSingle() {
        NProgress.start();
        msg.msg = "Please wait...";
        $.ajax({
            type: "POST",
            url: "xapi",
            data: $('#passForm').serialize() + '&cmd=sys-pass',
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.status) {
                    msg.msg = obj.message;
                    $('#passForm')[0].reset();
                    setTimeout(function () {
                        window.location.reload(true);
                    },5000);
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