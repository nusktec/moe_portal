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
if ($_SESSION[DP_ACCOUNT]->tok_level != 1) {
    echo '<h3>You do not have permission to change system password</h3>';
    exit(0);
}
//fetch sub validity
$db = new Db();
$sid = $_SESSION[DP_ACCOUNT]->acc_num;
$rd = $db->row("select * from `moe_access` where acc_code='$sid'");
if (!$rd) {
    echo '<h3>Not a valid account !</h3>';
    exit(0);
}
$date = $rd->acc_date;
$year = explode("-", $date)[0];
$mth = explode("-", $date)[1];
?>
<div id="appupd">
    <h3>Subscription Validity</h3>
    <div class="tab-pane active" id="add-records">
        <table class="table">
            <tbody>
            <tr>
                <th>Date Subscribed</th>
                <td><?php echo $year . " - " . $mth ?></td>
            </tr>
            <tr>
                <th>Recurring Date</th>
                <td><?php echo ((int)$year + 1) . " - " . $mth ?></td>
            </tr>
            <tr>
                <th>Month(s) Remaining</th>
                <td><?php
                    $mth = (int)$mth;
                    $curm = (int)date('m');
                    $rem = 0;
                    if ($curm > $mth) {
                        $rem = $curm - $mth;
                    }else{
                        $rem = $mth - $curm;
                    }
                    $rem = 12 - $rem;
                    echo $rem . " months(s) remaining";
                    ?></td>
            </tr>
            </tbody>
        </table>
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

</script>
<!--End of modal class calling-->