<?php 
    session_start();
    $resArray = array();
    $files = $_FILES['file']['name'];

    $tmpFilePath = $_FILES['file']['tmp_name'];

    if ($tmpFilePath != "") {
        $fileName = "rodfiltayong".'.webp';
        $newFilePath = "../images/payment/".$fileName;

        if (move_uploaded_file($tmpFilePath,$newFilePath)) {
            array_push($resArray,$newFilePath);
        }
    }

    echo json_encode($resArray);
?>