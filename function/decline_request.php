<?php
    session_start();
    require("../connection/db.php");
    $RequestID = $_POST['RequestID'];
    $UserID = $_POST['UserID'];
    $Reason = $_POST['Reason'];
    $result = "";
    $query = "UPDATE request_form SET Status = 4,Reason = '$Reason' WHERE ID = $RequestID";
    if ($mysqli->query($query)) {
        $queryNotification = "INSERT INTO notification(UserID,Title,Description,Status)
        VALUES ('$UserID','Request Form','Decline Request','Decline')";
        $mysqli->query($queryNotification);
        $result = $RequestID;
    }
    else{
        $result = "Error";
    }

    echo json_encode($result);
?>