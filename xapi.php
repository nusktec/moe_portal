<?php
/**
 * Created by Druplay Team.
 * User: NSC
 * Date: 10/13/2018
 * Time: 10:51 AM
 */

require('lib/config.php');

//special features
//get account system
function getAccID()
{
    return $_SESSION[DP_ACCOUNT]->acc_num;
}

function getRoleID()
{
    return $_SESSION[DP_ACCOUNT]->tok_level;
}

function getStaffKey()
{
    return $_SESSION[DP_ACCOUNT]->tok_key;
}

//my rute start here
$action = $_REQUEST['cmd'];
switch ($action) {
    case 'login':
        loginFunc();
        break;
    case 'reg':
        regNewSchool();
        break;
    case 'sys-pass':
        changePass();
        break;
    case 'remove-admin':
        removeAdmin();
        break;
    case 'std':
        uploadstdData();
        break;
    case 'template-dwn':
        downloadTemp();
        break;
    case 'std-del':
        delRecord();
        break;
    case 'stf-del':
        delSTFRecord();
        break;
    case 'std-upd':
        updateStdRecord();
        break;
    case 'stf-upd':
        updateStfRecord();
        break;
    case 'stf':
        uploadstfData();
        break;
    case 'add-pro':
        addProjects();
        break;
    case 'pro-upd':
        updateProject();
        break;
    case 'del-pro':
        delPRORecord();
        break;
    case 'upl-pic-pro':
        uploadProImage();
        break;
    case 'tok-add':
        addToken();
        break;
    case 'add-facility':
        addFacilities();
        break;
    case 'rmv-facility':
        rmvFacilities();
        break;
    case 'adm-activate':
        activateSchools();
        break;
    case 'adm-generate-code':
        generateCode();
        break;
    default:
        exit(0);
}

function generateCode()
{
    if (getRoleID() != 8) {
        echo druplay_output(false, "<p style='color: #ff2b56'> Unable to update records</p>", array());
        return;
    }
    $db = new Db();
    //making of codes
    for ($i = 0; $i < 20; $i++) {
        $code = rand(1111, 9999) . rand(2222, 8989) . getToken(2);
        $db->insert('moe_access', array('acc_code' => $code));
    }
    echo druplay_output(true, "<p style='color: #2bad0d'>Successfully updated !.</p>", array());
}

//activate and disable schools
function activateSchools()
{
    if (getRoleID() != 8) {
        return;
    }
    $db = new Db();
    $account = $_POST['acc'];
    $email = $_POST['email'];
    $status = $_POST['val'];
    if ((int)$status == 1) {
        $status = (int)0;
    } else {
        $status = (int)1;
    }
    //ready to insert
    $upd = $db->update('accounts', array('status' => $status), array('acc_num' => $account, 'email' => $email));
    if ($upd) {
        echo druplay_output(true, "<p style='color: #2bad0d'>Successfully updated !.</p>", array());
        return;
    }
    //var_dump($db);
    echo druplay_output(false, "<p style='color: #ff2b56'> Unable to update records</p>", array());
    return;
}

//rmv facilities
function rmvFacilities()
{
    foreach ($_POST as $item => $value) {
        if (strlen($value) < 1) {
            echo druplay_output(false, "<p style='color: #ff2b56'>Some box were left blank, fill in appropriately and try again</p>", array());
            return;
        }
    }
    $data = $_POST;
    unset($data['cmd']);
    $sid = getAccID();
    $db = new Db();
    $del = $db->delete('moe_facilities', array('fac_identity' => $sid, 'fac_key' => $_POST['fac_key']));
    if ($del) {
        echo druplay_output(true, "<p style='color: #199d0f; text-align: left'>" . $data['fac_value'] . " has been removed <a href='' >Click to refresh</a> </p>", array());
        return;
    }
    echo druplay_output(false, "<p style='color: #ff2b56'>Unable to add facility</p>", array());
    return;
}

//add facilities
function addFacilities()
{
    foreach ($_POST as $item => $value) {
        if (strlen($value) < 1) {
            echo druplay_output(false, "<p style='color: #ff2b56'>Some box were left blank, fill in appropriately and try again</p>", array());
            return;
        }
    }
    $data = $_POST;
    unset($data['cmd']);
    $data['fac_identity'] = getAccID();
    $db = new Db();
    $ins = $db->insert('moe_facilities', $data);
    if ($ins['status'] == 1) {
        echo druplay_output(true, "<p style='color: #199d0f; text-align: left'>" . $data['fac_value'] . " has been added <a href='' >Click to refresh</a> </p>", array());
        return;
    }
    echo druplay_output(false, "<p style='color: #ff2b56'>Unable to add facility</p>", array());
    return;
}

//add token
function addToken()
{
    //check empty casin
    foreach ($_POST as $item => $value) {
        if (empty($value)) {
            echo druplay_output(false, "<p style='color: #ff2b56'>Some box were left blank, fill in appropriately and try again</p>", array());
            return;
        }
    }
    //start inserting
    $db = new Db();
    $data = $_POST;
    unset($data['cmd']);
    if ($data['tok_level'] == '2') {
        $data['tok_level'] = 0;
    }
    $data['tok_identity'] = getAccID();
    $tokKey = getToken(5);
    $data['tok_key'] = $tokKey;
    //push to db
    $ins = $db->insert('moe_tokens', $data);
    if ($ins['status'] == 1) {
        echo druplay_output(true, "<h4 style='color: #199d0f; text-align: left'>New Admin Added<br><strong>Token Key: $tokKey</strong></h4>", array());
        return;
    }
    echo druplay_output(false, "<p style='color: #ff2b56'>Unable to add more admin\'s at the moment</p>", array());
    return;
    return;
}

//add project images
function uploadProImage()
{
    if (empty($_FILES['upics']) || !is_array($_FILES['upics'])) {
        echo "Unable to add project image";
        return;
    }
    if ($_FILES['upics']['size'] < 5000000) {
        $newname = getAccID() . "_PRO_" . $_REQUEST['id'] . '.jpg';
        move_uploaded_file($_FILES['upics']['tmp_name'], UPLOADS_FLD . "/" . $newname);
        echo druplay_output(true, "<p style='color: #2ece1f'>Uploaded successful</p>", array());
        return;
    }
    echo druplay_output(false, "<p style='color: #ff2b56'>Unable to upload image</p>", array());
    return;
}

//update projects
function updateProject()
{
    //remove files before vlidate
    foreach ($_POST as $item => $value) {
        if (empty($value)) {
            echo druplay_output(false, "<p style='color: #ff2b56'>Some box were left blank, fill in appropriately and try again</p>", array());
            return;
        }
    }
    //other transaction follow
    //std_id 	std_name 	std_p_name 	std_p_phone 	std_address 	std_gender 	std_age 	std_class 	std_batch_no 	std_identity 	std_sign
    $db = new Db();
    $stdData = $_POST;
    /**Remove unuse key**/
    $targetID = $stdData['id'];
    unset($stdData['cmd']);
    unset($stdData['id']);
    unset($stdData['pic']);
    //ready to insert
    $upd = $db->update('moe_projects', $stdData, array('pro_identity' => getAccID(), 'pro_id' => $targetID));
    if ($upd) {
        echo druplay_output(true, "<p style='color: #2bad0d'>Successfully updated !.</p>", array());
        return;
    }
    echo druplay_output(false, "<p style='color: #ff2b56'> Unable to update records</p>", array());
    return;
}

//addproject
function addProjects()
{
    foreach ($_POST as $item => $value) {
        if (empty($value)) {
            echo druplay_output(false, "<p style='color: #ff2b56'> Some box were left blank, fill in appropriately and try again</p>", array());
            return;
        }
    }
    $db = new Db();
    $data = $_POST;
    unset($data['cmd']);
    $data['pro_identity'] = getAccID();
    $data['pro_sign'] = date('y/m/d') . "/" . substr(getStaffKey(), 0, 4);
    $ins = $db->insert('moe_projects', $data);
    if ($ins['status'] == 1) {
        echo druplay_output(true, "<p style='color: #199d0f'> You have successfully added a new project</p>", array());
        return;
    }
    echo druplay_output(false, "<p style='color: #ff2b56'> Unable to add a new project at the moment, try again later</p>", array());
    return;
}

//upload staff data
function uploadstfData()
{
    if ($_REQUEST['batch'] == 'true') {
        if ($_FILES["filed"]["size"] > 5000000) {
            echo druplay_output(false, "File size is too large. < 5mb required", array());
            return;
        }
        //start reading uploaded files
        $file = $_FILES['filed']['tmp_name'];
        //define your csv style and headings
        $ufile = __DIR__ . "/tmp/" . $_SESSION[DP_ACCOUNT]->acc_num . getToken(8, true) . ".csv";
        if (move_uploaded_file($file, $ufile)) {
            $readRaw = readCSVArray($ufile, STF_TEMP_DB, count(STF_TEMP_OUT), 0, 1);
            //logic to determine if whole thing went well
            $insertedRows = 0;
            $totalRows = 0;
            $batchNo = rand(111111, 999999) . "BN";
            $ins = null;
            $db = new Db();
            if ($readRaw['status'] == 1) {
                $read = $readRaw['data'];
                $totalRows = $readRaw['rows'];
                foreach ($read as $key => $value) {
                    $rd = $value;
                    //additional column ('std_batch_no ', 'std_identity', 'std_sign')
                    $rd['stf_identity'] = getAccID();
                    $rd['stf_sign'] = date('y/m/d') . "/" . substr(getStaffKey(), 0, 4);
                    //ready to insert to db;
                    $ins = $db->insert('moe_staffs', $rd);
                    if ($ins['status'] == 1) {
                        $insertedRows++;
                    }
                }
                if ($ins['status'] == 1) {
                    echo druplay_output(true, "<p style='color: #fffafa'>" . $insertedRows . " of " . $totalRows . " rows inserted</p>", array('batch' => "- Batch No: " . $batchNo));
                    unlink($ufile);
                    return;
                }
                echo druplay_output(true, "<p style='color: #fffafa'>Unable to insert all, please check if they exist...</p>", array());
                unlink($ufile);
                return;
            } else {
                echo druplay_output(false, $readRaw['data'], array());
                unlink($ufile);
            }
            return;
        } else {
            echo druplay_output(false, 'Error processing you file. try again !', array());
            return;
        }
    }

    if ($_REQUEST['batch'] == 'false') {
        foreach ($_POST as $item => $value) {
            if (empty($value)) {
                echo druplay_output(false, "<p style='color: #ff2b56'> Some box were left blank, fill in appropriately and try again</p>", array());
                return;
            }
        }
        //std_id 	std_name 	std_p_name 	std_p_phone 	std_address 	std_gender 	std_age 	std_class 	std_batch_no 	std_identity 	std_sign
        $db = new Db();
        $stdData = $_POST;
        /**Remove unuse key**/
        unset($stdData['cmd']);
        unset($stdData['batch']);
        //add other to complete table
        $stdData['stf_identity'] = getAccID();
        $stdData['stf_sign'] = date('y/m/d') . "/" . substr(getStaffKey(), 0, 4);
        //ready to insert
        $ins = $db->insert('moe_staffs', $stdData);
        if ($ins['status'] == 1) {
            echo druplay_output(true, "<p style='color: #2bad0d'>Successfully added.</p>", array());
            return;
        }
        echo druplay_output(false, "<p style='color: #ff2b56'> Unable to add record at the moment. Server is busy</p>", array());
        return;
    }

}

//update staff
function updateStfRecord()
{
    foreach ($_POST as $item => $value) {
        if (empty($value)) {
            echo druplay_output(false, "<p style='color: #ff2b56'> Some box were left blank, fill in appropriately and try again</p>", array());
            return;
        }
    }
    //other transaction follow
    //std_id 	std_name 	std_p_name 	std_p_phone 	std_address 	std_gender 	std_age 	std_class 	std_batch_no 	std_identity 	std_sign
    $db = new Db();
    $stdData = $_POST;
    /**Remove unuse key**/
    $targetID = $stdData['id'];
    unset($stdData['cmd']);
    unset($stdData['id']);
    //ready to insert
    $upd = $db->update('moe_staffs', $stdData, array('stf_identity' => getAccID(), 'stf_id' => $targetID));
    if ($upd) {
        echo druplay_output(true, "<p style='color: #2bad0d'>Successfully updated !.</p>", array());
        return;
    }
    //var_dump($db);
    echo druplay_output(false, "<p style='color: #ff2b56'> Unable to update records</p>", array());
    return;
}


//update students
function updateStdRecord()
{
    foreach ($_POST as $item => $value) {
        if (empty($value)) {
            echo druplay_output(false, "<p style='color: #ff2b56'> Some box were left blank, fill in appropriately and try again</p>", array());
            return;
        }
    }
    //other transaction follow
    //std_id 	std_name 	std_p_name 	std_p_phone 	std_address 	std_gender 	std_age 	std_class 	std_batch_no 	std_identity 	std_sign
    $db = new Db();
    $stdData = $_POST;
    /**Remove unuse key**/
    $targetID = $stdData['id'];
    unset($stdData['cmd']);
    unset($stdData['id']);
    //ready to insert
    $upd = $db->update('moe_students', $stdData, array('std_identity' => getAccID(), 'std_id' => $targetID));
    if ($upd) {
        echo druplay_output(true, "<p style='color: #2bad0d'>Successfully updated !.</p>", array());
        return;
    }
    echo druplay_output(false, "<p style='color: #ff2b56'> Unable to update records</p>", array());
    return;
}

//method to delete project records
function delPRORecord()
{
    foreach ($_POST as $item => $value) {
        if (empty($value)) {
            echo druplay_output(false, "<p style='color: #ff2b56'> Some box were left blank, fill in appropriately and try again</p>", array());
            return;
        }
    }
    //proceed to delete
    $db = new Db();
    $del = $db->delete('moe_projects', array('pro_id' => $_REQUEST['id'], 'pro_identity' => @$_SESSION[DP_ACCOUNT]->acc_num));
    if ($del) {
        echo druplay_output(true, "Successfully removed !", array());
        $newname = UPLOADS_FLD . "/" . getAccID() . "_PRO_" . $_REQUEST['id'] . '.jpg';
        unlink($newname);
        return;
    }
    echo druplay_output(true, "Unable to removed", array());
    return;
}

//method to delete staff records
function delSTFRecord()
{
    foreach ($_POST as $item => $value) {
        if (empty($value)) {
            echo druplay_output(false, "<p style='color: #ff2b56'> Some box were left blank, fill in appropriately and try again</p>", array());
            return;
        }
    }
    //proceed to delete
    $db = new Db();
    $del = $db->delete('moe_staffs', array('stf_id' => $_REQUEST['id'], 'stf_identity' => @$_SESSION[DP_ACCOUNT]->acc_num));
    if ($del) {
        echo druplay_output(true, "Successfully removed !", array());
        return;
    }
    echo druplay_output(true, "Unable to remove", array());
    return;
}

//method to delete records
function delRecord()
{
    foreach ($_POST as $item => $value) {
        if (empty($value)) {
            echo druplay_output(false, "<p style='color: #ff2b56'> Some box were left blank, fill in appropriately and try again</p>", array());
            return;
        }
    }
    //proceed to delete
    $db = new Db();
    $del = $db->delete('moe_students', array('std_id' => $_REQUEST['id'], 'std_identity' => @$_SESSION[DP_ACCOUNT]->acc_num));
    if ($del) {
        echo druplay_output(true, "Successfully removed !", array());
        return;
    }
    echo druplay_output(true, "Unable to removed", array());
    return;
}

//upload students data
function uploadstdData()
{
    if ($_REQUEST['batch'] == 'true') {
        if ($_FILES["filed"]["size"] > 5000000) {
            echo druplay_output(false, "File size is too large. < 5mb required", array());
            return;
        }
        //start reading uploaded files
        $file = $_FILES['filed']['tmp_name'];
        //define your csv style and headings
        $ufile = __DIR__ . "/tmp/" . $_SESSION[DP_ACCOUNT]->acc_num . getToken(8, true) . ".csv";
        if (move_uploaded_file($file, $ufile)) {
            $readRaw = readCSVArray($ufile, STD_TEMP_DB, count(STD_TEMP_OUT), 0, 1);
            //logic to determine if whole thing went well
            $insertedRows = 0;
            $totalRows = 0;
            $batchNo = rand(111111, 999999) . "BN";
            $ins = null;
            $db = new Db();
            if ($readRaw['status'] == 1) {
                $read = $readRaw['data'];
                $totalRows = $readRaw['rows'];
                foreach ($read as $key => $value) {
                    $rd = $value;
                    //additional column ('std_batch_no ', 'std_identity', 'std_sign')
                    $rd['std_batch_no'] = $batchNo;
                    $rd['std_identity'] = getAccID();
                    $rd['std_sign'] = date('y/m/d') . "/" . substr(getStaffKey(), 0, 4);
                    //ready to insert to db;
                    $ins = $db->insert('moe_students', $rd);
                    if ($ins['status'] == 1) {
                        $insertedRows++;
                    }
                }
                if ($ins['status'] == 1) {
                    echo druplay_output(true, "<p style='color: #fffafa'>" . $insertedRows . " of " . $totalRows . " rows inserted</p>", array('batch' => "- Batch No: " . $batchNo));
                    unlink($ufile);
                    return;
                }
                echo druplay_output(true, "<p style='color: #fffafa'>Unable to insert all, please check if they exist...</p>", array());
                unlink($ufile);
                return;
            } else {
                echo druplay_output(false, $readRaw['data'], array());
                unlink($ufile);
            }
            return;
        } else {
            echo druplay_output(false, 'Error processing you file. try again !', array());
            return;
        }
    }

    if ($_REQUEST['batch'] == 'false') {
        foreach ($_POST as $item => $value) {
            if (empty($value)) {
                echo druplay_output(false, "<p style='color: #ff2b56'> Some box were left blank, fill in appropriately and try again</p>", array());
                return;
            }
        }
        //std_id 	std_name 	std_p_name 	std_p_phone 	std_address 	std_gender 	std_age 	std_class 	std_batch_no 	std_identity 	std_sign
        $db = new Db();
        $stdData = $_POST;
        /**Remove unuse key**/
        unset($stdData['cmd']);
        unset($stdData['batch']);
        //add other to complete table
        $stdData['std_identity'] = getAccID();
        $stdData['std_sign'] = date('y/m/d') . "/" . substr(getStaffKey(), 0, 4);
        //ready to insert
        $ins = $db->insert('moe_students', $stdData);
        if ($ins['status'] == 1) {
            echo druplay_output(true, "<p style='color: #2bad0d'>Successfully added.</p>", array());
            return;
        }
        echo druplay_output(false, "<p style='color: #ff2b56'> Unable to add record at the moment. Server is busy</p>", array());
        return;
    }

}

//remove admin's from db
function removeAdmin()
{
    foreach ($_POST as $item => $value) {
        if (empty($value)) {
            echo druplay_output(false, "Command was incorrect", array());
            return;
        }
    }
    //remove from db
    $sid = $_SESSION[DP_ACCOUNT]->acc_num;
    $db = new Db();
    $rm = $db->delete('moe_tokens', array('tok_phone' => $_POST['ph'], 'tok_identity' => $sid, 'tok_level' => 0));
    if ($rm) {
        echo druplay_output(true, "Admin removed, refresh to update table", array());
        return;
    }
    echo druplay_output(false, "No action was done", array());
    return;
}

//Change password
function changePass()
{
    foreach ($_POST as $item => $value) {
        if (empty($value)) {
            echo druplay_output(false, "<p style='color: #ff2b56'>One of the field is empty</p>", array());
            return;
        }
    }
    if ($_POST['pass1'] != $_POST['pass2']) {
        echo druplay_output(false, "<p style='color: #ff2b56'>Password not the same</p>", array());
        return;
    }
    //check for password strength
    if (strlen($_POST['pass1']) < 6) {
        echoError("<i class='fa fa-lock'></i> Password too short, minimum is 6");
        return;
    }
    if (druplay_password($_POST['old_pass']) != $_SESSION[DP_ACCOUNT]->pass) {
        echo druplay_output(false, "<p style='color: #ff2b56'>Old password is incorrect</p>", array());
        return;
    }
    //start validating lkey
    $db = new Db();
    $pass = druplay_password($_POST['pass1']);
    $pass_old = druplay_password($_POST['old_pass']);
    $upd = $db->update('accounts', array('pass' => $pass), array('pass' => $pass_old, 'acc_num' => getAccID()));
    if ($upd) {
        echo druplay_output(true, "<p style='color: #4567ff'>System will determine your details and perform an auto sign-out if everything went okay !</p>", array());
        session_destroy();
        return;
    }
    echo druplay_output(false, "<p style='color: #ff2b56'>Old password  not correct, try again</p>", array());
}

//register new school
function regNewSchool()
{
    foreach ($_POST as $item => $value) {
        if (empty($value)) {
            echo druplay_output(false, "<p style='color: #ff2b56'> Some box were left blank, fill in appropriately and try again</p>", array());
            return;
        }
    }

    $db = new Db();

    //everything goes well
    $sphone = fNumber($_POST['sphone']);
    $sname = $_POST['sname'];
    $semail = $_POST['semail'];
    $saddress = $_POST['saddress'];
    $sstate = $_POST['sstate'];
    $sshort = $_POST['sshort'];
    //Admin data
    $aname = $_POST['aname'];
    $aphone = fNumber($_POST['aphone']);
    //Password data
    $spass1 = $_POST['pass1'];
    $spass2 = $_POST['pass2'];
    //system access code
    $gac = strtoupper($_POST['ac']);

    //check for phone validity
    if (!is_numeric($sphone) || !is_numeric($aphone)) {
        echoError("<i class='fa fa-phone'></i> One of the phone number went in-appropriate");
        return;
    }

    //check for password
    if ($spass1 != $spass2) {
        echoError("<i class='fa fa-lock'></i> Password does not look alike");
        return;
    }

    //check for password strength
    if (strlen($spass1) < 6) {
        echoError("<i class='fa fa-lock'></i> Password too short, minimum is 6");
        return;
    }
    //check for access code validity
    $check_account = $db->row("select * from `moe_access` where `acc_code`='$gac' and `acc_used`=0  limit 1");
    if (!$check_account) {
        echoError("<i class='fa fa-key'></i> Not a valid access code");
        return;
    }
    //Prepare an insert...
    $schData = array('name' => $sname, 'email' => $semail, 'pass' => druplay_password($spass1), 'address' => $saddress, 'phone' => $sphone, 'acc_num' => $gac, 'lastseen' => getDatestamp(), 'state' => $sstate, 'abbre' => $sshort);
    $inss = $db->insert('accounts', $schData);
    if ($inss['status'] == 1) {
        //Inserted
        //Now set to update access code
        $upd_ac = $db->update('moe_access', array('acc_used' => 1, 'acc_date' => date('Y-m')), array('acc_code' => $gac));
        if ($upd_ac == 1) {
            //now insert admin data
            $token_key = getToken(6) . '';
            $adminData = array('tok_name' => $aname, 'tok_identity' => $gac, 'tok_phone' => $aphone, 'tok_key' => $token_key, 'tok_level' => 1);
            $insa = $db->insert('moe_tokens', $adminData);
            if ($insa['status'] == 1) {
                //admin inserted successfully
                //send mail
                sendEmail($semail, EMAIL_SUB, "Your Login Details<br>Access Code: " . $gac . "<br>Password: " . $spass1 . "<br>Token: " . $token_key . "<br>Please keep it safe and don't share");
                //prepare success msg
                $success = '<div class="media bg-pattern radius border shadow" style="padding: 10px">
                        <div class="media-left"><i class="fa fa-check fa-5x text-gredient2 text-shadow1"></i></div>
                        <div class="media-body">
                            <h4>Registration Okay !</h4>
                            <p>Copy the details below</p>
                            <h5>Access Code: ' . $gac . '</h5>
                            <h5>Password: Use Password</h5>
                            <h5>Token: ' . $token_key . '</h5>
                        </div>
                    </div>';
                echoRahHtml($success);
                return;
            } else {
                //don't kill the silence mode
                echoWarning("<i class='fa fa-arrow-right'></i> Registration was okay, but something went wrong. Contact us");
                return;
            }
        }
        return;
    }
    if ($inss['status'] == 2) {
        //duplicates data
        echoError("<i class='fa fa-times'></i> School account already exist, please contact us to rectify any issue");
        return;
    }
}

//Login systems
function loginFunc()
{
    foreach ($_POST as $item => $value) {
        if (empty($value)) {
            echo druplay_output(false, "<p style='color: #ff2b56'>" . ucfirst($item) . " is empty</p>", array());
            return;
        }
    }
    //start validating lkey
    if (strlen($_POST['password']) < 6) {
        echo druplay_output(false, "<p style='color: red'>Please check your details and try again</p>", array());
        return;
    }
    $db = new Db();
    $acc = strtoupper($_POST['account']);
    $tkn = strtoupper($_POST['token']);
    $pass = druplay_password($_POST['password']);
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
            echo druplay_output(true, "<p style='color: #10b200'>Welcome, Please wait...</p>", array());
            return;
        }
    }
    echo druplay_output(false, "<p style='color: #ff0015'>Invalid account, token or password</p>", array());
}