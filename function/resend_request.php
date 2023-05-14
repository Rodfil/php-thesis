<?php
    session_start();
    require("../connection/db.php");
    $RecordID = $_POST['RecordID'];
    $UserID = $_POST['UserID'];
    $result = "";
    $query = "UPDATE request_form SET Status = 0 WHERE ID = $RecordID";
    if ($mysqli->query($query)) {

        $queryNotification = "INSERT INTO notification(UserID,Title,Description,Status)
        VALUES ('$UserID','Request Form','Resend Request','Resend')";
        $mysqli->query($queryNotification);

        $result = $RecordID;
    }
    else{
        $result = "Error";
    }

    echo json_encode($result);
?>