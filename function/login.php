<?php
    require("../connection/db.php");

    $result = array();
    $Email = $_POST['Email'];
    $Password = md5($_POST['Password']);
	$query = "SELECT * FROM users WHERE EmailAddress = '$Email' AND Password = '$Password'";
	if ($result = $mysqli->query($query)) {
        if ($result->num_rows > 0)	{
            $row = $result->fetch_array();
            if($row['Status'] == 0 && $row['UserType'] == "Client"){
                $result = array(
                    "Result" => "Exists"
                );
            }
            else if($row['Status'] == 2 && $row['UserType'] == "Client"){
                $result = array(
                    "Result" => "Declined"
                );
            }
            else{
                session_start();
                $_SESSION['UserID'] = $row['ID'];
                $_SESSION['Firstname'] = $row['Firstname'];
                $_SESSION['Lastname'] = $row['Lastname'];
                $_SESSION['EmailAddress'] = $row['EmailAddress'];
                $_SESSION['UserType'] = $row['UserType'];
                $result = array(
                    "Result" => "Success",
                    "UserType"  => $row['UserType']
                );
            }
        }
        else{
            $result = array(
                "Result" => "Error"
            );
        }
	}
    echo json_encode($result);
?>