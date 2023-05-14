<?php
    session_start();
    require("../connection/db.php");
    $RequestFormID = $_POST['RequestFormID'];
    $Amount = $_POST['Amount'];
    $PaymentMethod = $_POST['PaymentMethod'];
    $ReferenceNo = $_POST['ReferenceNo'];
    $UserID = $_POST['UserID'];
  
    $result = "";
    $IsExists = 0;
    $query = "SELECT COUNT(*) AS cnt FROM payment WHERE ReferenceNo = '$ReferenceNo'";
	if ($result = $mysqli->query($query)) {
        if ($result->num_rows > 0)	{
            $row = $result->fetch_array();
            $IsExists = $row['cnt'];
        }
	}
    if ($IsExists == 0){
        $query = "INSERT INTO payment(RequestFormID,Amount,PaymentMethod,ReferenceNo)
        VALUES ('$RequestFormID','$Amount','$PaymentMethod','$ReferenceNo')";
        if ($mysqli->query($query)) {
            $result = $mysqli->insert_id;

            $queryNotification = "INSERT INTO notification(UserID,Title,Description,Status)
            VALUES ('$UserID','Payment Update','$PaymentMethod','Pending')";
            $mysqli->query($queryNotification);
    
            $queryUpdate = "UPDATE request_form SET Status = 2 WHERE ID = $RequestFormID";
            $mysqli->query($queryUpdate);
        }
        else{
            $result = "Error";
        }
    }
    else{
        $result = "Exists";
    }
    echo json_encode($result);
?>