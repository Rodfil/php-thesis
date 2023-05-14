<?php
    session_start();
    require("../connection/db.php");
    $RecordID = $_POST['RecordID'];
    $result = "";
    $query = "DELETE FROM request_form WHERE ID = $RecordID";
    if ($mysqli->query($query)) {
        $result = $RecordID;
    }
    else{
        $result = "Error";
    }
    echo json_encode($result);
?>