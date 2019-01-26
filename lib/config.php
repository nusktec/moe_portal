<?php
/**
 * Created by PhpStorm.
 * User: NSC
 * Date: 10/10/2018
 * Time: 10:22 PM
 */
//error_reporting(0);
date_default_timezone_set('africa/lagos');
ini_set('upload_max_filesize', '10M');

session_start();
require_once("mysqli.class.php");
require_once("systems.php");

const DP_ACCOUNT = "account";
const EMAIL_SUB = "Federal Ministry Of Edu. Portal Reg";
//template headings
const STD_TEMP_OUT = array('ID', 'NAME', 'PARENT NAME', 'PARENT PHONE', 'HOME ADDRESS', 'GENDER', 'AGE', 'CLASS', 'N/A', 'N/A');
const STD_TEMP_DB = array('std_name', 'std_p_name', 'std_p_phone', 'std_address', 'std_gender', 'std_age', 'std_class', 'std_batch_no', 'std_identity', 'std_sign');

//staff (stf_id 	stf_name 	stf_phone 	stf_gender 	stf_subject 	stf_class 	stf_identity 	stf_sign )
const STF_TEMP_OUT = array('ID', 'STAFF_NAME', 'STAFF_PHONE', 'STAFF_GENDER', 'STAFF_SUBJECT', 'STAFF_CLASS', 'N/A');
const STF_TEMP_DB = array('stf_name', 'stf_phone', 'stf_gender', 'stf_subject', 'stf_class', 'stf_identity', 'stf_sign');

//folder names
$PRO_IDENTITIES = "/uploads";

$APP_TMP = @$_SESSION[DP_ACCOUNT];
$info = array(
    'site-name' => 'Federal Ministry Of Education Unity School Portal',
    'site-credit' => 'Ministry Of Eduction',
    'site-min-name' => 'FMOE',
    'descriptions' => 'Federal Ministry Of Eduction Portal',
    'tags' => 'moe,money,transfer,food,buy,school,teachers,assignment',
    'site-url' => '',
    'site-aurthur' => 'Revelation A.F',
    'site-image' => 'logo_img.png',
    'developer' => 'logo_img.png',
);

$config['db_host'] = "localhost";
$config['db_username'] = "root";
$config['db_password'] = "";
$config['db_name'] = "moe_db";

function check_login()
{
    global $PRO_IDENTITIES;
    global $APP_TMP;
    if (empty($APP_TMP)) {
        header("location: login");
        die(0);
    }
    if (!file_exists($PRO_IDENTITIES)) {
        @mkdir($PRO_IDENTITIES);
    }
}

//check to reconcile with tokens
function reConfirmAdmin()
{
    $sid = $_SESSION[DP_ACCOUNT]->acc_num;
    $aphone = $_SESSION[DP_ACCOUNT]->tok_phone;
    $aname = $_SESSION[DP_ACCOUNT]->tok_name;
    $alevel = $_SESSION[DP_ACCOUNT]->tok_level;

    $db = new Db();
    $rd = $db->row("select * from moe_tokens where (tok_identity='$sid' and tok_phone='$aphone') and (tok_name='$aname' and tok_level='$alevel')");
    if (!$rd) {
        session_destroy();
    }
}

function page_identity($menu, $title)
{
    $_SESSION['menu'] = $menu;
    $_SESSION['title'] = $title;
}

//folders
const UPLOADS_FLD = 'uploads';
//mount upload folder
function mountDefaultFolder()
{
    if (!file_exists(UPLOADS_FLD)) {
        mkdir(UPLOADS_FLD);
    }
}

//onLoad
try {
    mountDefaultFolder();
} catch (Exception $e) {
    //die in silence
}