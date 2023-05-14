<?php
    session_start();
    require("../connection/db.php");
    $Firstname = $_POST['Firstname'];
    $Lastname = $_POST['Lastname'];
    $Birthdate = $_POST['Birthdate'];
    $RegistrationStatus = $_POST['RegistrationStatus'];
    $Address = $_POST['Address'];
    $EmailAddress = $_POST['EmailAddress'];
    $UserID = $_POST['UserID'];

    $result = "";

    $query = "
    UPDATE users SET 
        Firstname = '$Firstname',
        Lastname = '$Lastname',
        Birthdate = '$Birthdate',
        RegistrationStatus = '$RegistrationStatus',
        Address = '$Address',
        EmailAddress = '$EmailAddress'
    WHERE ID = $UserID";
    if ($mysqli->query($query)) {
        $result = $UserID;
    }
    else{
        $result = "Error";
    }

    echo json_encode($result);
?>