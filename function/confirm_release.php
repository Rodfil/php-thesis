<?php
    session_start();
    require("../connection/db.php");
    $RequestID = $_POST['RequestID'];
    $UserID = $_POST['UserID'];
    $ReleasedBy = $_SESSION['UserID'];
    $result = "";
    $query = "UPDATE request_form SET ReleasedBy = $ReleasedBy, Status = 5 WHERE ID = $RequestID";
    if ($mysqli->query($query)) {

        $queryNotification = "INSERT INTO notification(UserID,Title,Description,Status)
        VALUES ('$UserID','Request Released','Released Request','Released')";
        $mysqli->query($queryNotification);

        $result = $RequestID;
    }
    else{
        $result = "Error";
    }

    echo json_encode($result);
?>