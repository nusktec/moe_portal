<?php
/**
 * Created by PhpStorm.
 * User: NSC
 * Date: 1/25/2019
 * Time: 2:36 AM
 */
require('lib/config.php');

$getAC = @$_GET['acc'];
$getKey = @$_GET['key'];

if(empty($getAC)||empty($getKey)){
    echo "Invalid session data";
    return;
}

$db = new Db();

//read from db and fill the gaps
$token = $db->row("select * from moe_tokens where tok_level=1 and tok_identity='$getAC'");

$acc = $getAC;
$tkn = $token->tok_key;
$pass = $getKey;
$rd = $db->row("select * from accounts ac, moe_tokens tok where ac.acc_num='$acc' and ac.pass='$pass' and tok.tok_identity='$acc' and tok.tok_key='$tkn'");
if ($rd) {
    if ($rd->status == 0) {
        echo druplay_output(false, "<p style='color: red'>Your account has been blocked, please contact us</p>", (array)$rd);
        return;
    }
    if ($rd->status == 2) {
        echo druplay_output(false, "<p style='color: blue'>Your account has not been confirmed, please contact the administrator</p>", (array)$rd);
        return;
    }
    if ($rd->status == 1) {
        @session_start();
        $_SESSION[DP_ACCOUNT] = $rd;
        header("location: dashboard");
        return;
    }
}
echo druplay_output(false, "<p style='color: #ff0015'>Invalid account, token or password</p>", array());