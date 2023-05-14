<?php
session_start();
$resArray = array();

$ReferenceNo = $_POST['ReferenceNo'];
$files = $_FILES['file']['name'];
// Count the number of uploaded files in array
$tmpFilePath = $_FILES['file']['tmp_name'];
//A file path needs to be present
if ($tmpFilePath != ""){
    //Setup our new file path
    $filename = $ReferenceNo.'.webp';
    $newFilePath = "../images/payment/".$filename;
    //File is uploaded to temp dir
    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
        array_push($resArray,$newFilePath);
    }
}
echo json_encode($resArray);
