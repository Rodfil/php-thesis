<?php
    session_start();
    require("../connection/db.php");
    $ReceiveDate = $_POST['ReceiveDate'];
    $RequestFormID = $_POST['RequestFormID'];
    $PaymentID = $_POST['PaymentID'];
    $UserID = $_POST['UserID'];
    $ReleasedBy = $_SESSION['UserID'];
    $result = "";
    $query = "UPDATE request_form SET ReceiveDate = '$ReceiveDate', Status = 3 WHERE ID = $RequestFormID";
    if ($mysqli->query($query)) {

        $queryNotification = "INSERT INTO notification(UserID,Title,Description,Status)
        VALUES ('$UserID','Appointment Update','Plotted appointment','Approved')";
        $mysqli->query($queryNotification);

        $queryPayment = "UPDATE payment SET Status = 1 WHERE ID = $PaymentID";
        $mysqli->query($queryPayment);
        $result = $PaymentID;
    }
    else{
        $result = "Error";
    }

    echo json_encode($result);
?>