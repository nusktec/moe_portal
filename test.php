<?php
/**
 * Created by PhpStorm.
 * User: NSC
 * Date: 11/12/2018
 * Time: 2:16 PM
 */

use SimpleExcel\SimpleExcel;

require_once('lib/SimpleExcel/SimpleExcel.php');

//Excel system
function readCSVArray($fileName = '', $headers = array(), $noColumns = 0, $columnFrom)
{
    try {
        $excel = new SimpleExcel('csv');
        $excel->parser->loadFile($fileName); //enter your file name here
        $f = $excel->parser->getField();
        //do not execute if file structure does not meet the requirement
        $expectedNoColumn = $noColumns;
        $minNoRows = 2;

        //check for file structure
        if (count($f) < 1 || (count($f[0]) > $expectedNoColumn)) {
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
                $repArray[$headers[$cn]] = $rd[$cn];
            }
            $rowsExecuted++;
            //output it well
            array_push($output, $repArray);
        }
        return array('status' => true, 'data' => $output, 'rows' => $rowsExecuted);
    } catch (exception $ex) {
        //tell them your crazy
        $res = "File is damaged or not a supported file type. May be it doesn't exist";
        return array('status' => false, 'data' => $res);
        return;
    }
}

//$readAll = readCSVArray("testbook.csv", array('ID','NAME','PHONE','EMAIL','STATE','BATCH_NO'),6,1);
//if($readAll['status']==1){
//$read = $readAll['data'];
//foreach ($read as $key =>$value){
//    $rd = $value;
//    $rd['BATCH_NO']=rand(11111,99999).'';
//    print_r($rd);
//    break;
//}
//}else{
//    echo $readAll['data'];
//}

function druplay_password($password)
{
    return sha1(base64_encode($password));
}

echo druplay_password("123456");