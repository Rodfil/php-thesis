<?php
    require("../connection/db.php");
    $resultArray = $_POST['resultArray'];
    $result = "";
    foreach($resultArray as $list){

        $ID = $list['RecordID'];
        $DocumentID = $list['DocumentID'];
        $Description = $list['Description'];

        if($ID == 0){
            $query = "INSERT INTO requirements(DocumentID,Description)
            VALUES ('$DocumentID','$Description')";
    
            if ($mysqli->query($query)) {
                $result = $mysqli->insert_id;
            }
            else{
                $result = "Error";
            }
        }
        else{
            $query = "UPDATE requirements SET DocumentID = '$DocumentID', Description = '$Description' WHERE ID = $ID";
            if ($mysqli->query($query)) {
                $result = $ID;
            }
            else{
                $result = "Error";
            }
        }

    }
    echo json_encode(1);
?>