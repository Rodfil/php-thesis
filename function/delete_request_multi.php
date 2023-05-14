<?php
    require("../connection/db.php");
    $result = "";
    foreach($_POST['data'] as $list){
        $RecordID = $list['RecordID'];
        $query = "DELETE FROM request_form WHERE ID = $RecordID";
        if ($mysqli->query($query)) {
            $result = $RecordID;
        }
        else{
            $result = "Error";
        }
    }
    echo json_encode($result);
?>