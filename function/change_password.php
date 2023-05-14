<?php
    session_start();
    require("../connection/db.php");
    $Password = $_POST['Password'];
    $UserID = $_POST['UserID'];

    $result = "";

    $query = "UPDATE users SET Password = '$Password' WHERE ID = $UserID";
    if ($mysqli->query($query)) {
        $result = $UserID;
    }
    else{
        $result = "Error";
    }

    echo json_encode($result);
?>