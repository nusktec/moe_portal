<?php
/**
 * Created by PhpStorm.
 * User: NSC
 * Date: 10/14/2018
 * Time: 8:35 AM
 */

//header('Content-Type: application/json');
use SimpleExcel\SimpleExcel;

require_once('lib/SimpleExcel/SimpleExcel.php');

//Druplay output structure
function druplay_output($status = false, $message = "", $meta_data = array(""))
{
    return json_encode(array("status" => $status, "message" => $message, "meta" => $meta_data));
}

//Druplay output structure 2
function druplay_output2($status = false, $message = "", $meta_data = array(""))
{
    return json_encode(array("status" => $status, "message" => $message, "data" => $meta_data));
}


//Druplay output structure 3
function druplay_output3($status = false, $message = "", $meta_data = array(""), $meta_data2 = array(""))
{
    return json_encode(array("status" => $status, "message" => $message, "data1" => $meta_data, "data2" => $meta_data2));
}

//Password validator
function druplay_password($password)
{
    return sha1(base64_encode($password));
}

//Format phone number
function fNumber($phone)
{
    if (empty($phone)) {
        return "";
    }
    $phone_number = preg_replace('/^0/', '234', $phone);
    return str_replace("+", "", $phone_number);
}

//get converted time to human read
function time_elapsed_string($ptime)
{
    if (empty($ptime)) {
        return "No Time";
    }
    $etime = time() - $ptime;

    if ($etime < 1) {
        return '0 seconds';
    }

    $a = array(365 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'min',
        1 => 'sec'
    );
    $a_plural = array('year' => 'years',
        'month' => 'months',
        'day' => 'days',
        'hour' => 'hours',
        'min' => 'min',
        'sec' => 'secs'
    );

    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . '';
        }
    }
}

//get max 36 tokens
function getToken($length, $allow_lowercase = false)
{
    $max = 35;
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "0123456789";
    if ($allow_lowercase) {
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $max = 61;
    }

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[rand(0, $max)];
    }

    return $token;
}

//Excel system
function readCSVArray($fileName = '', $headers = array(), $noColumns = 0, $columnFrom, $bkTrail)
{
    try {
        $excel = new SimpleExcel('csv');
        $excel->parser->loadFile($fileName); //enter your file name here
        $f = $excel->parser->getField();
        //do not execute if file structure does not meet the requirement
        $expectedNoColumn = $noColumns;
        $minNoRows = 10;

        //check for file structure
        if (count($f) < 1 || (count($f[0]) != $expectedNoColumn)) {
            $res = "Corrupted or human tampered data template";
            return array('status' => false, 'data' => $res);
        }
        //check for file structure
        if (count($f) < 2) {
            $res = "No other records in the csv file except the column headings";
            return array('status' => false, 'data' => $res);
        }
        if ((count($f) - 1) < $minNoRows) {
            $res = (count($f) - 1) . " records to small for batch upload, minimum is 10";
            return array('status' => false, 'data' => $res);
        }
        //Compare header and data header
        if (count($headers) != $expectedNoColumn || count($headers) != count($f[0])) {
            $res = "Column structure does not matched with the data template headings";
            return array('status' => false, 'data' => $res);
        }
        //prepare for proper reading
        $repArray = array();
        $output = array();
        $exclude_header = 1; //change to 0 to to start from header //omitting the id column with value 1
        $rowsExecuted = 0;
        for ($i = $exclude_header; $i < count($f); $i++) {
            $rd = $f[$i]; // start reading from all the columns,
            //iterate the arrays headings
            for ($cn = $columnFrom; $cn < $expectedNoColumn; $cn++) {
                $trailN = $cn + $bkTrail;
                if ($trailN != $columnFrom && $trailN == $expectedNoColumn - 1) {
                    break;
                }
                $repArray[$headers[$cn]] = $rd[$trailN];
            }
            $rowsExecuted++;
            //output it well
            array_push($output, $repArray);
        }
        return array('status' => true, 'data' => $output, 'rows' => $rowsExecuted);
    } catch (exception $ex) {
        //tell them your crazy
        $res = "File is damaged. either not supported or invalid file signature";
        return array('status' => false, 'data' => $res);
    }
}

//Download Template
function getTemplate($structure = array(),$suffix='default')
{
    $excel = new SimpleExcel('csv');
    $excel->writer->setData(
        array
        (
            $structure
        )
    );
    $excel->writer->saveFile('template.druplay.'.$suffix);
}

//email sender
function sendEmail($to, $subject, $msg)
{

}

//Get standard unix date stamp
function getDatestamp()
{
    $d = new DateTime();
    return $d->getTimestamp() . "";
}

//display error
function echoError($htmlMsg)
{
    echo druplay_output(false, "<p style='color: #ff2b56'>$htmlMsg</p>", array());

}

//display success
function echoSuccess($htmlMsg, $metaData)
{
    echo druplay_output(true, "<p style='color: #2ece1f'>$htmlMsg</p>", $metaData);
}

//display raw html
function echoRahHtml($htmlMsg)
{
    echo druplay_output(true, $htmlMsg, array());
}

//display notice
function echoWarning($htmlMsg)
{
    echo druplay_output(false, "<p style='color: #e1b931'>$htmlMsg</p>", array());
}