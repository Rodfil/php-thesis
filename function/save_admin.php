<?php
    session_start();
    require("../connection/db.php");
    $ID = $_POST['ID'];
    $Firstname = $_POST['Firstname'];
    $Lastname = $_POST['Lastname'];
    $Gender = $_POST['Gender'];
    $Birthdate = $_POST['Birthdate'];
    $UserType = $_POST['UserType'];
    $EmailAddress = $_POST['EmailAddress'];
    $Password = md5($_POST['Password']);
    $RegistrationStatus = "Registered Voter";
    
    $result = "";

    if($ID == 0){
        $query = "INSERT INTO users(Firstname,Lastname,Gender,Birthdate,EmailAddress,Password,UserType,RegistrationStatus)
        VALUES ('$Firstname','$Lastname','$Gender','$Birthdate','$EmailAddress','$Password','$UserType','$RegistrationStatus')";

        if ($mysqli->query($query)) {
            $result = $mysqli->insert_id;
        }
        else{
            $result = "Error";
        }
    }
    else{
        $query = "
        UPDATE users SET 
            Firstname = '$Firstname', 
            Lastname = '$Lastname', 
            Gender = '$Gender', 
            Birthdate = '$Birthdate', 
            EmailAddress = '$EmailAddress',
            Password = '$Password'
        WHERE ID = $ID";
        if ($mysqli->query($query)) {
            $result = $ID;
        }
        else{
            $result = "Error";
        }
    }


    echo json_encode($result);
?>