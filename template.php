<?php
/**
 * Created by Druplay Team.
 * User: NSC
 * Date: 10/13/2018
 * Time: 10:51 AM
 */
error_reporting(0);
require('lib/config.php');

$action = $_REQUEST['type'];
if (!empty($action)) {
    downloadTemp();
}

//download templates
function downloadTemp()
{
    switch ($_GET['type']) {
        case 'std':
            getTemplate(STD_TEMP_OUT,'students');
            break;
        case 'stf':
            getTemplate(STF_TEMP_OUT,'staff');
            break;
        default:
            echo "The required template type does't exit...<br><a href='#' onclick='window.close();'>Go back</a> ";
            exit(0);
    }
    return;
}
?>

