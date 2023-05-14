<?php
session_start();
$resArray = array();
$UserID = $_POST['UserID'];
$filesNum = count($_FILES['file']['name']);
for ($i = 0; $i < $filesNum; $i++) {
    $filename = $UserID.'.webp';
    $tmpFilePath = $_FILES['file']['tmp_name'][$i];
    $newFilePath = "../images/profile/".$filename;
    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
        array_push($resArray,$newFilePath);
    }
}
echo json_encode($resArray);
