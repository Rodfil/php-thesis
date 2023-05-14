<?php
    session_start();
    require("../connection/db.php");
    $RecordID = $_POST['RecordID'];
    $UserID = $_POST['UserID'];
    $DocumentID = $_POST['DocumentID'];
    $DocumentName = $_POST['DocumentName'];
    $Purpose = $_POST['Purpose'];
    $ReferenceNo = 'REF'.date('Ymdhis');
  
    $result = "";

    if($RecordID == 0){
        $query = "INSERT INTO request_form(UserID,DocumentID,Purpose,ReferenceNo)
        VALUES ('$UserID','$DocumentID','$Purpose','$ReferenceNo')";
    }
    else{
        $query = "
        UPDATE request_form SET
            DocumentID = $DocumentID,
            Purpose = '$Purpose'
        WHERE ID = $RecordID";
    }
    if ($mysqli->query($query)) {
        $queryNotification = "INSERT INTO notification(UserID,Title,Description,Status)
        VALUES ('$UserID','Document Request','$DocumentName','Pending')";
        $mysqli->query($queryNotification);

        $result = $mysqli->insert_id;
    }
    else{
        $result = "Error";
    }
    echo json_encode($result);
?>