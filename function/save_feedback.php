<?php
    session_start();
    require("../connection/db.php");
    $UserID = $_POST['UserID'];
    $Remarks = $_POST['Remarks'];
    $Emoticon = $_POST['Emoticon'];
    $RequestID = $_POST['RequestID'];
  
    $result = "";

    $query = "INSERT INTO feedback(UserID,Remarks,Emoticon,RequestID)
    VALUES ('$UserID','$Remarks','$Emoticon','$RequestID')";

    if ($mysqli->query($query)) {
        $result = $mysqli->insert_id;
        $queryUpdate = "UPDATE request_form SET IsRated = 1 WHERE ID = $RequestID";
        $mysqli->query($queryUpdate);
    }
    else{
        $result = "Error";
    }
    echo json_encode($result);
?>