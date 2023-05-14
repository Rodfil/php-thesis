<?php
    session_start();
    require("../connection/db.php");
    $ID = $_POST['ID'];
    $DocumentName = $_POST['DocumentName'];
    $Price = $_POST['Price'];
    $IsVoter = $_POST['IsVoter'];
    $IsNonVoter = $_POST['IsNonVoter'];
  
    $result = "";

    if($ID == 0){
        $query = "INSERT INTO document_list(DocumentName,Price,IsVoter,IsNonVoter)
        VALUES ('$DocumentName','$Price','$IsVoter','$IsNonVoter')";

        if ($mysqli->query($query)) {
            $result = $mysqli->insert_id;
        }
        else{
            $result = "Error";
        }
    }
    else{
        $query = "UPDATE document_list SET DocumentName = '$DocumentName', Price = '$Price', IsVoter = '$IsVoter', IsNonVoter = '$IsNonVoter' WHERE ID = $ID";
        if ($mysqli->query($query)) {
            $result = $ID;
        }
        else{
            $result = "Error";
        }
    }


    echo json_encode($result);
?>