<?php
    session_start();
    require("../connection/db.php");
    $RequestID = $_POST['RequestID'];
    $UserID = $_POST['UserID'];
    $result = "";
    $query = "UPDATE request_form SET Status = 1 WHERE ID = $RequestID";
    if ($mysqli->query($query)) {

        $queryNotification = "INSERT INTO notification(UserID,Title,Description,Status)
        VALUES ('$UserID','Request Update','Confirmed Request','Confirmed')";
        $mysqli->query($queryNotification);

        $result = $RequestID;
    }
    else{
        $result = "Error";
    }

    echo json_encode($result);
?>