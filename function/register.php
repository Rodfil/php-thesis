<?php
    require("../connection/db.php");

    $Firstname = $_POST['Firstname'];
    $Lastname = $_POST['Lastname'];
    $Gender = $_POST['Gender'];
    $Birthdate = $_POST['Birthdate'];
    $RegistrationStatus = $_POST['RegistrationStatus'];
    $Address = $_POST['Address'];
    $EmailAddress = $_POST['EmailAddress'];
    $ContactNo = $_POST['ContactNo'];
    $Password = md5($_POST['Password']);
    $UserType = "Client";
    $result = "";

    $IsExists = 0;
    $query = "SELECT COUNT(*) AS cnt FROM users WHERE EmailAddress = '$EmailAddress'";
	if ($result = $mysqli->query($query)) {
        if ($result->num_rows > 0)	{
            $row = $result->fetch_array();
            $IsExists = $row['cnt'];
        }
	}
    if($IsExists == 0){
        $query = "INSERT INTO users(Firstname,Lastname,Gender,Birthdate,RegistrationStatus,Address,EmailAddress,ContactNo,Password,UserType)
        VALUES ('$Firstname','$Lastname','$Gender','$Birthdate','$RegistrationStatus','$Address','$EmailAddress','$ContactNo','$Password','$UserType')";
        if ($mysqli->query($query)) {
            $result = "Success";
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