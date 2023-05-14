<?php
    session_start();
    require("../connection/db.php");
    $RecordID = $_POST['RecordID'];
    $result = "";

    $query = "UPDATE users SET Status = 1 WHERE ID = $RecordID";
    if ($mysqli->query($query)) {

        $queryNotification = "INSERT INTO notification(UserID,Title,Description,Status)
        VALUES ('$RecordID','Account Update','User Approval','Approved')";
        $mysqli->query($queryNotification);
        $result = $RecordID;
    }
    else{
        $result = "Error";
    }

    echo json_encode($result);
?>