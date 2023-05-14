<?php
    session_start();
    require("../connection/db.php");
    $RequestID = $_POST['RequestID'];
    $Description = $_POST['Description'];
    $UserID = $_POST['UserID'];
    $result = "";
    $query = "INSERT INTO tracking(RequestID,Description)
    VALUES ('$RequestID','$Description')";
    if ($mysqli->query($query)) {
        $queryNotification = "INSERT INTO notification(UserID,Title,Description,Status)
        VALUES ('$UserID','Tracking Update','Request Tracking','Tracking')";
        $mysqli->query($queryNotification);
        $result = $RequestID;
    }
    else{
        $result = "Error";
    }

    echo json_encode($result);
?>